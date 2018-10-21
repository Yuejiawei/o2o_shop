<?php
namespace app\bis\controller;
use think\Controller;

class Register extends Controller
{
    public function index(){
        //获取一级城市分类
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级分类栏目的数据
        $categorys = model('Category')->getNormalCategorysByParentId();
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys
        ]);
    }
    public function add(){
        if(!request()->isPost()){
            $this->error("请求错误");
        }
        //获取表单中的值
        $data = input('post.','','htmlentities');
        //对获取到的数据进行校验
        $validate = validate('Bis');
        if(!$validate->scene('add')->check($data)){
            //$this->error($validate->getError());
        }
        //获取经纬度
        $lnglat = \Map::getLngLat($data['address']);
        //print_r($lnglat);die();
        if(empty($lnglat) || $lnglat['status'] != 0 || $lnglat['result']['precise'] != 1){
            $this->error("无法获取地址详细数据，或者匹配的地址数据不精准");
        }
        //判断用户提交是否已经存在
        $accountResult = Model('BisAccount')->get(['username' => $data['username']]);
        if($accountResult){
            $this->error("该用户已经存在，请您重新分配");
        }
        //总店的相关信息校验

        // 账户的相关信息校验

        //商户基本信息入库
        $bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => empty($data['description']) ? '' :$data['description'],
            'bank_info' => $data['bank_info'],
            'bank_user' => $data['bank_user'],
            'bank_name' => $data['bank_name'],
            'corporation' => $data['corporation'],
            'corporation_tel' => $data['corporation_tel'],
            'email' => $data['email'],
        ];
        $bisId = model('Bis')->add($bisData);
        //echo $bisId;exit;
        $data['cat'] = '';
        if(!empty($data['se_category_id'])){
            $data['cat'] = implode('|',$data['se_category_id']);
        }
        //总店相关信息入库
        $locationData = [
                'bis_id' =>$bisId,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'] . ',' . $data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content']) ? '' : $data['content'],
                'is_main' => 1, //代表总店相关信息
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
        ];
        $locationId = model('BisLocation')->add($locationData);
        //自动生成，密码加盐字符串
        $data['code'] = mt_rand(100,10000);
        //账户相关信息入库
        $accountData = [
                'bis_id' => $bisId,
                'username' => $data['username'],
                'code' => $data['code'],
                'password' => md5($data['password'].$data['code']),
                'is_main' => 1,  //代表的是总管理员
        ];
        $accountId = model('BisAccount')->add($accountData);
        if(!$accountData){
                $this->error("申请失败");
        }
        $url = request()->domain().url('bis/register/waiting',['id' => $bisId]);
        $title = "o2o入驻申请通知";
        $content = "您提交的入驻申请需等待平台方审核，您可以通过以下链接 <a href='".$url."' target='_blank'> 查看链接 </a> 查看审核状态";
        //发送邮件
        \phpmailer\Email::send($data['email'],$title,$content);
        $this->success("申请成功",url('register/waiting',['id' => $bisId]));
    }
    public function waiting($id){
        if(empty($id)){
            $this->error('申请失败');
        }
        $detail = model('Bis')->get($id);
        return view('',[
            'detail' => $detail,
        ]);
    }
}