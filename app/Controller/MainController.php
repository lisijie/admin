<?php
/**
 * 主界面
 *
 * @author jesse.li <jesse@comprame.com>
 */

namespace App\Controller;

use App\Model\AdminModel;

class MainController extends BaseController
{

    /**
     * 后台主界面
     *
     * @return \Core\Http\Response
     */
    public function indexAction()
    {
	    $this->assign('pageName', '系统概况');
        return $this->display();
    }

    /**
     * 登录页面
     *
     * @return \Core\Http\Response
     */
    public function loginAction()
    {
        if ($this->adminId > 0) {
            return $this->goHome();
        }
        $session = \App::session();
        if ($this->request->isMethod('post')) {
            $userName = $this->getPost('username');
            $password = $this->getPost('password');
            $remember = $this->getPost('remember', 0);

            $adminInfo = AdminModel::getInstance()->getAdminByName($userName);
            if ($adminInfo && $adminInfo['password'] == md5($password . $adminInfo['salt'])) {
                $this->setLoginAuth($adminInfo['id'], $adminInfo['password'], $remember);
                AdminModel::getInstance()->updateAdmin($adminInfo['id'], array(
                    'last_login' => NOW,
                    'last_ip' => $this->request->getClientIp(),
                ));
                return $this->redirect(URL('main/index'));
            }

            $session->setFlash('error', '帐号或密码错误');
        }

        $this->assign([
            'error' => $session->getFlash('error'),
        ]);
        return $this->display();
    }

    /**
     * 退出登录
     */
    public function logoutAction()
    {
        $this->response->cookies()->remove('auth');
        return $this->redirect(URL('main/login'));
    }

}