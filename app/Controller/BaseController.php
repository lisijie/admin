<?php
namespace App\Controller;

use App;
use App\Model\AdminModel;
use Core\Controller;

class BaseController extends Controller
{
    protected $pageSize = 30;
    protected $adminId = 0;
    protected $nickname = '';
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
            $this->setLayoutSection('navbar', 'layout/section/navbar');
            $this->setLayoutSection('sidebar', 'layout/section/sidebar');
            $this->checkPermission();
            $this->assignGlobalVars();
        }
        $this->assign('baseUrl', $this->request->getBaseUrl() . '/');
    }

    /**
     * 权限检查
     * @return bool
     */
    private function checkPermission()
    {
        if ($this->adminId == 1) return true;
        $whiteList = ['main/index', 'system/profile/index', 'system/profile/save', 'main/login', 'main/logout'];
        if (!in_array(CUR_ROUTE, $whiteList) && !in_array(CUR_ROUTE, $this->powers)) {
            App::abort(403, '抱歉，你没有权限访问该页面');
        }
    }

    /**
     * 设置全局模板变量
     */
    private function assignGlobalVars()
    {
        $this->assign('loginUser', [
            'user_id' => $this->adminId,
            'nickname' => $this->nickname,
            'sex' => $this->adminSex,
        ]);
        $powers = $this->powers;
        // 菜单
        $pageName = '';
        $menuList = App::config()->get('menu');
        foreach ($menuList as $k => &$group) {
            $group['active'] = '';
            foreach ($group['submenu'] as $kk => &$menu) {
                $menu['active'] = '';
                if (CUR_ROUTE == $menu['route']) {
                    $menu['active'] = 'active';
                    $group['active'] = 'active open';
                    $pageName = $menu['name'];
                }
                if (!$menu['show'] || ($this->adminId > 1 && !in_array($menu['route'], $powers))) {
                    unset($group['submenu'][$kk]);
                }
            }
            if (empty($group['submenu']) || !$group['show']) {
                unset($menuList[$k]);
            }
        }
        $this->assign(array(
            'menuList' => $menuList,
            'pageName' => $pageName,
        ));
    }

    /**
     * 登录校验
     * @return bool
     */
    private function initAuth()
    {
        $auth = $this->request->cookies()->getSecure('auth');
        $ip = '';
        if (empty($auth) || strpos($auth, '|') === false) {
            return false;
        }
        list($id, $password) = explode('|', $auth);
        $admin = AdminModel::getInstance()->getAdmin($id);
        if (!$admin || md5($admin['password'] . $ip) != $password) {
            return false;
        }

        $this->adminId = $admin['id'];
        $this->nickname = $admin['nickname'];
        $this->adminSex = $admin['sex'];
        $this->powers = explode(',', $admin['power']);
        return true;
    }

    /**
     * 设置登录Cookie
     *
     * @param $adminId
     * @param $password
     * @param int $remember
     */
    protected function setLoginAuth($adminId, $password, $remember = 0)
    {
        $ip = '';
        $auth = "{$adminId}|" . md5($password . $ip);
        $cookie = [
            'value' => $auth,
            'expire' => $remember ? NOW + 86400 * 7 : 0,
        ];

        $this->response->cookies()->setSecure('auth', $cookie);
    }

    /**
     * 跳转到登录页
     */
    protected function gotoLoginPage()
    {
        header('Location: ' . URL('main/login'));
        exit;
    }

    protected function getPowerList($chkPowers = '')
    {
        $chkPowers = empty($chkPowers) ? [] : explode(',', $chkPowers);
        $menuList = \App::config()->get('menu');
        $powerList = [];
        foreach ($menuList as $row) {
            $group['name'] = $row['name'];
            $group['list'] = [];
            foreach ($row['submenu'] as $r) {
                $group['list'][] = [
                    'name' => $r['name'],
                    'route' => $r['route'],
                    'checked' => in_array($r['route'], $chkPowers),
                ];
            }
            $powerList[] = $group;
        }

        return $powerList;
    }

}