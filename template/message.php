<div class="row">
	<div class="col-xs-12">

		<div class="error-container">
			<div class="well">
				<h1 class="grey lighter smaller">
					<span class="blue bigger-125">
						<i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i>
					</span>
					出错了！
				</h1>

				<hr />
				<h3 class="lighter smaller"><?php echo $msg?></h3>

				<hr />
				<div class="space"></div>

				<div class="center">
					<a href="<?php echo $redirect ? $redirect : 'javascript:history.back()'?>" class="btn btn-grey">
						<i class="ace-icon fa fa-arrow-left"></i>
						返回
					</a>
				</div>
			</div>
		</div>

	</div>
</div>