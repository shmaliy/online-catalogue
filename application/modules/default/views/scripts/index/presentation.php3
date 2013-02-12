<div class="presentation">
	<div class="presentation-title"><?php echo $this->item->title;?></div>
	
	<?php if ($this->item->introtext != '') : ?>
	<div class="presentation-text"><?php echo $this->item->introtext;?></div>
	<?php endif; ?>
	
	<?php if ($this->item->fulltext != '') : ?>
	<div class="presentation-text"><?php echo $this->item->fulltext;?></div>
	<?php endif; ?>
</div>