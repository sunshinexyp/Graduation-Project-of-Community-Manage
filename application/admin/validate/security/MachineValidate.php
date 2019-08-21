<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 16:46
 */

namespace app\admin\validate\security;
use app\admin\validate\BaseValidate;

class MachineValidate extends BaseValidate
{
    protected $rule =[
        ['number','require|alphaDash','设施编号不能为空|设施编号只能为字母和数字，下划线 _ 及破折号 - '],
        ['name','require|chsAlphaNum','设施名称不能为空|设施名称只能为数字，字母，汉字'],
        ['dept','require|chs','部门不能为空|部门只能填写汉字'],
        ['purchase_time','require|date','购买时间不能为空|时间格式不对'],

    ];
}