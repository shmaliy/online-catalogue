<?php
//echo implode('', $GLOBALS['runTrace']);
?>
<?php echo $this->doctype() ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php 
	$this->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=windows-1251');
	echo $this->headMeta();
	?>
	<?php
	$this->headLink()->appendStylesheet('/theme/css/style.css');
	$this->headLink()->appendStylesheet('/js/sliderCatalogue/sliderCatalogue.css');
	$this->headLink()->headLink(array('rel' => 'SHORTCUT ICON', 'href' => '/favicon.png'), 'PREPEND');
	echo $this->headLink();
	?>
	<?php
	$this->headScript()->appendFile('/js/prototype/prototype.js');
	$this->headScript()->appendFile('/js/scriptaculous/scriptaculous.js');
	$this->headScript()->appendFile('/js/sliderCatalogue/sliderCatalogue.js');
	$this->headScript()->appendFile('/js/imageSwapper.js');
	echo $this->headScript();
    ?>
	<?php
	$this->headTitle('soundwind.com.ua');
	$this->headTitle()->setSeparator(' // ');
	echo $this->headTitle();
    ?>
</head>
<body>
	<div class="header">
		<div class="header_resize">
			
		</div>
	</div>
	<div class="body">
		<div class="push1"></div>
		
			<?php echo $this->layout()->content; ?>
		
		</div>
		<div class="push2"></div>
	</div>
	<div class="footer">
		<div class="footer_resize">
			
		</div>
	</div>	
</body>
</html>

