<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/27
 * Time: 17:38
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\Visitor as AdminVisitor;
use think\Request;
use app\admin\validate\security\VisitorValidate;
use think\Validate;


class Visitor extends Controller
{
    public function showEnterVisitor(){
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        $token = 0;
        $visitors = AdminVisitor::where('token',0)->paginate(7);
        return view('visitor/showvisitor',['token'=>$token,'visitors'=>$visitors,'latestNotice'=>$latestNotice,'user'=>$user]);
    }}
    public function addEnterVisitor(){
        if(Request::instance()->isPost()){
            $res = (new  VisitorValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            try{
                $user = new AdminVisitor($_POST);
                $user->token = 0;
                $token =  $user->allowField(true)->save();
                if($token)
                    return $this->success("访客登记成功！");
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
        }else{
            return view('visitor/addvisitor');
        }
    }
    public function showEnterCar(){
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        $token = 1;
        $visitors = AdminVisitor::where('token',1)->paginate(7);
        return view('visitor/showvisitor',['token'=>$token,'visitors'=>$visitors,'latestNotice'=>$latestNotice,'user'=>$user]);
    }}
    public function addEnterCar(){
        if(Request::instance()->isPost()){
            $validate = new Validate([
                ['carnumber','require','车牌号不能为空'],
                ['visit_time','require','访问时间不能为空' ],
                ['visit_time','date','时间格式不正确'],
                ['left_time','require','离开时间不能为空' ],
                ['left_time','date','时间格式不正确'],
                ['left_time','gt:visit_time','离开时间必须晚于访问时间'],
                ]
                );
            if (!$validate->check($_POST)) {
                return $this->error($validate->getError());
            }
            try{
                $user = new AdminVisitor($_POST);
                $user->token = 1;
                $token =  $user->allowField(true)->save();
                if($token)
                    return $this->success("车辆登记成功！");
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
        }else{
            return view('visitor/addcar');
        }

    }
    public function countEnterVisitor(){
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        $visitors = db('visitor')
            ->field('visit_time,count(visitor_name) as person,count(carnumber) as car')
            ->group('visit_time')->select();
        return view('visitor/visitorcount',['visitors'=>$visitors,'latestNotice'=>$latestNotice,'user'=>$user]);

    }}

}