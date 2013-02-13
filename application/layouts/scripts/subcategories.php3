<?php if (count($this->subs) > 0) : ?>
<div class="subcategories">
	<div class="subcategories-title">Подкатегории</div>
	<?php foreach ($this->subs as $item) : ?>
		<a class="subcategories-item" href="/<?php echo $this->path;?>/<?php echo $item->titleAlias;?>"><?php echo $item->title; ?></a>
	<?php endforeach; ?>
</div>
<?php endif; ?>