<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/14
 * Time: 11:40
 */
namespace app\common\model;
class BisAccount extends BaseModel{
    public function updateById($data,$id){
        // allowField 过滤data数组中非数据表中的数据
        return $this->allowField(true)->save($data,['id' => $id]);
    }
}