<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/14
 * Time: 8:37
 */
namespace app\common\model;
class Bis extends BaseModel{
    /**
     *  通过状态获取商家数据
     * @param $status
     */
    public function getBisByStatus($status=0){
        $order = [
            'id' => 'desc',
        ];
        $data  = [
            'status' =>$status,
        ];
        $result = $this->where($data)->order($order)->paginate();
        return $result;
    }
}