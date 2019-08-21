<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/27
 * Time: 17:42
 */

namespace app\admin\model;


use think\Model;

class Visitor extends Model
{
    public function saveVisitor($param){
        //入库
        $res =self::create([
            'visitor_name' => $param['hostid'],
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
}