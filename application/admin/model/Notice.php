<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/18
 * Time: 12:39
 */

namespace app\admin\model;


use think\Model;

class Notice extends Model
{
    protected $visible = ['title','content','create_time'];
    //最新公告
    public function getLastestNotice(){
        //查询构造器
        $latestNotice = self::all(function($query){
            $query->where('status', 1)->limit(1)->order('create_time','desc');
        });
       // var_dump($latestNotice);
        if(!empty($latestNotice)){
            $expireTime = $latestNotice[0]->expire_time;
            //如果过期
            if(time()>strtotime($expireTime)){
                $notice = self::get($latestNotice[0]->id);
                $notice->status = 0;
                $notice->save();
            }
        }
        return $latestNotice;
    }
    public function saveNotice($request){
        //再发布之前，检查有无其他公告在发布状态
            $upStatus = self::all(['status'=>1]);
            if(!empty($upStatus))
            foreach ($upStatus as $down){
              $this->save(['status'=>0],['id'=>$down->id]);
            }
            $res = self::create([
                'title' => $request['title'],
                'create_time' => $request['createtime'],
                'expire_time' => $request['expiretime'],
                'status' => 1,
                'content' => $request['content'],
                'publisher' => session('username','','think')
            ]);

            return $res;
        }

}