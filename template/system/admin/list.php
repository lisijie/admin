<div class="row">
    <div class="col-xs-12">

        <div class="row">
            <div class="col-xs-12">
                <a href="<?= URL('system/admin/add') ?>" class="btn btn-sm btn-default"><i
                            class="fa fa-user"></i> 添加帐号</a>
            </div>
        </div>

        <div class="space-4"></div>

        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>昵称</th>
                        <th>最后登录</th>
                        <th>最后登录IP</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($adminList as $r) : ?>
                        <tr>
                            <td class="center"><?= $r['id'] ?></td>
                            <td><?= $r['email'] ?></td>
                            <td><?= $r['nickname'] ?></td>
                            <td><?= $r['last_login'] ? date('Y-m-d H:i:s', $r['last_login']) : '-' ?></td>
                            <td><?= $r['last_ip'] ?></td>
                            <td><a href="<?= URL('system/admin/edit', ['id' => $r['id']]) ?>">编辑</a> | <a
                                        href="<?= URL('system/admin/del', ['id' => $r['id']]) ?>"
                                        class="delete_confirm">删除</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12"><?= $pageBar ?></div>
        </div>
    </div>
</div>
