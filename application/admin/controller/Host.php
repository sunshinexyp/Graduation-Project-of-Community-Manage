<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 20:36
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;
use app\admin\validate\security\HostValidate;
use app\admin\model\Host as AdminHost;
use app\admin\model\Funds;
use app\admin\model\Meter;
use think\Db;
use think\Exception;
class Host extends Controller
{
    public function  index(){
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        $hosts = Db::table('host')->paginate(5);
        $listNum = Db::table('host')->count();
        return view("host/list",['hosts'=>$hosts,'latestNotice'=>$latestNotice,'listNum'=>$listNum,'user'=>$user]);
    }}
    public function addHostMessage(Request $request){
        if($request->isPost()){
            $res = (new HostValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            if((new AdminHost())->verifyHostNumber($request->param('hostid'))){
                return $this->error("住户编号已经存在");
            }
            //开启事务
            Db::startTrans();
            try{
                $token = (new AdminHost)->saveHost($request->param());
                $funds = new Funds;
                $funds->hostuser =$request->param('hostname');
                $funds->address = $request->param('address');
                $funds->save();
                $meter = new Meter;
                $meter->hostuser =$request->param('hostname');
                $meter->save();
                // 提交事务
                Db::commit();
                if($token)
                    return $this->success("添加业主信息成功！");
            }catch(Exception $e){
                // 回滚事务
                Db::rollback();
            $this->error($e->getMessage());
            }

        }
        else{
            return view('host/addHost');
        }

    }
    public function editHostMessage(Request $request){
        $id = input("get.id");
        if($request->isPost()){
            $res = (new HostValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            $token = (new AdminHost)->updateHost($request->param());
            if($token !==false)
                return $this->success("更改业主信息成功！");
        }else{
            $oldData =(new AdminHost())->where('id',$id)->find();
            return view("host/edithost",['oldData'=>$oldData,'hideid'=>$id]);
        }

    }
    public function deleteHostMessage(){
        $request = Request::instance();
        $id = $request->post('id/d');
        $res = db('host')->where('id',$id)->delete();
        if($res !==false){
            return [
                'error' =>0,
                'msg'   =>'删除成功'
            ];
        }else{
            return [
                'error' =>1,
                'msg'   =>'删除失败'
            ];
        }
    }

}