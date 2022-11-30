<?php
	defined('_JEXEC') or die('Restricted access');

	$wa = $this->getWebAssetManager();
	$wa->useStyle('template.musalie.base');
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" >
   <head>
		<jdoc:include type="metas" />
		<jdoc:include type="styles" />
		<jdoc:include type="scripts" />

<?php
		// Set viewport
		$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
?>
	</head>
	<body>
		<header>
			<div class="logo">
				<a href="" alt="Home"><img src="media/templates/site/musalie/images/musalie.jpg" alt="Logo" /></a>
			</div>
		</header>
	</body>
</html>
