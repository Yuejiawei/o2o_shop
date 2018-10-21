<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/15
 * Time: 8:39
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Bis extends Controller{
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Bis');
    }

    /**
     *  审核已通过的商户列表
     * @return mixed
     */
    public function index(){
        $bis = $this->obj->getBisByStatus(1);
        return $this->fetch('',[
            'bis' => $bis,
        ]);
    }

    /**
     * 入驻申请列表
     * @return mixed
     */
    public function apply(){
        $bisData = $this->obj->getBisByStatus();
        //print_r(array($bisData));die();
        return $this->fetch('',[
             'bis' => $bisData,
        ]);
    }
    public function detail(){

        $id = input('get.id');
        if(empty($id)){
            return $this->error('获取商户ID错误');
        }
//        $data = Db::name('bis')->where('id',$id)->select();
//        dump($data);die();
        //获取城市数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取分类中一级栏目的数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        //获取商户数据
        $bisData = model('Bis')->get($id);
        $locationData = model('BisLocation')->get(['bis_id'=>$id,'is_main' => 1]);
        $accountData = model('BisAccount')->get(['bis_id'=>$id,'is_main' => 1]);
//        print_r($bisData);die();
        return $this->fetch('',[
                'citys' => $citys,
                'categorys' => $categorys,
                'bisData' => $bisData,
                'locationData' => $locationData,
                'accountData' => $accountData,
        ]);
    }
    public function status(){
        $data = input('get.');
        //状态相关校验
        $validate = validate('Bis');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }
        $bis = $this->obj->save(['status' => $data['status']],['id' => $data['id']]);
        $location = model('BisLocation')->save(['status' => $data['status']],['bis_id' => $data['id'],'is_main' =>1]);
        $account = model('BisAccount')->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main' => 1]);
        if($bis && $location && $account){
            //发送邮件
            // status 1 审核通过  status 2 审核不通过 status -1 删除申请信息(理论上来说无论是否通过都要发送邮件告知申请者)
            //\phpmailer\Email::send($data['email'],$title,$content); 此处先省略
            $this->success('状态更新成功');
        }else{
            $this->error('状态更新失败');
        }
    }
}