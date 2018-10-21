<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/18
 * Time: 20:57
 */

namespace app\common\model;

class Featured extends BaseModel
{
    /**
     *  根据列表类型来获取数据
     * @param $type
     */
    public function getFeaturedsByType($type){
        $data = [
            'type' => $type,
            'status' => ['neq',-1],
        ];
        $order = [
            'id' => 'desc',
        ];
        $result = $this->where($data)->order($order)->paginate(1);
        return $result;
    }
}