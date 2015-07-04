<?php

namespace Home\Controller;


use Think\Controller;

class LoginController extends CommonController {
    /**
     * api 说明文档后台登录
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function login() {
        // 快捷访问
        if (cookie('user') && cookie('password')) {
            $account_map = array(
                'account' => cookie('user'),
                'password'=> encryptDecrypt(cookie('password'), 'cyq2015')
            );
            $account = M("account")->where($account_map)->find();
            if ($account) {
                cookie("aid", $account['id']);
                cookie("name", $account['account']);
                cookie("isLogin", 1);
                $this->redirect('Index/index');
            }
        }

        $this->title = '管理登陆';  
        $this->display();
    }


    /**
     * api 说明文档后台登录处理
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function loginAction() {
        //验证用户登录 # encryptDecrypt('123456', 'cyq2015') => 9UklK9vps3Bv3JHguCaFp7jXhUcrlZeCaMjWGcXj69M=
        if (IS_POST) {
            $account_map = array(
                'account' => I('post.user'),
                'password'=> encryptDecrypt(I('post.pwd'), 'cyq2015')
            );
            $account = M("account")->where($account_map)->find();
            !$account && exit("系统暂时无法介入，请稍后访问！");

            cookie("aid", $account['id']);
            cookie("name", $account['account']);
            cookie("isLogin", 1);
            
            // 存储用户输入，便于下次执行登陆
            cookie('user', I('post.user'), 86400);
            cookie('password', I('post.pwd'), 86400);

            unset($account);
            exit("success");
        }
    }
    
    /**
     * api 说明文档后台登出处理
     * @author cyq <chenyuanqi90s@163.com>
     */
    public function logout() {
        cookie("aid", null);
    	cookie("name", null);
    	cookie("isLogin", null);
        cookie(null);

        1 != cookie("isLogin") && $this->redirect('Index/index');
    }
}