<div class="employees">
	<h1><?php echo $this->pTitle;?></h1>
	
	<?php echo $this->Content()->subcategories($this->pId, $this->path); ?>
	
	<?php foreach ($this->items as $item) : ?>
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
	<?php endforeach; ?>
	
</div>