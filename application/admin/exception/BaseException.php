<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 下午 6:09
 */

namespace app\admin\exception;


use think\Exception;
use Throwable;

/**
 * Class BaseException
 * 自定义异常类的基类
 */

class BaseException extends Exception
{
    //http 状态码
    public $code=400;
    public $msg='invalid parameters';
    public $errorCode=999;

    public function __construct($param=[])
    {
        if(!is_array($param)){
            return;
        }
        if(array_key_exists('code',$param)){
            $this->code =$param['code'];
        }
        if(array_key_exists('msg',$param)){
            $this->msg =$param['msg'];
        }
        if(array_key_exists('errorCode',$param)){
            $this->errorCode =$param['errorCode'];
        }
    }


}






