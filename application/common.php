<?php
use think\Hook;

// 应用公共文件

//登录之后才能访问系统
function LoginBeforeAction(){
    $username = session('username','','think');
    if(empty($username)){
       return redirect('user/login');
    }
    return $username;
}

//字符串太长，用……截断
function subtext($str,$len){
    if(mb_strlen($str,"utf8")>$len){
        return mb_substr($str,0,$len,"utf8").'……';
    }else{
        return $str;
    }
}

//定义钩子，当路由访问每个模块时，钩子侦测行为
function viewNotice(){
    $latestNotice = Hook::exec('app\\admin\\behavior\\AllNotice','run');
    return $latestNotice;
}

//系统主界面的昵称，锁屏，头像信息
function loginUserInfo(){
    $username = session('username','','think');
    if(empty($username)){
        return false;
    }else{
        $user = db('adminuser')
            ->where('username',$username)
            ->field('avatar,lock,username')->find();
        return $user;
    }

}
