<?php echo $this->doctype('XHTML1_TRANSITIONAL'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php $this->headTitle('Catalogue')->setSeparator(' | '); ?>

<?php $this->headLink()->appendStylesheet('/theme/css/style.css')
					   ->headLink(array('rel' => 'favicon', 'href' => '/favicon.png'), 'PREPEND'); ?>
<?
	$this->headMeta()->appendName('keywords', '')
                     ->appendName('description', '')
                     ->appendName('robots', 'index, follow')
                     ->appendName('revisit', 'after 1 days')
					 ->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8')
                     ->appendName('document-state', 'dynamic');					 					 					 		
?>
<?php echo $this->headMeta();?>
<?php echo $this->headTitle(); ?>
<?php echo $this->headLink(); ?>

<?php
	$this->headScript()->appendFile('/js/script.js');
	echo $this->headScript();
?>
</head>
<body>
<div class="header">
    <div class="header_resize">
    <div class="mainmenu"><?php echo $this->action('index', 'index', 'menu', array('alias' => 'mainmenu')); ?></div>	
    </div>
</div>
<div class="body">
	<div class="push1"></div>
		<?php echo $this->layout()->content;?>
    <div class="push2"></div>    
</div>
<div class="footer">
	<div class="footer_resize">
		
	</div>
</div>
</body>
</html>