<?php
	defined('_JEXEC') or die('Restricted access');

	use Joomla\CMS\Factory;

	$app = Factory::getApplication();
	$menu = $app->getMenu();
	$lang = $app->getLanguage();
	$wa = $this->getWebAssetManager();

	if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
		$wa->useStyle('template.musalie.home');
	}
	else {
		$wa->useStyle('template.musalie.base');
	}
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
			<nav>
				<jdoc:include type="modules" name="navigation" style="html5" />
			</nav>
		</header>
		<main>
<?php	if ($menu->getActive() == $menu->getDefault($lang->getTag())) { ?>
			<div class="home">
				<jdoc:include type="modules" name="home" style="html5" />
			</div>
<?php	}	?>
			<jdoc:include type="component" />
		</main>
		<footer>
			<jdoc:include type="modules" name="footer" style="html5" />
		</footer>
	</body>
</html>
