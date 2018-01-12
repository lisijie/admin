<?php
namespace App\Controller\System;

use App\Controller\BaseController;
use App\Model\AdminModel;
use Core\Lib\Strings;

/**
 * 个人信息
 *
 * @package App\Controller\System
 */
class ProfileController extends BaseController
{
    /**
     * 个人信息显示
     */
    public function indexAction()
    {
        $adminModel = AdminModel::getInstance();
        $profile = $adminModel->getAdmin($this->adminId);
        $session = \App::session();
        $this->assign([
            'profile' => $profile,
            'powerList' => $this->getPowerList($profile['power']),
            'password1' => $session->getFlash('password1'),
            'success' => $session->getFlash('success'),
            'errorPassword1' => $session->getFlash('error_password1'),
            'errorPassword2' => $session->getFlash('error_password2'),
        ]);
        $this->display();
    }

    /**
     * 保存修改
     *
     * @return \Core\Http\Response
     */
    public function saveAction()
    {
        $password1 = trim($this->get('password1'));
        $password2 = trim($this->get('password2'));
        $data = [
            'realname' => trim($this->get('realname', '')),
            'email' => trim($this->get('email', '')),
            'sex' => intval($this->get('sex', 1)),
        ];

        $session = \App::session();
        $adminModel = AdminModel::getInstance();

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
        return $this->redirect(URL('system/profile/index'));
    }
}