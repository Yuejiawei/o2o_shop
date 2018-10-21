<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return view();
    }
    public function test(){
        \Map::getLngLat('北京昌平沙河地铁');
    }
    public function welcome(){
        //\phpmailer\Email::send('2219531345@q q.com','这是一封用tp5封装PHPemail完成的邮件发送','你说不用自作自受自己创造伤悲，从阿遥远海边。慢慢消失的你&&&abcdrrf');
        //return '邮件发送成功';
        return view();
    }
    public function map(){
        return \Map::staticimage('北京市海淀区上地十街10号');
    }
}
