<div class="row">
	<div class="col-xs-12">

		<div class="row">
			<div class="col-xs-12">
			<a href="<?php echo URL(CUR_ROUTE, ['do'=>'addadmin'])?>" class="btn btn-sm btn-default"><i class="fa fa-user"></i> 添加帐号</a>
			</div>
		</div>

		<div class="space-4"></div>

		<div class="row">
			<div class="col-xs-12">
				<table class="table table-striped table-bordered table-hover">
					<thead>
					<tr>
						<th>ID</th>
						<th>账号</th>
						<th>姓名</th>
						<th>邮箱</th>
						<th>最后登录</th>
						<th>最后登录IP</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($adminList as $r) :?>
						<tr>
							<td class="center"><?php echo $r['id']?></td>
							<td><?php echo $r['user_name']?></td>
							<td><?php echo $r['real_name']?></td>
							<td><?php echo $r['email']?></td>
							<td><?php echo $r['last_login'] ? date('Y-m-d H:i:s',$r['last_login']) : '-'?></td>
							<td><?php echo $r['last_ip']?></td>
							<td><a href="<?php echo URL('system/account', ['do'=>'editadmin','id'=>$r['id']])?>">编辑</a> | <a href="<?php echo URL('system/account', ['do'=>'deladmin','id'=>$r['id']])?>" class="delete_confirm">删除</a> </td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12"><?php echo $pageBar?></div>
		</div>
	</div>
</div>
