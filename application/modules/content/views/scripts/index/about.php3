<div class="news">
	<h1><?php echo $this->pTitle;?></h1>
	
	<?php echo $this->Content()->subcategories($this->pId, $this->path); ?>
	
	<?php foreach ($this->items as $item) : ?>
	<div class="news-item">
		<?php if ($item->image != '') : ?>
		<div class="news-item-img">
		<?php 
			echo $this->image(ltrim($item->image, '/'))->resizeToCrop(100, 100);
		?>
		</div>
		<?php endif;?>
		<div class="news-item-wr">
			<div class="news-item-wr-title"><?php echo $item->title; ?></div>
			<div class="news-item-wr-introtext"><?php echo $item->introtext; ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	
</div>