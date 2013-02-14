<div class="last-news">
	<div class="last-news-title">Последние новости</div>
	<?php if (count($this->news) > 0) : ?>
	<ul>
		<?php foreach ($this->news as $item) : ?>
		<li>
			<div class="img"><a href="<?php echo $this->cats[$item->parentId]['path']; ?>/<?php echo $item->id; ?>"><?php echo $this->image(ltrim($item->image, '/'))->resizeToCrop(150, 100); ?></a></div>
			<a class="title" href="<?php echo $this->cats[$item->parentId]['path']; ?>/<?php echo $item->id; ?>"><?php echo $item->title;?></a>
			<div class="introtext"><?php echo $item->introtext; ?></div>
		</li>
		<?php endforeach; ?>
	</ul>
	<div class="clear"></div>
	<?php endif; ?>	
</div>