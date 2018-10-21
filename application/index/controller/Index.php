<?php
namespace app\index\controller;

class Index extends Base
{
    public function index(){
        //获取首页大图相关数据
        //获取广告位相关数据
        //商品分类数据 -美食 推荐的数据
        $datas = model('Deal')->getNormalDealByCategoryCityId(2,$this->city->id);
        //获取4个子分类数据
        $meishicates = model('Category')->getNormalRecommendCategoryByParentId(2,4);
       return $this->fetch('',[
           'datas' => $datas,
           'meishicates' => $meishicates,
       ]);
    }
}
