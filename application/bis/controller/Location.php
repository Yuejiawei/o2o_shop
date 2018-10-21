<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/17
 * Time: 14:03
 */
namespace app\bis\controller;
class Location extends Base {
    /**
     *  列表页
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }

    /**
     *  门店的分配
     * @return mixed
     */
    public function add(){
        if(request()->isPost()){
            //门店入库操作
            //校验数据
            //获取数据
            $bisId = $this->getLoginSession()->bis_id;
            $data = input('post.');
            $data['cat'] = '';
            if(!empty($data['se_category_id'])){
                $data['cat'] = implode('|',$data['se_category_id']);
            }
            //获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            //print_r($lnglat);die();
            if(empty($lnglat) || $lnglat['status'] != 0 || $lnglat['result']['precise'] != 1){
                $this->error("无法获取地址详细数据，或者匹配的地址数据不精准");
            }
//            print_r($data);die();
            $locationData = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id']. ','.$data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => $data['content'],
                'is_main' => 0,
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            ];
            $locationId = model('BisLocation')->add($locationData);
            if($locationId){
                return $this->success('门店申请成功');
            }else{
                return $this->error('门店申请失败');
            }
        }else{
            //获取一级城市分类
            $citys = model('City')->getNormalCitysByParentId();
            //获取一级分类栏目的数据
            $categorys = model('Category')->getNormalCategorysByParentId();
            return $this->fetch('',[
                'citys' => $citys,
                'categorys' => $categorys
            ]);
        }
    }
}