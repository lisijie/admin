<div class="row">
	<div class="col-xs-12">

		<form class="form-horizontal" method="post" action="<?= URL(CUR_ROUTE, ['do'=>'editadmin'])?>">
			<input type="hidden" name="id" value="<?= $adminInfo['id']?>" />
			<div class="form-group">
				<label class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<label class="control-label"><?= $adminInfo['email']?></label>
				</div>
			</div>
            <div class="form-group <?= !empty($error_nickname) ? 'has-error' : '' ?>"">
				<label for="nickname" class="col-sm-2 control-label">昵称</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="nickname" name="nickname" value="<?= $adminInfo['nickname']?>">
				</div>
                <div class="help-block col-xs-12 col-sm-reset inline">
                    <?= !empty($error_nickname) ? $error_nickname : '' ?>
                </div>
			</div>
			<div class="form-group">
				<label for="sex" class="col-sm-2 control-label">性别</label>
				<div class="col-sm-3">
					<div class="radio-inline">
						<label>
							<input type="radio" name="sex" id="sex" value="1" <?= $adminInfo['sex']!=2?'checked':''?>>
							男
						</label>
					</div>
					<div class="radio-inline">
						<label>
							<input type="radio" name="sex" id="sex" value="2" <?= $adminInfo['sex']==2?'checked':''?>>
							女
						</label>
					</div>
				</div>
			</div>
			<div class="form-group <?= !empty($error_password1) ? 'has-error' : ''?>">
				<label for="password1" class="col-sm-2 control-label">新密码</label>
				<div class="col-sm-3">
					<input type="password" class="form-control" id="password1" name="password1" value="<?= $password1?>" />
				</div>
				<div class="help-block col-xs-12 col-sm-reset inline">
					<?= !empty($error_password1) ? $error_password1 : '不修改密码请留空'?>
				</div>
			</div>
			<div class="form-group <?= !empty($error_password2) ? 'has-error' : ''?>">
				<label for="password2" class="col-sm-2 control-label">确认密码</label>
				<div class="col-sm-3">
					<input type="password" class="form-control" id="password2" name="password2">
				</div>
				<div class="help-block col-xs-12 col-sm-reset inline">
					<?= !empty($error_password2) ? $error_password2 : ''?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">权限设置</label>
				<div class="col-sm-10">
					<?php
					foreach ($powerList as $k => $group) {
						echo '<div><label class="control-label bolder blue">'.$group['name'].'</label></div>';
						foreach ($group['list'] as $kk => $row) {
							$id = "p_{$k}_{$kk}";
							$chk = $row['checked'] ? 'checked' : '';
							echo '
							<div class="checkbox-inline">
							<label>
							<input type="checkbox" id="'.$id.'" '.$chk.' name="power[]" value="'.$row['route'].'">
							<span class="lbl">' . $row['name'] . '</span>
							</label>
							</div>';
						}
					}
					?>
				</div>
			</div>


			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-info"><i class="ace-icon fa fa-check bigger-110"></i>提交</button>
					<a href="<?= URL('system/admin/list')?>" class="btn btn-default"><i class="ace-icon fa fa-times bigger-110"></i>取消</a>
				</div>
			</div>
		</form>

	</div>
</div>