<?php foreach ($this->tree as $key=>$item) : ?>
	<?php if (count($item->getExtend($key)) > 0) :?>	
		<ul class="main-menu-ul">
		<?php foreach ($item->getExtend($key) as $ekey=>$eitem) : ?>	
			<li class="main-menu-ul-li">
				<a href="<?php echo $eitem->link;?>"><?php echo $eitem->title;?></a>
				<?php echo $this->partial(
						'submenu.php3', 
						array("key" => $ekey, 'item' => $eitem)
				);?>
			</li>
		<?php endforeach;?>
		</ul>
	<?php endif; ?>
<?php endforeach; ?>
<div class="clear"></div>	