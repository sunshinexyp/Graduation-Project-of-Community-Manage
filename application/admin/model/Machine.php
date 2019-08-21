<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 15:44
 */

namespace app\admin\model;


use think\Model;

class Machine extends Model
{

    public function saveMachine($param){
        $res =self::create([
            'machine_number' => $param['number'],
            'machine_name'   => $param['name'],
            'purchase_time'        => $param['purchase_time'],
            'dept'      => $param['dept'],
            'desc'   => $param['desc'],
        ]);
        return $res;
    }
    public function updateMachine($param){
        $res=self::where('id',$param['hideid'])->update([
            'machine_number' => $param['number'],
            'machine_name'   => $param['name'],
            'purchase_time'        => $param['purchase_time'],
            'dept'      => $param['dept'],
            'desc'   => $param['desc'],
        ]);
        return $res;
    }
    //设备表关联维修升级表,一对一关联
    public function repair_upload(){
        return $this->hasOne('repairupload','machine_number','machine_number');
    }
}