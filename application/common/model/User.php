<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/19
 * Time: 13:38
 */

namespace app\common\model;
class User extends BaseModel
{
    public function add($data = []){
        //如果你提交的数据不是一个数组，抛出异常
        if(!is_array($data)){
            exception('你传递的数据不是一个数组');
        }
        $data['status'] = 1;
        return $this->data($data)->allowField(true)->save();
    }

    /**
     *  根据用户名获取用户信息
     * @param $username
     */
    public function getUserByUsername($username){
        if(!$username){
            exception('用户名不合法');
        }
        $data = ['username' => $username];
        $results = $this->where($data)->find();
        return $results;
    }
}