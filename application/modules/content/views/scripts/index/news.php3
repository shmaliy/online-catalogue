<div class="news">
	<h1><?php echo $this->pTitle;?></h1>
	
	<?php foreach ($this->items as $item) : ?>
	<div class="news-item">
		<a class="news-item-img" href="/<?php echo $this->path; ?>/<?php echo $item->id; ?>">
		<?php 
			//echo $item->image;
			echo $this->image(ltrim($item->image, '/'))->resizeToCrop(100, 100);
		?>
		</a>
		<a class="news-item-title" href="/<?php echo $this->path; ?>/<?php echo $item->id; ?>"><?php echo $item->title; ?></a>
		<div class="news-item-introtext"><?php echo $item->introtext; ?></div>
	</div>
	<?php endforeach; ?>
	
</div>