<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/17
 * Time: 12:40
 */

namespace app\bis\controller;
use think\Controller;
class Base extends Controller{
    public $account;
    public function _initialize(){
        //判断用户是否登录
        $isLogin = $this->isLogin();
        if(!$isLogin){
            return $this->redirect('login/index');
        }
    }
    //判断是否登录
    public function isLogin(){
        //获取session值
        $user = $this->getLoginSession();
        if($user && $user->id){
            return true;
        }
        return false;
    }
    public function getLoginSession(){
        //获取session
        if(!$this->account){
            $this->account = session('bisAccount','','bis');
        }
        return $this->account;
    }
}