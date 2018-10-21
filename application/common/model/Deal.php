<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/18
 * Time: 18:21
 */

namespace app\common\model;
class Deal extends BaseModel{
    public function getNormalDeals($data = []){
        $data['status'] = 1;
        $order = ['id'=>'desc'];
        $result = $this->where($data)->order($order)->paginate(1);
//        echo $this->getLastSql();
        return $result;
    }

    /**
     *  根据分类 以及 城市 来获取商品数据
     * @param $id  分类
     * @param $cityId  城市
     * @param $limit  条数
     */
    public function getNormalDealByCategoryCityId($id,$cityId,$limit=10){
        $data = [
            'end_time' => ['gt',time()],
            'category_id' => $id,
            'city_id' => $cityId,
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $result = $this->where($data)->order($order);
        if($limit){
            $result = $result->limit($limit);
        }
        return $result->select();
    }
    public function getDealByConditions($data = [],$orders){
        $order = [];
        if(!empty($orders['order_sales'])){
            $order['buy_count'] = 'desc';
        }
        if(!empty($orders['order_price'])){
            $order['current_price'] = 'desc';
        }
        if(!empty($order['order_time'])){
            $order['create_time'] = 'desc';
        }
        //find_in_set(11,'se_category_id')
        $order['id'] = 'desc';
        $datas[] = "end_time > " .time();
        if(!empty($data['se_category_id'])){
            $datas[] = "find_in_set(".$data['se_category_id'].",se_category_id)";
        }
        if(!empty($data['category_id'])){
            $datas[] = 'category_id = '.$data['category_id'];
        }
        if(!empty($data['city_id'])){
            $datas[] = 'city_id = '.$data['city_id'];
        }
        $datas[] = 'status = 1';
        $results = $this->where(implode(' AND ',$datas))->order($order)->paginate();
//        echo $this->getLastSql();exit;
        return $results;
    }
}