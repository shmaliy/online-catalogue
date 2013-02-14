<div class="goods-item-container">
	<h1><?php echo $this->item->title; ?></h1>
	<div class="goods-item-container-image">
		<?php echo $this->image(ltrim($this->item->image, '/'))->resizeToWidth(200); ?>
	</div>
	<div class="goods-item-container-desc">
		<div class="goods-item-container-desc-art">Артикул <?php echo $this->item->param1; ?></div>
		<div class="goods-item-container-desc-text"><?php echo $this->item->introtext; ?></div>
	</div>
	<div class="clear"></div>
</div>