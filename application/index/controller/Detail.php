<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/20
 * Time: 11:23
 */

namespace app\index\controller;
class Detail extends Base
{
    public function index($id){
        if(!intval($id)){
            $this->error('ID不合法');
        }
        //根据id查询商品数据
        $deal = model('Deal')->get($id);
        if(!$deal || $deal->status != 1){
            $this->error('该商品不存在');
        }
        //获取分类信息
        $category = model('Category')->get($deal->category_id);
        //获取分店信息
        $locations = model('BisLocation')->getNormalLocationsInId($deal->location_ids);
        //获取倒计时时间
        $flag = 0;
        if($deal->start_time >time()){
            $flag = 1;
            $dtime = $deal->start_time - time();
            $timeData = "";
            //天数
            $day = floor($dtime / (3600 *24));
            if($day){
                $timeData .= $day."天 ";
            }
            $hours = floor($dtime % (3600 * 24)/3600);
            if($hours){
                $timeData .= $hours." 小时";
            }
            $minute = floor($dtime % (3600 * 24)%3600/60);
            if($minute){
                $timeData .= $minute."分钟";
            }
            $this->assign('timedata',$timeData);
        }
        return $this->fetch('',[
            'deal' => $deal,
            'title' => $deal->name,
            'category' => $category,
            'locations' => $locations,
            'overplus' => $deal->total_count - $deal->buy_count,
            'flag' => $flag,
            'mapstr' => $locations[0]['xpoint'].','.$locations[0]['ypoint'],
        ]);
    }
}