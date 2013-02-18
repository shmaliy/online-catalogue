<div class="news-item-container">
	<h1><?php echo $this->item->title; ?></h1>
	<div> <?php 
		$options = Zend_Registry::get('options');
		//echo $this->navigation($options['navigation'])->menu(); 
		
		//var_export($options['navigation']);
	?></div>
	<div><?php echo $this->item->fulltext; ?></div>
</div>