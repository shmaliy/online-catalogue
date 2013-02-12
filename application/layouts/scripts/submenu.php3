<?php if (count($this->item->getExtend($this->key)) > 0) :?>
<ul class="main-menu-ul-li-ul">
	<?php foreach ($this->item->getExtend($this->key) as $item) : ?>
	<li class="main-menu-ul-li-ul-li">
		<a href="<?php echo $item->link;?>"><?php echo $item->title;?></a>
	</li>
	<?php endforeach;?>
</ul>
<?php endif; ?>