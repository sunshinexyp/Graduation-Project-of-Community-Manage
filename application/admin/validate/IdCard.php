<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 22:22
 */

namespace app\admin\validate;


class IdCard
{
    static function idcard_verify_number($idcard_base){
        if (strlen($idcard_base) != 17){ return false; }
        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

        $checksum = 0;
        for ($i = 0; $i < strlen($idcard_base); $i++){
            $checksum += substr($idcard_base, $i, 1) * $factor[$i];
        }

        $mod = strtoupper($checksum % 11);
        $verify_number = $verify_number_list[$mod];

        return $verify_number;
    }
}
