<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/16
 * Time: 21:39
 */

namespace app\admin\behavior;
use app\admin\model\Notice;

class AllNotice
{
    public function run(&$param){
        //echo $param;
       return (new Notice)->getLastestNotice();
    }
}