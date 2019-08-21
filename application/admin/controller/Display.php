<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/16
 * Time: 21:39
 */

namespace app\admin\controller;
use think\Controller;

class Display extends Controller
{
    public function index(){
        $user = loginUserInfo();
        if(!$user){
              return $this->error('您未登录，请先登录','user/login');
        }else{
            $latestNotice = viewNotice();
            return view("display/index",['latestNotice'=>$latestNotice,'user'=>$user]);
        }

    }
}