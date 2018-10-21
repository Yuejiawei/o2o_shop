<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/18
 * Time: 11:29
 */
namespace app\bis\controller;
class Deal extends Base{
    /**
     * @return mixed 商户中心的deal列表页自行完成
     */
    public function index(){
        return "商户中心的Deal列表页面小伙伴自行完成";
    }
    public function add(){
        //获取商户ID
        $bisId = $this->getLoginSession()->bis_id;
        //获取分店的相关信息数据
        if(request()->isPost()){
            $data = input('post.');
            //获取经纬度
            $location = model('BisLocation')->get($data['location_ids'][0]);
            //商户id
            $bisAccountId = $this->getLoginSession()->id;
            //将数据插入表中
            //校验
            $deals = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' :  implode(',',$data['se_category_id']),
                'city_id' => $data['city_id'],
                'location_ids' => empty($data['location_ids']) ? '' :  implode(',',$data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'notes' => $data['notes'],
                'description' => $data['description'],
                'bis_account_id' => $bisAccountId,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,
            ];
            $id = model('Deal')->add($deals);
            if($id){
                $this->success('添加成功',url('deal/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            //获取一级城市分类
            $citys = model('City')->getNormalCitysByParentId();
            //获取一级分类栏目的数据
            $categorys = model('Category')->getNormalCategorysByParentId();
            //获取二级栏目分类数据
            $bisLocations = model('BisLocation')->getNormalLocationByBisId($bisId);
            return $this->fetch('',[
                'citys' => $citys,
                'categorys' => $categorys,
                'bisLocations' => $bisLocations
            ]);
        }

    }
}