<?php
namespace App\Controller\System;

use App\Controller\BaseController;
use App\Model\AdminModel;
use App\Util\Pager;
use Core\Lib\Strings;

/**
 * 后台账号管理
 *
 * @package App\Controller\System
 */
class AdminController extends BaseController
{

    /**
     * 管理员列表
     */
    public function listAction()
    {
        $adminModel = AdminModel::getInstance();
        $page = intval($this->get('page', 1));

        $adminList = $adminModel->getAdminList($page, $this->pageSize, $total);

        $pager = new Pager($page, $this->pageSize, $total);

        $this->assign([
            'adminList' => $adminList,
            'pageBar' => $pager->makeHtml(),
        ]);
        $this->display();
    }


    /**
     * 添加管理员
     *
     * @return \Core\Http\Response|mixed
     */
    public function addAction()
    {
        $adminModel = AdminModel::getInstance();
        $session = \App::session();
        if ($this->request->isMethod('post')) {
            $password1 = trim($this->getPost('password1'));
            $password2 = trim($this->getPost('password2'));
            $power = (array)$this->getPost('power', []);
            $salt = Strings::random(10);
            $data = [
                'username' => trim($this->getPost('username', '')),
                'realname' => trim($this->getPost('realname', '')),
                'email' => trim($this->getPost('email', '')),
                'password' => $password1,
                'salt' => $salt,
                'power' => implode(',', $power),
                'sex' => intval($this->getPost('sex', 1)),
            ];
            $session->setFlash('data', $data);

            if (empty($data['username'])) {
                $session->setFlash('error_username', '请输入用户名');
                return $this->goBack();
            }
            if ($adminModel->getAdminByName($data['username'])) {
                $session->setFlash('error_username', '该用户名已存在');
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

            return $this->redirect(URL('system/admin/list'));
        }

        $data = $session->getFlash('data');
        $this->assign([
            'powerList' => $this->getPowerList($data['power']),
            'data' => $data,
            'error_username' => $session->getFlash('error_username'),
            'error_password1' => $session->getFlash('error_password1'),
            'error_password2' => $session->getFlash('error_password2'),
        ]);
        $this->display();
    }

    /**
     * 编辑管理员
     *
     * @return \Core\Http\Response
     */
    public function editAction()
    {
        $adminModel = AdminModel::getInstance();
        $session = \App::session();
        $id = intval($this->get('id'));

        if ($this->request->isMethod('post')) {
            $password1 = trim($this->getPost('password1'));
            $password2 = trim($this->getPost('password2'));
            $power = (array)$this->getPost('power', []);
            $data = [
                'realname' => trim($this->getPost('realname', '')),
                'email' => trim($this->getPost('email', '')),
                'power' => implode(',', $power),
                'sex' => intval($this->getPost('sex', 1)),
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
            return $this->redirect(URL('system/admin/list'));
        }


        $adminInfo = $adminModel->getAdmin($id);

        $this->assign([
            'adminInfo' => $adminInfo,
            'powerList' => $this->getPowerList($adminInfo['power']),
            'password1' => $session->getFlash('password1'),
            'error_password1' => $session->getFlash('error_password1'),
            'error_password2' => $session->getFlash('error_password2'),
        ]);
        $this->display();
    }

    /**
     * 删除管理员
     *
     * @return \Core\Http\Response
     */
    public function delAction()
    {
        $adminModel = AdminModel::getInstance();
        $id = intval($this->get('id'));
        if ($id == 1) {
            return $this->message('不能删除ID为1的帐号');
        }
        $adminModel->deleteAdmin($id);
        return $this->goBack();
    }
}