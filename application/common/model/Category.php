<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/11
 * Time: 14:45
 */
namespace app\common\model;
use think\Model;
class Category extends Model
{
    protected $autoWriteTimestamp = true;
    public function add($data){
        $data['status'] = 1;
        //$data['create_time'] = time();
        return $this->save($data);
    }
    public function getNormalFirstCategory(){
        $data = [
            'status' => 1,
            'parent_id' => 0
        ];
        $order = ['id'=>'desc'];
        return $this->where($data)->order($order)->select();
    }
    public function getFirstCategorys($parentId=0){
        $data = [
            'parent_id' => $parentId,
            'status' => ['neq',-1],
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];
        $result = $this->where($data)->order($order)->paginate();
        //echo $this->getLastSql();
        return $result;
    }
    public function getNormalCategorysByParentId($parentId=0){
        $data = [
                'parent_id' => $parentId,
                'status' => 1,
        ];
        $order = [
            'id' => 'desc',
        ];
        $result = $this->where($data)->order($order)->select();
        return $result;
    }
    public function getNormalRecommendCategoryByParentId($parentId=0,$count=5){
        $data = [
            'parent_id' => $parentId,
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $results = $this->where($data)->order($order);
        if($count){
            $results = $results->limit($count);
        }
        return $results->select();
    }
    public function getNormalCategoryIdByParentId($ids){
        $data = [
            'parent_id' =>  ['in',implode(',',$ids)],
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        $results = $this->where($data)->order($order)->select();
        return $results;
    }
}