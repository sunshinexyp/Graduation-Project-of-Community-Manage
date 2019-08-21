<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/23
 * Time: 16:53
 */

namespace app\admin\validate\security;


use app\admin\validate\BaseValidate;

class FundsValidate extends BaseValidate
{
    protected $rule = [
        ['username','isNotEmpty|chsAlpha|isTrueHostName','住户名不能为空|住户名只能是汉字和字母|无此住户'],
        ['address','isNotEmpty|chsAlphaNum','物业地址不能为空|物业地址只能是汉字、字母和数字'],
        ['year','isNotEmpty|isPositiveInteger|isTimeValidate','年份不能为空|年份只能是正整数|年份不能小于入住年份'],
        ['month','isNotEmpty|isPositiveInteger','月份不能为空|月份只能是正整数'],
        ['item','isNotEmpty|chs','收费项目不能为空|收费项目只能为汉字'],
        ['salary','isNotEmpty|isPositiveInteger','应收金额不能为空|应收金额只能为正整数'],
        ['feetime','isNotEmpty|date','缴费日期不能为空|日期格式不对'],
        ['yijiao','isNotEmpty|isPositiveInteger','已交金额不能为空|已交金额只能是正整数'],
        ['qianfei','isNotEmpty|number','欠费金额不能为空|欠费金额只能是数字']

    ];

}