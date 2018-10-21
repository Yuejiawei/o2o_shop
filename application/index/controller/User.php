<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/10
 * Time: 19:50
 */
namespace app\index\controller;
use think\Controller;
use think\Exception;

class User extends Controller
{
    public function login(){
        //获取session
        $user = session('user','','index');
        if($user && $user->id){
            $this->redirect('index/index');
        }
        return $this->fetch();
    }
    public function register(){
        if(request()->isPost()){
            $data = input('post.');
//            print_r($data);exit;
            if(!captcha_check($data['verifycode'])){
                //校验失败
                $this->error('验证码不正确');
            }
            //严格校验，小伙伴自行完成
            if($data['password'] != $data['repassword']){
                $this->error('两次密码输入不一致');
            }
            //自动生成 密码的加盐字符串
            $data['code'] = mt_rand(100,10000);
            $data['password'] = md5($data['password'].$data['code']);
            try{
                $userId = model('User')->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            if($userId){
                $this->success('用户注册成功',url('user/login'));
            }else{
                $this->error('用户注册失败');
            }
        }else{
            return $this->fetch();
        }
        //QLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'admin1' for key 'username '
        //键值的唯一性
    }
    public function logincheck(){
        //判断提交数据
        if(!request()->isPost()){
            $this->error('提交方式不合法');
        }
        $data = input('post.');
        //严格校验数据
        try{
            $user = model('User')->getUserByUsername($data['username']);
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }
        if(!$user || $user->status != 1){
            $this->error('该用户不存在');
        }
        //判断密码是否正确
        if(md5($data['password'].$user->code) != $user->password){
            $this->error('密码输入不正确');
        }
        //登陆成功
        model('User')->updateById(['last_login_time' => time()],$user->id);
        //把用户的信息记录到session
        session('user',$user,'index');
        $this->success('登陆成功',url('index/index'));
    }
    public function logout(){
        //注意：清空session时千万不能传第二个参数，否则会出现session清空失效情况
        //设置session时： session('name','value','prefix');
        //清空session时： session('name','value','prefix');千万不能传value值，直接不写即可，如下所示即可
        session(null,'index');
        $this->redirect('user/login');
    }
}