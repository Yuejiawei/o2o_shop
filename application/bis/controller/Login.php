<?php
namespace app\bis\controller;
use think\Controller;
class Login extends Controller
{
    public function index(){
        if(request()->isPost()){
            //登录的逻辑
            //获取相关的数据
            $data = input('post.');
            if(!$data){
                $this->error('数据提交失败');
            }
            //校验数据
            $validate = validate('Bis');
            if(!$validate->scene('login')->check($data)){
                $this->error($validate->getError());
            }
            //通过用户名去获取用户相关信息
            $result = model('BisAccount')->get(['username' => $data['username']]);
//            print_r($result);die();
            if(!$result || $result->status != 1){
                $this->error('该用户不存在或者该用户未被审核');
            }
            if($result->password != md5($data['password'].$result->code)){
                $this->error('密码不正确');
            }

            model('BisAccount')->updateById(['last_login_time'=>time()],$result->id);
            //保存用户信息,第三个参数是作用域
            session('bisAccount',$result,'bis');
//            print_r($result)
            return $this->success('登录成功',url('index/index'));
        }else{
            //获取session值,如果存在session就证可以直接进入商户中心界面
            $account = session('bisAccount','','bis');
            if($account && $account->id){
                return $this->redirect('index/index');
            }
            return $this->fetch();
        }
    }
    public function logout(){
        //清除session
        session(null,'bis');
        //跳出登录页面
        $this->redirect('login/index');
    }
}