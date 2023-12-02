<?php
// Check to ensure this file is included in Joomla!
defined("_JEXEC") or die("Restricted access");

/* Let's see if we found the product */
if (empty($this->product)) {
	echo vmText::_("COM_VIRTUEMART_PRODUCT_NOT_FOUND");
	echo "<br /><br />  " . $this->continue_link_html;
	return;
}
?>

<h1 style="padding-left: 50px"><?php echo $this->product->product_name; ?></h1>

<div class="product-container productdetails-view productdetails">

	<?php
 // afterDisplayTitle Event
 echo $this->product->event->afterDisplayTitle;

 // Show "ontop" custom fields
 echo shopFunctionsF::renderVmSubLayout("customfields", ["product" => $this->product, "position" => "ontop"]);
 ?>

	<div class="vm-product-container" style="display: flex";>
		<div class="vm-product-media-container">
			<?php
   echo $this->loadTemplate("images");
   $count_images = count($this->product->images);
   if ($count_images > 1) {
   	echo $this->loadTemplate("images_additional");
   }
   ?>
		</div>

		<div class="vm-product-details-container">
			<div class="spacer-buy-area">
				<?php
    foreach ($this->productDisplayTypes as $type => $productDisplayType) {
    	foreach ($productDisplayType as $productDisplay) {
    		foreach ($productDisplay as $virtuemart_method_id => $productDisplayHtml) { ?>
								<div class="<?php echo substr($type, 0, -1); ?> <?php echo substr($type, 0, -1) . "-" . $virtuemart_method_id; ?>">
									<?php echo $productDisplayHtml; ?>
								</div>
				<?php }
    	}
    }

    echo shopFunctionsF::renderVmSubLayout("prices", ["product" => $this->product, "currency" => $this->currency]);
	echo "<div style='font-size: smaller'>Exclusief verzendkosten</div>";
    echo shopFunctionsF::renderVmSubLayout("addtocart", ["product" => $this->product]);
    echo shopFunctionsF::renderVmSubLayout("stockhandle", ["product" => $this->product]);
	echo "<div class='product-fields'>Voor 22:00 besteld, volgende werkdag verstuurd</div>";
	echo shopFunctionsF::renderVmSubLayout("customfields", ["product" => $this->product, "position" => "tags"]);

    if (VmConfig::get("show_manufacturers", 1) && !empty($this->product->virtuemart_manufacturer_id)) {
    	echo $this->loadTemplate("manufacturer");
    }
    ?>
		<div class="product-short-description">
			<?php echo $this->product->product_s_desc; ?>
		</div>
			</div>
		</div>
</div>

<?php
// event onContentBeforeDisplay
echo $this->product->event->beforeDisplayContent;

// Product Description
if (!empty($this->product->product_desc)) { ?>
		<div class="product-description" id="product-description" >
			<?php echo $this->product->product_desc; ?>
		</div>
	<?php }
// Product Description END

echo shopFunctionsF::renderVmSubLayout("customfields", ["product" => $this->product, "position" => "tags"]);
echo shopFunctionsF::renderVmSubLayout("customfields", ["product" => $this->product, "position" => "onbot"]);
echo shopFunctionsF::renderVmSubLayout("customfields", [
	"product" => $this->product,
	"position" => "related_products",
	"class" => "product-related-products",
	"customTitle" => true,
]);
echo shopFunctionsF::renderVmSubLayout("customfields", [
	"product" => $this->product,
	"position" => "related_categories",
	"class" => "product-related-categories",
]);

// onContentAfterDisplay event
echo $this->product->event->afterDisplayContent;

$j = 'jQuery(document).ready(function($) {
			$("form.js-recalculate").each(function(){
				if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
					var id= $(this).find(\'input[name="virtuemart_product_id[]"]\').val();
					Virtuemart.setproducttype($(this),id);
				}
			});
		});';

if (VmConfig::get("jdynupdate", true)) {
	$j = "jQuery(document).ready(function($) {
				Virtuemart.stopVmLoading();
				var msg = '';
				$('a[data-dynamic-update=\"1\"]').off('click', Virtuemart.startVmLoading).on('click', {msg:msg}, Virtuemart.startVmLoading);
				$('[data-dynamic-update=\"1\"]').off('change', Virtuemart.startVmLoading).on('change', {msg:msg}, Virtuemart.startVmLoading);
			});";

	vmJsApi::addJScript("vmPreloader", $j);
}

echo vmJsApi::writeJS();

if ($this->product->prices["salesPrice"] > 0) {
	echo shopFunctionsF::renderVmSubLayout("snippets", [
		"product" => $this->product,
		"currency" => $this->currency,
		"showRating" => $this->showRating,
	]);
}
?>
</div>
