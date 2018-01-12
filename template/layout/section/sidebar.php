<div id="sidebar" class="sidebar responsive">
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	</script>
	<ul class="nav nav-list">
		<li class="<?php echo (CUR_ROUTE == 'main/index') ? 'active' : ''?>">
			<a href="/">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> 系统概况 </span>
			</a>

			<b class="arrow"></b>
		</li>

		<?php foreach ($menuList as $menu):?>
		<li class="<?php echo $menu['active']?>">
			<a href="<?php echo URL($menu['route'])?> " class="dropdown-toggle">
				<i class="menu-icon fa <?php echo $menu['icon']?>"></i>
				<span class="menu-text"> <?php echo $menu['name']?> </span>

				<b class="arrow fa fa-angle-down"></b>
			</a>
			<b class="arrow"></b>
			<ul class="submenu">
				<?php foreach ($menu['submenu'] as $sub):?>
				<li class="<?php echo $sub['active']?>">
					<a href="<?php echo URL($sub['route'])?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php echo $sub['name']?>
					</a>
					<b class="arrow"></b>
				</li>
				<?php endforeach;?>
			</ul>
		</li>
		<?php endforeach;?>

	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>

	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
	</script>
</div>