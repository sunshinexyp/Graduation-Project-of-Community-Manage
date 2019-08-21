<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 21:11
 */

namespace app\admin\model;


use think\Model;

class Host extends Model
{
    public function saveHost($param){
        //入库
    $res =self::create([
            'hostnumber' => $param['hostid'],
            'hostname'   => $param['hostname'],
            'sex'        => $param['sex'],
            'phone'      => $param['phone'],
            'identify'   => $param['card'],
            'birthplace' => $param['city'],
            'intime'     => $param['intime'],
            'roomarea'   => $param['roomarea'],
            'workplace'  => $param['workplace'],
            'address'    => $param['address'],
        ]);
        return $res;
    }

    public function updateHost($param){
        $res=self::where('id',$param['hideid'])->update([
            'hostname'   => $param['hostname'],
            'sex'        => $param['sex'],
            'phone'      => $param['phone'],
            'identify'   => $param['card'],
            'birthplace' => $param['city'],
            'intime'     => $param['intime'],
            'roomarea'   => $param['roomarea'],
            'workplace'  => $param['workplace'],
            'address'    => $param['address'],
        ]);
        return $res;
    }

    public function verifyHostNumber($param){
        return self::where('hostnumber',$param)->find();
    }
    public function verifyHostName($param){
        return self::where('hostname',$param)->find();
    }


}