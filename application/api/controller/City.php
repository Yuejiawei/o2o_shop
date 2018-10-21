<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/13
 * Time: 10:31
 */
namespace app\api\controller;
use think\Controller;
class City extends Controller
{
    private $obj;
    public function  _initialize()
    {
        $this->obj = model('City');
    }
    public function getCitysByParentId(){
        $id = input('post.id');
        if(!$id){
            $this->error("ID不存在");
        }
        //通过id获取二级城市
        $citys = $this->obj->getNormalCitysByParentId($id);
        if(!$citys){
            return show(0,'error');
        }
        return show(1,'success',$citys);
    }
    public function getCategorysByParentId(){
        $id = input('post.id');
    }
}