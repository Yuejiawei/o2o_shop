<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/20
 * Time: 16:46
 */

namespace app\index\controller;
use think\Controller;
class Map extends Controller
{
    public function getMapImage($data){
        return \Map::staticimage($data);
    }
}