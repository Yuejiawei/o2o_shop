<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/13
 * Time: 11:19
 */

namespace app\api\controller;
use think\Controller;

class Category extends Controller
{
    private $obj;
    public function  _initialize()
    {
        $this->obj = model('Category');
    }
    public function getCategorysByParentId(){
        $id = input('post.id');  //可以写成这样 $id = input('post.id',0,'intval');
        if(!intval($id)){
            $this->error("ID不存在");
        }
        //通过id获取二级城市
        $categorys = $this->obj->getNormalCategorysByParentId($id);
        if(!$categorys){
            return show(0,'error');
        }
        return show(1,'success',$categorys);
    }
}