<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/19
 * Time: 10:37
 */
namespace app\admin\controller;
use think\Controller;
class Base extends Controller{
    public function status(){
        //获取数据
        $data = input('get.');
        if(empty($data['id'])){
            $this->error('ID不合法');
        }
        if(!is_numeric($data['status'])){
            $this->error('状态值不合法');
        }
        //获取控制器
        $model = request()->controller();
        $res = model($model)->save(['status' => $data['status']],['id' => $data['id']]);
        if($res){
            $this->success('状态修改成功');
        }else{
            $this->error('状态修改失败');
        }
    }
    //排序功能也可以放到公共控制器中
}