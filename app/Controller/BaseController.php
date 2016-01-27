<?php
/**
 * 控制器基类
 *
 * @author jesse.li <lsj86@qq.com>
 */
namespace App\Controller;

use App\Model\AdminModel;
use Core\Controller as Controller;

class BaseController extends Controller
{
	const PAGE_SIZE = 30;

	protected $pageSize = 30;
	protected $adminId = 0;
	protected $userName = '';
	protected $adminSex = 1;
	protected $powers = [];

	public function init()
	{
		$this->initAuth();
		if (CUR_ROUTE != 'main/login') {
			if (!$this->adminId) {
				$this->gotoLoginPage();
			}
			$this->setLayout('layout/layout');
			$this->setLayoutSection('header', 'layout/section/header');
			$this->setLayoutSection('navbar', 'layout/section/navbar');
			$this->setLayoutSection('footer', 'layout/section/footer');
			$this->setLayoutSection('sidebar', 'layout/section/sidebar');
			$this->checkPermission();
			$this->assignGlobalVars();
		}
		if ($this->get('do') == 'export') {
			$this->pageSize = PHP_INT_MAX; // 数据导出
		}
		$this->assign('baseUrl', $this->request->getBaseUrl() . '/');
	}

	// 权限检查
	private function checkPermission()
	{
		if ($this->adminId == 1) return true;
		$whiteList = ['main/index','system/profile', 'main/login', 'main/logout'];
		if (!in_array(CUR_ROUTE, $whiteList) && !in_array(CUR_ROUTE, $this->powers)) {
			\App::abort(403, '抱歉，你没有权限访问该页面');
		}
	}

	// 设置全局模板变量
	private function assignGlobalVars()
	{
		$this->assign('loginUser', array(
			'user_id' => $this->adminId,
			'user_name' => $this->userName,
			'sex' => $this->adminSex,
		));

		$powers = $this->powers;
		// 菜单
		$pageName = '';
		$menuList = \App::conf('menu');
		foreach ($menuList as $k => &$group) {
			$group['active'] = '';
			foreach ($group['submenu'] as $kk => &$submenu) {
				if ($this->adminId > 1 && !in_array($submenu['route'], $powers)) {
					unset($group['submenu'][$kk]);
				}
				$submenu['active'] = '';
				if (CUR_ROUTE == $submenu['route']) {
					$submenu['active'] = 'active';
					$group['active'] = 'active open';
					$pageName = $submenu['name'];
				}
			}
			if (empty($group['submenu'])) unset($menuList[$k]);
		}
		$this->assign(array(
			'menuList' => $menuList,
			'pageName' => $pageName,
		));
	}

	// 登录校验
	private function initAuth()
	{
		$auth = $this->request->cookies()->getDecrypt('auth');
		$ip = ''; // $this->request->getClientIp()
		if (empty($auth) || strpos($auth, '|') === false) {
			return false;
		}
		list($id, $password) = explode('|', $auth);
		$adminInfo = AdminModel::getInstance()->getAdmin($id);
		if (!$adminInfo || md5($adminInfo['password'].$ip) != $password) {
			return false;
		}

		$this->adminId = $adminInfo['id'];
		$this->userName = $adminInfo['user_name'];
		$this->adminSex = $adminInfo['sex'];
		$this->powers = explode(',', $adminInfo['power']);
		return true;
	}

	// 设置登录Cookies
	protected function setLoginAuth($adminId, $password, $remember = 0)
	{
		$ip = ''; //$this->request->getClientIp()
		$auth = "{$adminId}|" . md5($password . $ip);
		$cookie = [
			'value' => $auth,
			'expire' => $remember ? NOW + 86400*7 : 0,
		];

		$this->response->cookies()->setEncrypt('auth', $cookie);
	}

	// 跳转到登录页
	protected function gotoLoginPage()
	{
		header('Location: ' . URL('main/login'));
		exit;
	}

	/**
	 * 将数组转成CSV格式导出
	 *
	 * @param array $data
	 * @param array $header
	 * @param array $fields
	 */
	protected function checkExport($data, $header = [], $fields = [])
	{
		if ($this->get('do') != 'export') {
			return;
		}
		$tmpFile = DATA_PATH . 'export/' . date('YmdHis') . '.csv';

		// 表头
		foreach ($header as &$val) {
			if (strpos($val, ',') !== false || strpos($val, '"') !== false) {
				$val = '"'.str_replace('"','""', $val).'"';
			}
		}
		$line = implode(',', $header);
		$line = mb_convert_encoding($line, 'gbk', 'utf-8');
		file_put_contents($tmpFile, $line . "\r\n", FILE_APPEND);

		// 数据
		foreach ($data as $row) {
			foreach ($row as &$val) {
				if (strpos($val, ',') !== false || strpos($val, '"') !== false) {
					$val = '"'.str_replace('"','""', $val).'"';
				}
			}
			if ($fields) {
				$line = [];
				foreach ($fields as $field) {
					$line[] = $row[$field];
				}
			} else {
				$line = $row;
			}
			$line = implode(',', $line);
			$line = mb_convert_encoding($line, 'gbk', 'utf-8');
			file_put_contents($tmpFile, $line . "\r\n", FILE_APPEND);
		}

		header("Content-type: application/octet-stream");
		header("Accept-Length: " . filesize($tmpFile));
		header("Content-Disposition: attachment; filename=" . basename($tmpFile));
		ob_clean();
		flush();
		readfile($tmpFile);
		unlink($tmpFile);
		exit;
	}

}