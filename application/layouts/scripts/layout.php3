<?php echo $this->doctype('XHTML1_TRANSITIONAL'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php $this->headTitle('Online catalogue')->setSeparator(' | '); ?>

<?php //$this->headLink()->appendStylesheet('/theme/css/style.css');
//       $this->headLink()->appendStylesheet('/theme/css/style.less')
// 					   ->headLink(array('rel' => 'favicon', 'href' => '/favicon.png'), 'PREPEND'); ?>
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
<link rel="stylesheet/less" type="text/css" href="/theme/css/style.less">
<?php
	$this->headScript()->appendFile('/js/jquery-1.8.1.min.js');
	$this->headScript()->appendFile('/js/less.min.js');
	echo $this->headScript();
?>

<script>
var parser = new(less.Parser)({
    paths: ['/theme/css'], // указывает пути поиска для директив @import
    filename: 'style.less' // указывает имя файла, для улучшения сообщений об ошибках
});
</script>

</head>
<body>
<div class="header">
    <div class="header-resize">
    	<div class="main-menu"><?php echo $this->action('index', 'index', 'menu'); ?></div>
    </div>
</div>
<div class="body">
	<div class="push1"></div>
		<div>
			<?php
	        echo $this->navigation(Zend_Registry::get('NAVIGATION'))
	           	      ->breadcrumbs()->setMinDepth(1)->render();
  			?>
		</div>
		<?php echo $this->layout()->content;?>
    <div class="push2"></div>    
</div>
<div class="footer">
	<div class="footer-resize">
		
	</div>
</div>
</body>
</html>