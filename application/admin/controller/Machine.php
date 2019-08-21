<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 15:26
 */

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\Machine as AdminMachine;
use app\admin\model\Repair as AdminRepair;
use app\admin\validate\security\MachineValidate;
use app\admin\validate\security\RepairValidate;

class Machine extends Controller
{
    //增加公共设施
    public function addPublicMachine(Request $request){
        if($request->isPost()){

            $res = (new MachineValidate())->goCheck();

            if($res!==true){
                return [
                    'error' =>1,
                    'msg'   =>$this->error($res)
                ];
            }
            $token = (new AdminMachine())->saveMachine($request->param());
            if($token)
                return [
                    'error'=>0,
                    'msg'  =>'公共设施登记成功！'
                ];
        }else{
            $user = loginUserInfo();
            if(!$user){
                return $this->error('您未登录，请先登录','user/login');
            }else{
            $latestNotice = viewNotice();
            return view('machine/index',['latestNotice'=>$latestNotice,'user'=>$user]);
        }}

    }

    //公共设施列表
    public function showPublicMachine(){
        $machines = db('machine')->paginate(6);
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        return view('machine/list',['latestNotice'=>$latestNotice,'machines'=>$machines,'user'=>$user]);
    }}

    public function editPublicMachine(Request $request){
        $id = input("get.id");
        if($request->isPost()){
            $res = (new MachineValidate())->goCheck();
            if($res!==true){
                return [
                    'error' =>1,
                    'msg'   =>$this->error($res)
                ];
            }

            $token = (new AdminMachine())->updateMachine($request->param());
            if($token !==false)
                return [
                    'error'=>0,
                    'msg'  =>'更改公共设施信息成功！'
                ];
        }else{
            $machine =(new AdminMachine())->where('id',$id)->find();
            return view("machine/edit",['machine'=>$machine,'hideid'=>$id]);
        }
    }
    public function deletePublicMachine(){
        $request = Request::instance();
        $id = $request->post('id/d');
        $res = db('machine')->where('id',$id)->delete();
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
    public function managePublicStatus(Request $request){
        $model = new AdminMachine();
        $repair = new AdminRepair;
        $smallmodel =$model::get($request->param('id'));
        $k = empty($repair->id)? 1:$repair->getLastInsID()+1;
        switch ($request->param('token')){
            case 'repair':
            {
                $smallmodel->status = 1;
                $smallmodel->save();
                //点击维修时，想维修表中插入设备名字，状态
                $repair->reup_number ="RE_4266".$k;
                $repair->machine_number = $smallmodel->machine_number;
                $repair->status =1;
                $repair->save();
                return ['error '=>0,'msg'=>'该设备已损坏'];
                break;
            }
            case 'upload':{
                $smallmodel->status = 2;
                $smallmodel->save();
                //点击升级时，想维修表中插入设备名字，状态
                $repair->reup_number ="UP_0000".$k;
                $repair->machine_number = $smallmodel->machine_number;
                $repair->status =2;
                $repair->save();
                return ['error '=>0,'msg'=>'该设备需升级'];
                break;
            }
        }

    }

    public function showRepairMachine(){
        $repairs =AdminRepair::paginate(7);
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        return view('machine/repair',['repairs'=>$repairs,'latestNotice'=>$latestNotice,'user'=>$user]);
    }}
    public function addRepairMachine(Request $request){
        if($request->isPost()){

            $res = (new RepairValidate())->goCheck();

            if($res!==true){
                return $this->error($res);
            }
            //更改维修升级表
            $model =new AdminRepair;
            $token =$model
                   ->where('id', $request->param('hideid'))
                   ->update([
                       'reup_date' => $request->param('action_time'),
                       'status'    =>0,
                       'person'    =>$request->param('people'),
                       'content'   =>$request->param('desc')
                   ]);


            //更改关联的公共设施表中的状态
            $model =AdminRepair::get( $request->param('hideid'));
            $model->machine->status = 0;
            $model->machine->save();
            if($token )
                return $this->success('记载成功');
        }
        else{
            $id = input("id/d");
            $currenStatus = (new AdminRepair)->allowField('status')->get($id);
            return view('machine/addActionMessage',['status'=>$currenStatus->status,'hideid'=>$id]);
        }

    }

    public function editRepairMachine(Request $request){
        $id = input("get.id");
        if($request->isPost()){
            $res = (new RepairValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            //更改维修升级表
            $model =new AdminRepair;
            $token =$model
                ->where('id', $request->param('hideid'))
                ->update([
                    'reup_date' => $request->param('action_time'),
                    'status'    =>0,
                    'person'    =>$request->param('people'),
                    'content'   =>$request->param('desc')
                ]);
            if($token !==false)
                return $this->success("更改公共设施信息成功！");
        }else{

            $repair =(new AdminRepair())->where('id',$id)->find();
            return view("machine/editActionMessage",['repair'=>$repair,'hideid'=>$id]);
        }
    }


}