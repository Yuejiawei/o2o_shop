<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/14
 * Time: 11:11
 */
namespace app\common\model;
class BisLocation extends BaseModel{
    public function getNormalLocationByBisId($bisId){
        $data = [
            'bis_id' => $bisId,
            'status' => 1
        ];
        $result = $this->where($data)->order('id','desc')->select();
        return $result;
    }
    public function getNormalLocationsInId($ids){
        $data = [
            'id' => ['in',$ids],
            'status' => 1,
        ];
        return $this->where($data)->select();
    }
}
