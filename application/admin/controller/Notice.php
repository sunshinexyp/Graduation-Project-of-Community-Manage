<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 12:39
 */

namespace app\admin\controller;
use app\admin\validate\security\AddNoticeValidate;
use think\Controller;
use app\admin\model\Notice as AdminNotice;
use think\Db;
use think\Request;
class Notice extends Controller
{
    public function index(){
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $notices = Db::table('notice')->order('create_time','desc')->paginate(4);
        $listNum = Db::table('notice')->count();
        $latestNotice = viewNotice();
        return $this->fetch("notice/list",['notices' => $notices,'latestNotice'=>$latestNotice,'listNum'=>$listNum,'user'=>$user]);
    }}
    public function addNotice(Request $request){
        if($request->isPost()){
            $res = (new AddNoticeValidate())->goCheck();
            if($res!==true){
                return [
                    'error' =>1,
                    'msg'   =>$this->error($res)
                ];
            }
         $token = (new AdminNotice)->saveNotice($request->param());
            if($token)
                return [
                    'error'=>0,
                    'msg'  =>'发布新公告成功！'
                ];
        }else{
            return view('notice/addNotice');
        }

    }

    public function stopNotice(Request $request){
        $id = $request->request('id');
        $notice = (new AdminNotice);
        $res = $notice->save([
            'status'=> 0,
        ],['id'=>$id]);
        if($res !== false){
            $res =  [
                'error' => 0,
                'msg'   => '已停用!',
            ];
            return $res;
        }else{
            $res =[
                'error' => 1,
                'msg'   => '停用失败',
            ];
            return $res;
        }
    }

    public function startNotice(Request $request){
        $id = $request->request('id');
        $notice = (new AdminNotice);
        //开启前判断是否过期
        $tt = $notice->where('id',$id)->find();
        if(time()>strtotime($tt['expire_time'])){
            $res =  [
                'error' => 1,
                'msg'   => '该公告已过期，启用失败!',
            ];
            return $res;
        }

        //启用之前先检查，其他开启的公告，将它的状态更改为关闭
        $hasStart = $notice->where('status',1)->select();
        if(!empty($hasStart))
            foreach ($hasStart as $down){
                $down->save(['status'=>0],['id'=>$down->id]);
            }

        $res = $notice->save([
            'status'=> 1,
        ],['id'=>$id]);
        if($res !== false){
            $res =  [
                'error' => 0,
                'msg'   => '已启用!',
            ];
            return $res;
        }else{
            $res =[
                'error' => 1,
                'msg'   => '启用失败',
            ];
            return $res;
        }
    }

    public function delete(){
        $request = Request::instance();
        $id = $request->post('id/d');
       $res = db('notice')->where('id',$id)->delete();
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