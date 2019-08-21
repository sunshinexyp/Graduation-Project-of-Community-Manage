<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 21:13
 */

namespace app\admin\validate\security;
use app\admin\validate\BaseValidate;

class VisitorValidate extends BaseValidate
{
    protected $rule = [
        ['visitor_name','isNotEmpty|chsAlpha','住户名不能为空|住户名只能是汉字和字母'],
        ['sex','isNotEmpty|in:男,女','性别不能为空|性别只能为男或女'],
        ['contact','isNotEmpty|regex:1[34578]\d{9}','手机号不能为空|手机格式不正确'],
        ['card','isNotEmpty|idcard_checksum18','身份证不能为空|身份证号码不合法'],
        ['visited','isNotEmpty|chsAlpha|isTrueHostName','住户名不能为空|住户名只能是汉字和字母|无此住户'],
        ['visit_time','isNotEmpty|date','来访时间不能为空|时间格式不正确'],
    ];
}