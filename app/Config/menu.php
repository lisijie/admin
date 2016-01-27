<?php
/**
 * 功能菜单配置
 */

return [
	[
		'name' => '系统管理',
		'icon' => 'fa-cog',
		'route' => '#',
		'submenu' => [
			['name'=>'个人信息', 'route'=>'system/profile'],
			['name'=>'账号管理', 'route'=>'system/account'],
		],
	],
];