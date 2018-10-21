<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/19
 * Time: 15:28
 */

namespace app\index\controller;
use think\Controller;
class Base extends Controller
{
    public $city = "";
    public $account = "";
    public function _initialize()
    {
        //城市数据
        $citys = model('City')->getNormalCitys();
        $this->getCity($citys);
        //用户数据
        //获取首页分类数据
        $cats = $this->getRecommendCats();
        $this->assign('citys',$citys);
        $this->assign('city',$this->city);
        $this->assign('user',$this->getUserSession());
        $cats = $this->getRecommendCats();
        $this->assign('cats',$cats);
        $this->assign('controller',strtolower(request()->controller()));
        $this->assign('title','o2o团购网');
    }
    public function getCity($citys){
        foreach ($citys as $city){
            $city = $city->toArray();
//            print_r($city);exit;
            if($city['is_default'] == 1){
                $defaultuname = $city['uname'];
                break; //终止foreach
            }
        }
        $defaultuname = $defaultuname ? $defaultuname : 'nanchang';
        if(session('cityuname','','index') && !input('get.city')){
            $cityuname = session('cityuname','','index');
        }else{
            $cityuname = input('get.city',$defaultuname,'trim');
            session('cityuname',$cityuname,'index');
        }
        $this->city = model('City')->where(['uname' => $cityuname])->find();
    }
    public function getUserSession(){
        if(!$this->account){
            $this->account = session('user','','index');
        }
        return $this->account;
    }

    /**
     *  获取首页推荐当中的商品分类数据
     */
    public function getRecommendCats(){
        $parentIds = [];
        $sedCatArr = [];
        $recommentCats = [];
        $cats = model('Category')->getNormalRecommendCategoryByParentId(0,5);
//        print_r($cats);
        foreach ($cats as $cat){
            $parentIds[] = $cat->id;
        }
        //获取二级分类的数据
        $sedCats = model('Category')->getNormalCategoryIdByParentId($parentIds);
        foreach ($sedCats as $sedCat){
            $sedCatArr[$sedCat->parent_id][] = [
                'id' => $sedCat->id,
                'name' => $sedCat->name,
            ];
        }
        foreach ($cats as $cat){
            //$recommentCats 代表的是一级和二级分类的所有数据  该数组中的第一个参数是 一级分类的名字(name)，第二个参数是 此一级分类下的所有二级分类数据
            $recommentCats[$cat->id] = [
                $cat->name,empty($sedCatArr[$cat->id]) ? [] : $sedCatArr[$cat->id]
            ];
        }
        return $recommentCats;
    }
}