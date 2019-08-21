<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/19
 * Time: 23:36
 */

namespace app\admin\validate\security;
use app\admin\validate\BaseValidate;

class AddNoticeValidate extends BaseValidate
{
    protected $rule = [
        'title' => 'isNotEmpty|max:15|chsAlphaNum',
        'createtime' => 'require|date',
        'expiretime'=>'require|date|checkDate',
        'content'   => 'require|max:300',
    ];
    protected $message = [
        'title.require' => '公告标题必须',
        'title.chsAlphaNum'=>'公告标题只能是汉字、字母和数字',
        'title.max' => '公告标题最多不能超过15个字符',
        'createtime.require'=>'发布时间不能空',
        'createtime.date'=>'格式不对',
        'expiretime.require'=>'过期时间不能空',
        'expiretime.date'=>'格式不对',
        'expiretime.checkDate'=>'过期时间必须晚于发布时间',
        'content.require'=>'公告内容不能空',
        'content.max' => '公告内容最多不能超过300个字符',

    ];
    //自定义验证规则
    protected function checkDate($value){
        $createTime = strtotime(input("post.createtime"));
        $expireTime = strtotime(input("post.expiretime"));
        if($expireTime <= $createTime){
            return false;
        }
        return true;
    }

}
