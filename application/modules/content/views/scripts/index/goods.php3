<div class="goods">
	<h1><?php echo $this->pTitle;?></h1>
	<?php echo $this->Content()->subcategories($this->pId, $this->path, 'goods'); ?>
	
	<?php foreach ($this->items as $item) : ?>
	<div class="goods-item">
		<?php if ($item->image != '') : ?>
		<a class="goods-item-img" href="/<?php echo $this->path; ?>/<?php echo $item->id; ?>">
		<?php 
			echo $this->image(ltrim($item->image, '/'))->resizeToWidth(100);
		?>
		</a>
		<?php endif;?>
		<div class="goods-item-wr">
			<a class="goods-item-wr-title" href="/<?php echo $this->path; ?>/<?php echo $item->id; ?>"><?php echo $item->title; ?></a>
			<div class="goods-item-wr-introtext"><?php echo $item->introtext; ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	
</div>