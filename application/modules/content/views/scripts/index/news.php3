<div class="news">
	<h1><?php echo $this->pTitle;?></h1>
	
	<?php echo $this->Content()->subcategories($this->pId, $this->path); ?>
	
	<?php foreach ($this->items as $item) : ?>
	<div class="news-item">
		<?php if ($item->image != '') : ?>
		<a class="news-item-img" href="/<?php echo $this->path; ?>/<?php echo $item->id; ?>">
		<?php 
			echo $this->image(ltrim($item->image, '/'))->resizeToCrop(100, 100);
		?>
		</a>
		<?php endif;?>
		<div class="news-item-wr">
			<a class="news-item-wr-title" href="/<?php echo $this->path; ?>/<?php echo $item->id; ?>"><?php echo $item->title; ?></a>
			<div class="news-item-wr-introtext"><?php echo $item->introtext; ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	
</div>