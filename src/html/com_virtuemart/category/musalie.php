<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link https://virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 10682 2022-06-28 13:23:55Z Milbo $
 */

defined ('_JEXEC') or die('Restricted access');

if (vRequest::getInt('dynamic',false) and vRequest::getInt('virtuemart_product_id',false)) {
	if (!empty($this->products)) {
		if($this->fallback){
			$p = $this->products;
			$this->products = array();
			$this->products[0] = $p;
			vmdebug('Refallback');
		}

		echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$this->products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating));

	}

	return ;
}
?> <div class="category-view"> <?php
$js = "
jQuery(document).ready(function ($) {
	$('.orderlistcontainer').hover(
		function() { $(this).find('.orderlist').stop().show()},
		function() { $(this).find('.orderlist').stop().hide()}
	)
});
";
vmJsApi::addJScript('vm-hover',$js);
?>

<?php if (!empty($this->category->category_name)) { ?>
<h1><?php echo vmText::_($this->category->category_name); ?></h1>
<?php } ?>

<?php if (!empty($this->showcategory_desc) and empty($this->keyword)){
	if(!empty($this->category)) {
	?>
<div class="category_description">
	<?php echo $this->category->category_description; ?>
</div>
<?php }
}

// Show child categories
if ($this->showcategory and empty($this->keyword)) {
	if (!empty($this->category->has_children)) {
		echo ShopFunctionsF::renderVmSubLayout('categories',array('categories'=>$this->category->children, 'categories_per_row'=>$this->categories_per_row));
	}
}

if (!empty($this->products) or ($this->showsearch or $this->keyword !== false)) {
?>
<div class="browse-view">
<?php // Show child categories

	if (!empty($this->products)) {
		//revert of the fallback in the view.html.php, will be removed vm3.2
		if($this->fallback){
			$p = $this->products;
			$this->products = array();
			$this->products[0] = $p;
			vmdebug('Refallback');
		}

	echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$this->products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating));

	if(!empty($this->orderByList)) { ?>
		<div class="vm-pagination vm-pagination-bottom"><?php echo $this->vmPagination->getPagesLinks (); ?><span class="vm-page-counter"><?php echo $this->vmPagination->getPagesCounter (); ?></span></div>
	<?php }
}
?>
</div>

<?php } ?>
</div>

<!-- end browse-view -->
