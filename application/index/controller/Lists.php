<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/20
 * Time: 16:55
 */

namespace app\index\controller;
class Lists extends Base {
    public function index(){
        $firstCatIds = [];
        //首先获取一级栏目
        $categorys = model('Category')->getNormalCategorysByParentId();
        foreach ($categorys as $category){
            $firstCatIds[] = $category->id;
        }
        $id= input('id',0,'intval');
        $data = [];
        //$categoryParentId = 0;
        //id = 0一级分类  其他情况 二级分类
        if(in_array($id,$firstCatIds)){
            //一级分类
            $categoryParentId = $id;
            $data['category_id'] = $id;
        }elseif ($id){
            //二级分类
            //获取二级分类的数据
            $category = model('Category')->get($id);
            if(!$category || $category->status != 1){
                    $this->error('数据不合法');
            }
            $categoryParentId = $category->parent_id;
            $data['se_category_id'] = $id;
        }else{
            $categoryParentId = 0;
            //没有传值，id为0
        }
        $sedcategorys = [];
        //获取父类下的所有子分类
        if($categoryParentId){
            $sedcategorys = model('Category')->getNormalCategorysByParentId($categoryParentId);
        }
        $orders = [];
        //排序数据获取的逻辑
        $order_sales = input('order_sales','');
        $order_price = input('order_price','');
        $order_time = input('order_time','');
        if(!empty($order_sales)){
            $orderflag = 'order_sales';
            $orders['order_sales'] = $order_sales;
        }elseif (!empty($order_price)){
            $orderflag = 'order_price';
            $orders['order_price'] = $order_price;
        }elseif (!empty($order_time)){
            $orderflag = 'order_time';
            $orders['order_time'] = $order_time;
        }else{
            $orderflag = '';
        }
        $data['city_id'] = $this->city->id;
        //根据条件查询商品列表数据
        $deals = model('Deal')->getDealByConditions($data,$orders);
        return $this->fetch('',[
            'categorys' => $categorys,
            'sedcategorys' => $sedcategorys,
            'id' => $id,
            'categoryParentId' => $categoryParentId,
            'orderflag' => $orderflag,
            'deals' => $deals,
        ]);
    }
}