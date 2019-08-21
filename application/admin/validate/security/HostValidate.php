<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/20
 * Time: 21:13
 */

namespace app\admin\validate\security;
use app\admin\validate\BaseValidate;

class HostValidate extends BaseValidate
{
    protected $rule = [
        ['hostid','isNotEmpty|max:8','住户编号不能为空|账号长度不能超过8个字符','self::MUST_VALIDATE'],
        ['hostname','isNotEmpty|chsAlpha','住户名不能为空|住户名只能是汉字和字母'],
        ['sex','isNotEmpty|in:0,1','性别不能为空|性别只能为男或女'],
        ['phone','isNotEmpty|isMobile','手机号不能为空|手机格式不正确'],
        ['card','isNotEmpty|idcard_checksum18','身份证不能为空|身份证号码不合法'],
        ['city','isNotEmpty|chs','籍贯不能为空|籍贯只能为汉字'],
        ['intime','isNotEmpty|date','入住时间不能为空|入住时间格式不正确'],
        ['roomarea','isNotEmpty|isPositiveInteger|max:3','建筑面积不能为空|建筑面积必须是正整数|建筑面积长度不能超过3位'],
        ['workplace','isNotEmpty|chsAlphaNum','工作单位不能为空|工作单位只能是汉字、字母和数字'],
        ['address','isNotEmpty|chsAlphaNum','物业地址不能为空|物业地址只能是汉字、字母和数字']

    ];
}