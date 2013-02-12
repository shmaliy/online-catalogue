<div class="static">
	<h1><?php echo $this->item->title;?></h1>
	
	<?php if ($this->item->introtext != '') : ?>
	<div class="static-text"><?php echo $this->item->introtext;?></div>
	<?php endif; ?>
</div>