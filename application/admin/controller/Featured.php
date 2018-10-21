<?php
/**
 * Created by PhpStorm.
 * User: Jiawei
 * Date: 2018/10/18
 * Time: 20:54
 */

namespace app\admin\controller;
use think\Controller;
class Featured extends Base {
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Featured');
    }
    public function add(){
        if(request()->isPost()){
            //获取数据入库
            $data = input('post.');
            //数据需要做严格校验
            $id = model('Featured')->add($data);
            if($id){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            //获取推荐位类别
            $types = config('featured.featured_type');
            return $this->fetch('',[
                'types' => $types,
            ]);
        }

    }
    public function index(){
        //获取推荐位类别
        $types = config('featured.featured_type');
        $type = input('get.type',0,'intval');
        //获取列表数据
        $results = $this->obj->getFeaturedsByType($type);
//        print_r($results);exit();
        return $this->fetch('',[
            'types' => $types,
            'type' => $type,
            'results' => $results,
        ]);
    }
//    public function status(){
//        //获取状态值
//        $data = input('get.');
//        //利用tp5中的validate机制进行严格校验  id status
//        $res = $this->obj->save(['status' => $data['status']],['id' => $data['id']]);
//        if($res){
//            $this->success('更新成功');
//        }else{
//            $this->error('更新失败');
//        }
//    }
        //推荐位列表的编辑功能也可由小伙伴自行完成
}