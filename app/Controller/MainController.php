<?php
namespace App\Controller;

use App;
use App\Model\AdminModel;
use Core\Environment;
use Core\Lib\Validate;

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
        $session = App::session();
        if ($this->request->isMethod('post')) {
            $email = $this->getPost('email');
            $password = $this->getPost('password');
            $remember = $this->getPost('remember', 0);

            if (empty($email) || empty($password)) {
                $session->setFlash('error', '请输入登录账号和密码');
                return $this->refresh();
            }
            if (!Validate::email($email)) {
                $session->setFlash('error', 'Email地址无效');
                return $this->refresh();
            }

            $adminInfo = AdminModel::getInstance()->getRow(['email' => $email]);
            if ($adminInfo && $adminInfo['password'] == md5($password . $adminInfo['salt'])) {
                $this->setLoginAuth($adminInfo['id'], $adminInfo['password'], $remember);
                AdminModel::getInstance()->updateAdmin($adminInfo['id'], array(
                    'last_login' => NOW,
                    'last_ip' => $this->request->getClientIp(),
                ));
                return $this->redirect(URL('main/index'));
            } else {
                $session->setFlash('error', '帐号或密码错误');
                return $this->refresh();
            }
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