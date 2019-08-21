<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 23:00
 */

namespace app\admin\model;


use think\Model;

class Repair extends Model
{
    protected $table='repairupload';
   // protected $resultSetType = 'collection';
    //维修表和设备表是一对一关系
    public function machine(){
        return $this->belongsTo('Machine','machine_number','machine_number');
    }




}