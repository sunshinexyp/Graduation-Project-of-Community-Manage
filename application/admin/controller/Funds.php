<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/22
 * Time: 22:38
 */

namespace app\admin\controller;
use think\Controller;
use think\Exception;
use think\Request;
use app\admin\model\Funds as AdminFunds;
use app\admin\model\Meter as AdminMeter;
use app\admin\model\Expenditure as AdminExpenditure;
use app\admin\validate\security\FundsValidate;
use app\admin\validate\security\ExpenditureValidate;
use app\admin\validate\security\MeterValidate;
use think\View;

class Funds extends Controller
{
    //收费列表
    public function showRevenueFunds(){
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
            $latestNotice = viewNotice();
            $funds = AdminFunds::paginate();
            return view('funds/showfunds',['funds'=>$funds,'latestNotice'=>$latestNotice,'user'=>$user]);
        }

    }
    //登记收费
    public function addRevenueFunds(Request $request){
        if($request->isPost()){
            $res = (new FundsValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            try{
                $token = (new AdminFunds())->saveFunds($request->param(),'0');
                if($token)
                    return $this->success("物业收费添加成功！");
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
        }else{
            return view('funds/addfunds');
        }
    }
    //编辑录入的收费信息
    public function editRevenueFunds(Request $request){
        if($request->isPost()){
            $id = $request->param('hideid');
            $res = (new FundsValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            try{
                $token = (new AdminFunds())->saveFunds($request->param(),'1',$id);
                if($token)
                    return $this->success("物业收费信息更改成功！");
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
        }else{
            $id = input('get.id');
            $oldData =(new AdminFunds())->where('id',$id)->find();
            return view('funds/update',['hideid'=>$id,'oldData'=>$oldData]);
        }
    }
    //删除收费信息
    public function deleteRevenueFunds(){
        $request = Request::instance();
        $id = $request->post('id/d');
        $res = db('funds')->where('id',$id)->delete();
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

    //收费统计
    /**
     *     1.首先查出funds表中某年某月的收费
     *      2.对funds中月份进行分组，查询出每个月份，和每个月份的总收费
     * @return \think\response\View
     */

    public function showRevenueStatistics(Request $request){
        $data = Array();
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{

        $latestNotice = viewNotice();

        //对收费表中月份分组求和
        $res = db('funds') ->where([
            'year' =>empty($request->param('year'))?2019:$request->param('year')
        ])->field('month,sum(hasmoney) as wage')->group('month')->select();
        //对仪表收费中月份分组求和
        $meter= db('meter') ->where([
            'year' =>empty($request->param('year'))?2019:$request->param('year')
        ])->field('month,sum(expense) as wage')->group('month')->select();
       //求每个月总收费
        for($i=1;$i<=12;$i++){
           foreach ($res as $r){
               if($r['month'] == $i){
                   $data[$i] = $r['wage'];
                    break;
               }
           }
           if(empty($data[$i])){
               $data[$i] =0;
           }
       }
        for($i=1;$i<=12;$i++){
            foreach ($meter as $m){
                if($m['month'] == $i){
                    $data[$i] += $m['wage'];
                    break;
                }
            }
        }
        if($request->isPost()){
         //   var_dump($request->param('year'));
            //var_dump($data);
        return ['data' =>$data,'num'=>12];
        }else{

            $years = db('expenditure')->distinct(true)->field('year')->select();
            return view('funds/revenuecount',['latestNotice'=>$latestNotice,'data'=>$data,'user'=>$user,'years'=>$years]);
        }

    }
    }
    //支出统计
    public function showSpecificCount(Request $request){
        $res = array();
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();

        for($i=1;$i<=12;$i++){
            $res[$i-1] = db('expenditure')
                ->where([
                    'year' =>empty($request->param('year'))?2019:$request->param('year'),
                    'month'=>$i
                ])->sum('outmoney');
        }
            if($request->isPost()){
        $data = db('expenditure')
            ->where([
                'year' =>$request->param('year'),
            ])->find();
     // var_dump(!empty($request->param('year'))&&empty($data));
        if(!empty($request->param('year'))&&empty($data)){
            return [
                'error' =>1,
                'msg'   =>'此年份暂无数据'
            ];
        }else{
            $years = db('expenditure')->distinct(true)->field('year')->select();
            return [
                'res'=>$res,
            ];
        }
        }else{
            View::share(['latestNotice'=>$latestNotice,
                'res'      =>$res,]);
            $years = db('expenditure')->distinct(true)->field('year')->select();
            return $this->fetch('funds/expenditurecount',['user'=>$user,'years'=>$years]);

        }
    }
    }
    //支出分类统计
    public function showBrandFunds(Request $request){
        $res = array();
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        //去重
        $brand = db('expenditure')
            ->distinct(true)
            ->field('brand')
            ->select();


       //查询出的支出类型
        $type = array($brand[0]['brand'],$brand[1]['brand'],$brand[2]['brand'],$brand[3]['brand']);
       //依次对每种支出类型，进行每月汇总
        for ($j=0;$j<4;$j++){
            for($i=1;$i<=12;$i++){
                $res[$j][$i-1] = db('expenditure')
                    ->where([
                        'brand'=>$type[$j],
                            'year' =>empty($request->param('year'))?2019:$request->param('year'),
                    'month'=>$i
                ])->sum('outmoney');
        }
        }

        if($request->isPost()){
            return [
                'res'=>$res,
                'brand'=>$brand,
            ];
        }else{
            $years = db('expenditure')->distinct(true)->field('year')->select();
            return view('funds/brandcount',['latestNotice'=>$latestNotice,'brand'=>$brand,'res'=>$res,'user'=>$user,'years'=>$years]);
        }

    }}
    //支出列表
    public function showExpenditureFunds(){
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        $expenditures = AdminExpenditure::paginate();
        return view('funds/showexpenditure',['expenditures'=>$expenditures,'latestNotice'=>$latestNotice,'user'=>$user]);
    }}
    //支出登记
    public function addExpenditureFunds(Request $request){
        if($request->isPost()){
            $res = (new ExpenditureValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            try{
                $token = (new AdminExpenditure())->saveExpenditure($request->param(),'0');
                if($token)
                    return $this->success("支出费用登记成功！");
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
        }else{
        return view('funds/addexpenditure');
        }
    }
    //修改支出明细
    public function editExpenditureFunds(Request $request){
        if($request->isPost()){
            $id = $request->param('hideid');
            $res = (new ExpenditureValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            try{
                $token = (new AdminExpenditure())->saveExpenditure($request->param(),'1',$id);
                if($token)
                    return $this->success("支出信息更改成功！");
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
        }else{
            $id = input('get.id');
            $oldData =(new AdminExpenditure())->where('id',$id)->find();
            return view('funds/editexpenditure',['hideid'=>$id,'oldData'=>$oldData]);
        }
    }
    //仪表数据列表
    public function showMeterFunds(){
        $user = loginUserInfo();
        if(!$user){
            return $this->error('您未登录，请先登录','user/login');
        }else{
        $latestNotice = viewNotice();
        $meters = AdminMeter::paginate();
        return view('funds/showmeter',['meters'=>$meters,'latestNotice'=>$latestNotice,'user'=>$user]);
    }}
    //添加仪表数据
    public function addMeterFunds(Request $request){
        if($request->isPost()){
            $res = (new MeterValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            try{
                $token = (new AdminMeter())->saveMeter($request->param(),'0',$request->param('type'));
                if($token)
                    return $this->success("仪表收费登记成功！");
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
        }else{
            return view('funds/addmeter');
        }
    }
    //修改仪表数据
    public function editMeterFunds(Request $request){

        if($request->isPost()){
            $id = $request->param('hideid');
            $res = (new MeterValidate())->goCheck();
            if($res !== true){
                return [
                    'error' =>1,
                    'msg'   =>$this->error($res),

                ];
            }
            try{
                $token = (new AdminMeter())->saveMeter($request->param(),'1',$request->param('type'),$id);

                if($token)
                    return [
                        'error'=> 0,
                        'msg'  =>'仪表信息更改成功！',

                    ];
            }catch (Exception $e){
                $this->error($e->getMessage());
            }

        }else{
            $id = input('get.id');
            $brand = input('get.brand');
            $oldData =(new AdminMeter())->where('id',$id)->find();
            return view('funds/editmeter',['hideid'=>$id,'oldData'=>$oldData,'brand'=>$brand]);
        }
    }

}