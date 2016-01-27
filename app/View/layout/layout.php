<?php $this->section('header')?>

<?php $this->section('navbar')?>

	<div class="main-container" id="main-container">
		<script type="text/javascript">
			try{ace.settings.check('main-container' , 'fixed')}catch(e){}
		</script>

		<!--左侧菜单-->
		<?php $this->section('sidebar')?>
		<!--/左侧菜单-->

		<!--页面主体-->
		<div class="main-content">
		<div class="main-content-inner">
		<div class="breadcrumbs" id="breadcrumbs">
			<script type="text/javascript">
				try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
			</script>

			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="/">首页</a>
				</li>
				<li class="active"><?php echo $pageName?></li>
			</ul><!-- /.breadcrumb -->

		</div>

		<div class="page-content">
		<?php $this->content()?>
		</div><!-- /.page-content -->
		</div>
		</div>
		<!-- /.main-content -->
		<!--/页面主体-->

		<div class="footer">
			<div class="footer-inner">
				<div class="footer-content">
					<span class="bigger-120">
						&copy; xxxxx.com 2016
					</span>
				</div>
			</div>
		</div>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
	</div><!-- /.main-container -->

<?php $this->section('footer')?>