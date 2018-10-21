<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/20
 * Time: 21:34
 */

namespace app\index\controller;
class Order extends Base
{
    public function index(){
        $user = $this->getUserSession();
        if(!$user){
            $this->error('请登录','user/login');
        }
        $id = input('get.id',0,'intval');
        if(!$id){
            $this->error("ID不存在");
        }
        $count = input('get.deal_count',0,'intval');
        $price = input('get.total_price',0,'intval');
        if(!$count && $price){
            $this->error('参数不正确');
        }
        $deal = model('Deal')->find($id);
        if($deal && $deal->status != 1){
            $this->error('商品不存在');
        }
        if(empty($_SERVER['HTTP_REFERER'])){
            $this->error('请求不合法');
        }
        $orderno = setOrderSn();
        //组装入库数据
        $data = [
            'out_trade_no' => $orderno,
            'user_id' => $user -> id,
            'username' => $user->username,
            'payment_id' => 1,
            'deal_id' => $id,
            'deal_count' => $count,
            'total_price' => $price,
            'referer' => $_SERVER['HTTP_REFERER']
        ];
        try{
            $orderId = model('Order')->add($data);
        }catch(\Exception $e){
            $this->error('订单处理失败');
        }
        $this->redirect('pay/index',['id'=>$orderId]);
    }
    public function confirm(){
        if(!$this->getUserSession()){
            $this->error('请登录','user/login');
        }
        //
        $id = input('get.id',0,'intval');
        if(!$id){
            $this->error('ID不存在');
        }
        $count = input('get.count',1,'intval');
        if(!$count){
            $this->error('参数不正确');
        }
        $deal = model('Deal')->find($id);
//        echo model('Deal')->getLastSql();
        if(!$deal && $deal->status != 1){
            $this->error('商品不存在');
        }
        $deal = $deal->toArray();
        return $this->fetch('',[
            'controller' => 'pay',
            'deal' => $deal,
            'count' => $count,
        ]);
    }
}