<?php
/**
 * Created by PhpStorm.
 * User: tsh
 * Date: 2018/8/19
 * Time: 12:14
 */

namespace app\admin\validate\security;


use app\admin\validate\BaseValidate;

class LoginValidate extends BaseValidate
{
    protected $rule = [
        'username' => 'require|max:25|chsAlpha',
        'password' => 'require|length:6,10|alphaNum',

    ];
    protected $message = [
        'username.require' => '昵称必须',
        'username.max' => '昵称最多不能超过25个字符',
        'username.chsAlpha'=>'昵称只能是汉字和字母',
        'password.alphaNum'=>'密码只能是字母和数字',
        'password.require' => '密码必须',
        'password.length' => '密码的长度为6~10位',
    ];
}