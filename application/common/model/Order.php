<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/21
 * Time: 11:40
 */
namespace app\common\model;
use think\Model;
class Order extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data){
        $data['status'] = 1;
        $this->save($data);
        return $this->id;
    }
}