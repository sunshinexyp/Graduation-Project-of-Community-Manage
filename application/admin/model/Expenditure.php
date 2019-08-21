<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/23
 * Time: 15:27
 */

namespace app\admin\model;


use think\Model;

class Expenditure extends Model
{
    public function saveExpenditure($param,$k,$id=''){
        switch ($k){
            case '0':{
                $res =self::create([
                    'outmoney' => $param['outmoney'],
                    'brand'   => $param['brand'],
                    'year'        => $param['year'],
                    'month'      => $param['month'],
                    'transactor'   => $param['transactor'],
                    'expenditure_time'   => $param['expenditure_time'],
                    'detail'   => $param['detail']
                ]);
                return $res;
                break;
            }
            case '1':{
                $res =self::save([
                    'outmoney' => $param['outmoney'],
                    'brand'   => $param['brand'],
                    'year'        => $param['year'],
                    'month'      => $param['month'],
                    'transactor'   => $param['transactor'],
                    'expenditure_time'   => $param['expenditure_time'],
                    'detail'   => $param['detail']
                ],['id'=>$id]);
                return $res;
                break;
            }
        }

    }
}