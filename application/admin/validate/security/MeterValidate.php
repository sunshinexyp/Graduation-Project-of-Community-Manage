<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/25
 * Time: 22:02
 */

namespace app\admin\validate\security;

use app\admin\validate\BaseValidate;
class MeterValidate extends BaseValidate
{
    protected $rule = [
        ['zhuhu','require|chsAlpha|isTrueHostName','住户名不能为空|住户名只能是汉字和字母|无此住户'],
        ['dosage','require|isNumberFloat','用量不能为空|用量只能是浮点类型或者数字'],
        ['price','require|isNumberFloat','单价不能为空|单价只能是浮点类型或者数字'],
        ['dealer','require|chs','办理人不能为空|办理人名字只能为汉字'],
        ['start_time','require|date','开始日期不能为空|日期格式不对'],
        ['end_time','require|date','结束日期不能为空|日期格式不对'],

    ];
}