<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/23
 * Time: 16:53
 */

namespace app\admin\validate\security;


use app\admin\validate\BaseValidate;

class ExpenditureValidate extends BaseValidate
{
    protected $rule = [
        ['brand','isNotEmpty','类型不能为空'],
        ['outmoney','isNotEmpty|isPositiveInteger','支出金额不能为空|支出金额只能为正整数'],
        ['year','isNotEmpty|isPositiveInteger','年份不能为空|年份只能是正整数'],
        ['month','isNotEmpty|isPositiveInteger','月份不能为空|月份只能是正整数'],
        ['transactor','isNotEmpty|chsAlphaNum','办理人不能为空|名字只能是汉字、字母和数字'],
        ['expenditure_time','isNotEmpty|date','支出日期不能为空|日期格式不对'],
    ];

}