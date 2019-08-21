<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/23
 * Time: 16:04
 */

namespace app\admin\model;

use think\Model;

class Meter extends Model
{
    public function saveMeter($param,$k,$type,$id=''){
        switch ($k){
            case '0':{
                switch ($type){
                    case '1':{
                        $res =self::create([
                            'hostuser' => $param['zhuhu'],
                            'dosage'   => $param['dosage'],
                            'perprice'        => $param['price'],
                            'expense'      => $param['price']*$param['dosage'],
                            'dealer'   => $param['dealer'],
                            'start_time'   => $param['start_time'],
                            'end_time'   => $param['end_time'],
                            'year'       => date('Y',strtotime($param['end_time'])),
                            'month'     => date('n',strtotime($param['end_time'])),
                            'brand'    =>'水表'
                        ]);
                        return $res;
                        break;
                    }
                    case '2':{
                        $res =self::create([
                            'hostuser' => $param['zhuhu'],
                            'dosage'   => $param['dosage'],
                            'perprice'        => $param['price'],
                            'expense'      =>  $param['price']*$param['dosage'],
                            'dealer'   => $param['dealer'],
                            'start_time'   => $param['start_time'],
                            'end_time'   => $param['end_time'],
                            'year'       => date('Y',strtotime($param['end_time'])),
                            'month'     => date('n',strtotime($param['end_time'])),
                            'brand'    =>'电表'
                        ]);
                        return $res;
                        break;
                    }
                    case '3':{
                        $res =self::create([
                            'hostuser' => $param['zhuhu'],
                            'dosage'   => $param['dosage'],
                            'perprice'        => $param['price'],
                            'expense'      => $param['price']*$param['dosage'],
                            'dealer'   => $param['dealer'],
                            'start_time'   => $param['start_time'],
                            'end_time'   => $param['end_time'],
                            'year'       => date('Y',strtotime($param['end_time'])),
                            'month'     => date('n',strtotime($param['end_time'])),
                            'brand'    =>'气表'
                        ]);
                        return $res;
                        break;
                    }
            }
                break;
            }
            case '1':{
                switch ($type){
                    case '1':{
                        $res =self::save([
                            'hostuser' => $param['zhuhu'],
                            'dosage'   => $param['dosage'],
                            'perprice'        => $param['price'],
                            'expense'      => $param['price']*$param['dosage'],
                            'dealer'   => $param['dealer'],
                            'start_time'   => $param['start_time'],
                            'end_time'   => $param['end_time'],
                            'year'       => date('Y',strtotime($param['end_time'])),
                            'month'     => date('n',strtotime($param['end_time'])),
                            'brand'    =>'水表'
                        ],['id'=>$id]);
                        return $res;
                        break;
                    }
                    case '2':{
                        $res =self::save([
                            'hostuser' => $param['zhuhu'],
                            'dosage'   => $param['dosage'],
                            'perprice'        => $param['price'],
                            'expense'      =>  $param['price']*$param['dosage'],
                            'dealer'   => $param['dealer'],
                            'start_time'   => $param['start_time'],
                            'end_time'   => $param['end_time'],
                            'year'       => date('Y',strtotime($param['end_time'])),
                            'month'     => date('n',strtotime($param['end_time'])),
                            'brand'    =>'电表'
                        ],['id'=>$id]);
                        return $res;
                        break;
                    }
                    case '3':{
                        $res =self::save([
                            'hostuser' => $param['zhuhu'],
                            'dosage'   => $param['dosage'],
                            'perprice'        => $param['price'],
                            'expense'      => $param['price']*$param['dosage'],
                            'dealer'   => $param['dealer'],
                            'start_time'   => $param['start_time'],
                            'end_time'   => $param['end_time'],
                            'year'       => date('Y',strtotime($param['end_time'])),
                            'month'     => date('n',strtotime($param['end_time'])),
                            'brand'    =>'气表'
                        ],['id'=>$id]);
                        return $res;
                        break;
                    }
                }
                break;
            }
        }
}
}