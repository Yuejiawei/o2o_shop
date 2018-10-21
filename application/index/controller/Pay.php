<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/21
 * Time: 11:44
 */
namespace app\index\controller;

class Pay extends Base
{
    public function index(){
        return $this->success('订单处理成功','index/index');
    }
}