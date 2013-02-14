<?php if (count($this->subs) > 0) : ?>
<div class="goods-subcategories">
	<?php foreach ($this->subs as $item) : ?>
		<a class="goods-subcategories-item" href="/<?php echo $this->path;?>/<?php echo $item->titleAlias;?>">
			<?php 
				echo $this->image(ltrim($item->image, '/'))->resizeToCrop(50, 50);
			?>
			<span><?php echo $item->title; ?></span>
		</a>
	<?php endforeach; ?>
	<div class="clear"></div>
</div>
<?php endif; ?>