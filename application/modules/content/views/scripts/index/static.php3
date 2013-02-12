<div class="static">
	<div class="static-title"><?php echo $this->item->title;?></div>
	
	<?php if ($this->item->introtext != '') : ?>
	<div class="static-text"><?php echo $this->item->introtext;?></div>
	<?php endif; ?>
</div>