<div class="employees">
	<h1><?php echo $this->pTitle;?></h1>
	
	<?php echo $this->Content()->subcategories($this->pId, $this->path); ?>
	<?php $i = 0; ?>
	<?php foreach ($this->items as $item) : ?>
	<?php $i++; ?>
	<div class="employees-item">
		<?php if ($item->image != '') : ?>
		<div class="employees-item-img">
		<?php 
			echo $this->image(ltrim($item->image, '/'))->resizeToCrop(100, 150);
		?>
		</div>
		<?php endif;?>
		<div class="employees-item-wr">
			<div class="employees-item-wr-title"><?php echo $item->title; ?></div>
			<div class="employees-item-wr-introtext"><?php echo $item->introtext; ?></div>
		</div>
		<div class="clear"></div>
	</div>
		<?php if ($i == 2) : ?>
		<div class="clear"></div>
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="clear"></div>
</div>