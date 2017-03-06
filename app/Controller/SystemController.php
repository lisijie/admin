<?php
/**
 * 系统管理
 *
 * @author jesse.li <jesse@comprame.com>
 */

namespace App\Controller;

use App\Model\AdminModel;
use App\Util\Pager;
use Core\Lib\Strings;

class SystemController extends BaseController
{
	/**
	 * 账号管理
	 */
	public function accountAction()
	{
		$do = $this->get('do');

		switch ($do) {
			case 'editadmin':
				return $this->editAdmin();
			case 'addadmin':
				return $this->addAdmin();
			case 'deladmin':
				return $this->delAdmin();
			default:
				return $this->adminList();
		}
	}

	/**
	 * 个人信息
	 */
	public function profileAction()
	{
		$adminModel = AdminModel::getInstance();
		$session = \App::session();

		if ($this->request->isMethod('post')) {
			$password1 = trim($this->get('password1'));
			$password2 = trim($this->get('password2'));
			$data = [
				'real_name' => trim($this->get('real_name','')),
				'email' => trim($this->get('email','')),
				'sex' => intval($this->get('sex', 1)),
			];
			if (!empty($password1)) {
				if (strlen($password1) < 6) {
					$session->setFlash('error_password1', '密码长度必须大于6位');
					$session->setFlash('password1', $password1);
					return $this->goBack();
				}
				if ($password1 != $password2) {
					$session->setFlash('error_password2', '两次输入的密码不一致');
					$session->setFlash('password1', $password1);
					return $this->goBack();
				}
				$data['salt'] = Strings::random(10);
				$data['password'] = md5($password1 . $data['salt']);
			}

			$adminModel->updateAdmin($this->adminId, $data);
			$session->setFlash('success', 1);
			return $this->redirect(URL(CUR_ROUTE));
		}

		$profile = $adminModel->getAdmin($this->adminId);

		$this->assign([
			'profile' => $profile,
			'powerList' => $this->getPowerList($profile['power']),
			'password1' => $session->getFlash('password1'),
			'success' => $session->getFlash('success'),
			'error_password1' => $session->getFlash('error_password1'),
		]);
		$this->display();
	}

	// 帐号列表
	private function adminList()
	{
		$adminModel = AdminModel::getInstance();
		$page = intval($this->get('page', 1));

		$adminList = $adminModel->getAdminList($page, self::PAGE_SIZE, $total);

		$pager = new Pager($page, self::PAGE_SIZE, $total);

		$this->assign([
			'adminList' => $adminList,
			'pageBar' => $pager->makeHtml(),
		]);
		$this->display('system/adminlist');
	}

	// 添加帐号
	private function addAdmin()
	{
		$adminModel = AdminModel::getInstance();
		$session = \App::session();
		if ($this->request->isMethod('post')) {
			$password1 = trim($this->get('password1'));
			$password2 = trim($this->get('password2'));
			$power = (array)$this->get('power', []);
			$salt = Strings::random(10);
			$data = [
				'user_name' => trim($this->get('user_name', '')),
				'real_name' => trim($this->get('real_name', '')),
				'email' => trim($this->get('email', '')),
				'password' => $password1,
				'salt' => $salt,
				'power' => implode(',', $power),
				'sex' => intval($this->get('sex', 1)),
			];
			$session->setFlash('data', $data);

			if (empty($data['user_name'])) {
				$session->setFlash('error_user_name', '请输入用户名');
				return $this->goBack();
			}
			if ($adminModel->getAdminByName($data['user_name'])) {
				$session->setFlash('error_user_name', '该用户名已存在');
				return $this->goBack();
			}
			if (empty($password1)) {
				$session->setFlash('error_password1', '请输入密码');
				return $this->goBack();
			}
			if (strlen($password1) < 6) {
				$session->setFlash('error_password1', '密码长度必须大于6位');
				return $this->goBack();
			}
			if (empty($password2)) {
				$session->setFlash('error_password2', '请输入确认密码');
				return $this->goBack();
			}
			if ($password1 != $password2) {
				$session->setFlash('error_password2', '两次输入的密码不一致');
				return $this->goBack();
			}

			$data['password'] = md5($password1 . $salt);
			$adminModel->addAdmin($data);

			return $this->redirect(URL(CUR_ROUTE));
		}

		$data = $session->getFlash('data');
		$this->assign([
			'powerList' => $this->getPowerList($data['power']),
			'data' => $data,
			'error_user_name' => $session->getFlash('error_user_name'),
			'error_password1' => $session->getFlash('error_password1'),
			'error_password2' => $session->getFlash('error_password2'),
		]);
		$this->display('system/addadmin');
	}

	// 编辑帐号
	private function editAdmin()
	{
		$adminModel = AdminModel::getInstance();
		$session = \App::session();
		$id = intval($this->get('id'));

		if ($this->request->isMethod('post')) {
			$password1 = trim($this->get('password1'));
			$password2 = trim($this->get('password2'));
			$power = (array)$this->get('power', []);
			$data = [
				'real_name' => $this->get('real_name', ''),
				'email' => $this->get('email', ''),
				'power' => implode(',', $power),
				'sex' => intval($this->get('sex', 1)),
			];

			if (!empty($password1)) {
				if (strlen($password1) < 6) {
					$session->setFlash('error_password1', '密码长度必须大于6位');
					$session->setFlash('password1', $password1);
					return $this->goBack();
				}
				if ($password1 != $password2) {
					$session->setFlash('error_password2', '两次输入的密码不一致');
					$session->setFlash('password1', $password1);
					return $this->goBack();
				}
				$data['salt'] = Strings::random(10);
				$data['password'] = md5($password1 . $data['salt']);
			}

			$adminModel->updateAdmin($id, $data);
			return $this->redirect(URL(CUR_ROUTE));
		}


		$adminInfo  = $adminModel->getAdmin($id);

		$this->assign([
			'adminInfo' => $adminInfo,
			'powerList' => $this->getPowerList($adminInfo['power']),
			'password1' => $session->getFlash('password1'),
			'error_password1' => $session->getFlash('error_password1'),
			'error_password2' => $session->getFlash('error_password2'),
		]);
		$this->display('system/editadmin');
	}

	// 删除帐号
	private function delAdmin()
	{
		$adminModel = AdminModel::getInstance();
		$id = intval($this->get('id'));

		if ($id == 1) {
			return $this->message('不能删除ID为1的帐号');
		}

		$adminModel->deleteAdmin($id);
		return $this->redirect(URL(CUR_ROUTE));
	}

	private function getPowerList($chkpower = '')
	{
		$chkpower = empty($chkpower) ? [] : explode(',', $chkpower);
		$menuList = \App::config()->get('menu');
		$powerList = [];
		foreach ($menuList as $row) {
			$group['name'] = $row['name'];
			$group['list'] = [];
			foreach ($row['submenu'] as $r) {
				$group['list'][] = [
					'name' => $r['name'],
					'route' => $r['route'],
					'checked' => in_array($r['route'], $chkpower),
				];
			}
			$powerList[] = $group;
		}

		return $powerList;
	}
}