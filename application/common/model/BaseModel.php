<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/14
 * Time: 15:31
 *  公共的Model层
 */
//公共的Model层
namespace app\common\model;
use think\Model;
class BaseModel extends Model{
    protected $autoWriteTimestamp = true;
    public function add($data){
        $data['status'] = 0;
        $this->save($data);
        return $this->id;
    }
    public function updateById($data,$id){
        return $this->allowField(true)->save($data,['id' => $id]);
    }
}