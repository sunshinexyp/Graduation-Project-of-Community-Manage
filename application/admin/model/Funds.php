<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/22
 * Time: 22:39
 */

namespace app\admin\model;


use think\Model;

class Funds extends Model
{
    public function saveFunds($param,$k,$id=''){
        switch ($k){
            case '0':{
                $res =self::create([
                    'hostuser' => $param['username'],
                    'address'   => $param['address'],
                    'year'        => $param['year'],
                    'month'      => $param['month'],
                    'takingitem'   => $param['item'],
                    'deservemoney'   => $param['salary'],
                    'fundtime'   => $param['feetime'],
                    'hasmoney'   => $param['yijiao'],
                    'hasnotmoney'   => $param['qianfei'],
                ]);
                return $res;
                break;
            }
            case '1':{
                $res =self::save([
                    'hostuser' => $param['username'],
                    'address'   => $param['address'],
                    'year'        => $param['year'],
                    'month'      => $param['month'],
                    'takingitem'   => $param['item'],
                    'deservemoney'   => $param['salary'],
                    'fundtime'   => $param['feetime'],
                    'hasmoney'   => $param['yijiao'],
                    'hasnotmoney'   => $param['qianfei'],
                ],['id'=>$id]);
                return $res;
                break;
            }
        }

    }



}