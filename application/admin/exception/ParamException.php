<?php

namespace app\admin\exception;

/**
 * Class ParameterException
 * 通用参数类异常错误
 */
class ParamException extends BaseException
{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = "invalid parameters";
}