<?php
/**
 * 功能菜单配置
 */
return [
	[
		'name' => '系统管理',
		'icon' => 'fa-cog',
		'route' => '#',
        'show' => true,
		'submenu' => [
			['name'=>'个人信息', 'route'=>'system/profile/index', 'show' => true],
			['name'=>'账号管理', 'route'=>'system/admin/list', 'show' => true],
			['name'=>'添加账号', 'route'=>'system/admin/add', 'show' => false],
			['name'=>'编辑账号', 'route'=>'system/admin/edit', 'show' => false],
			['name'=>'删除账号', 'route'=>'system/admin/del', 'show' => false],
		],
	],
];