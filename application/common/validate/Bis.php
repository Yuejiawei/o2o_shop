<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/13
 * Time: 20:25
 */

namespace app\common\validate;
use think\Validate;

class Bis extends Validate
{
    //规则设置
    protected $rule = [
         'id' => 'require|number',
         'name' => 'require|max:25',
         'email' => 'email',
         'logo' => 'require',
         'city_id' => 'require',
         'bank_info' => 'require',
         'bank_name' => 'require',
         'bank_user' => 'require',
         'corporation' => 'require',
         'corporation_tel' => 'require',
         'status' => 'require|in:1,2,-1,0',
         'username' => 'require|max:25',
         'password' => 'require'
    ];
    protected $message = [
        'status.in' => '状态不合法'
    ];
    //场景检测
    protected $scene = [
        'add' => ['name','email','logo','city_id','bank_info','bank_name','bank_user','corporation','corporation_tel'],
        'status' => ['id','status'],
        'login' => ['username','password'],
    ];
}