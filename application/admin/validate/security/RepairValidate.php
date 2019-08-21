<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 16:46
 */

namespace app\admin\validate\security;
use app\admin\validate\BaseValidate;

class RepairValidate extends BaseValidate
{
    protected $rule =[
        ['action_time','require|date','时间不能为空|时间格式不对'],
        ['people','require|chsAlpha','办理人不能为空|办理人只能为数字，字母'],
        ['desc','require','维修情况不能为空'],

    ];
}