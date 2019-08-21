<?php
/**
 * Created by PhpStorm.
 * User: tsh
 * Date: 2018/8/9
 * Time: 15:02
 */

namespace app\admin\validate;
use think\Request;
use think\Validate;
use app\admin\exception\ParamException;
use app\admin\validate\IdCard;
use app\admin\model\Host;
/**
 * 构建验证器基类
 * Class BaseValidate
 * @package app\bbsAdmin\validate
 */
class BaseValidate extends Validate
{
    //批量
    public function goCheck()
    {
        //获取http传入参数
        //对这些参数做检验
        $request = Request::instance();
        $params = $request->param();
      //$params['captcha'] = strtoupper($request->param('captcha'));

        //批量验证
        $result = $this->check($params);
        if (!$result){

            return $this->error;

        }else{

            return true;
        }

    }

    /**
     * 防止客户端恶意传递非法字段修改数据库信息，读取并返回验证类中设置的验证规则
     * @param $arrays 需要校验的参数数组
     * @return array
     * @throws ParamException
     */
    public function getDataByRule($arrays)
    {
        //如果该数组中包含user_id或uid键名则抛出异常
        if (array_key_exists('user_id',$arrays)|array_key_exists('uid',$arrays)){
            //不允许包含user_id或者uid,防止恶意覆盖user_id外键
            throw new ParamException(['msg'=>'参数中包含有非法的参数名user_id或uid']);
        }

        $newArray = [];
        //遍历验证类中定义的验证规则
        foreach ($this->rule as $key => $value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }



    //自定义验证参数是否是正整数的方法
    protected function isPositiveInteger($value,$rule='',$data='',$field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){

            return true;

        }else{

            return false;
        }
    }


    /**
     * 自定义校验是否为空
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool
     */
    protected function isNotEmpty($value)
    {
        if (empty($value)&& $value!='0')
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //验证身份证的合法性
    protected function idcard_checksum18($idcard){
        if (strlen($idcard) != 18){ return false; }
        $aCity = array(11 => "北京",12=>"天津",13=>"河北",14=>"山西",15=>"内蒙古",
            21=>"辽宁",22=>"吉林",23=>"黑龙江",
            31=>"上海",32=>"江苏",33=>"浙江",34=>"安徽",35=>"福建",36=>"江西",37=>"山东",
            41=>"河南",42=>"湖北",43=>"湖南",44=>"广东",45=>"广西",46=>"海南",
            50=>"重庆",51=>"四川",52=>"贵州",53=>"云南",54=>"西藏",
            61=>"陕西",62=>"甘肃",63=>"青海",64=>"宁夏",65=>"新疆",
            71=>"台湾",81=>"香港",82=>"澳门",
            91=>"国外");
        //非法地区
        if (!array_key_exists(substr($idcard,0,2),$aCity)) {
            return false;
        }
        //验证生日
        if (!checkdate(substr($idcard,10,2),substr($idcard,12,2),substr($idcard,6,4))) {
            return false;
        }
        $idcard_base = substr($idcard, 0, 17);
        if (IdCard::idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
            return false;
        }else{
            return true;
        }
    }
    //验证手机号
    protected function isMobile($value)
    {
        $rule = '/^0?(13|14|15|17|18|19)[0-9]{9}$/';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //验证收费登记的用户是否存在
    protected function isTrueHostName($param){
        $name =(new Host)->verifyHostName($param);
        if(empty($name)){
            return false;
        }else{
            return true;
        }
    }
    //判断仪表费用是否为数字或者浮点型
    protected function isNumberFloat($param){
        if(is_numeric($param) || is_float($param)){
            return true;
        }
        return false;
    }

    //判断收费登记的年月不能在住户入住时间之前
    protected function isTimeValidate($value,$rule,$data,$field){
        $yearmonth = db('host')->field('intime')
                    ->where('hostname',$data['username'])
                     ->find();
        $yearmonth = strtotime($yearmonth['intime']);
        $year = date('Y',$yearmonth);
        if($year <= $data['year'] ){
            return true;
        }else{
            return false;
        }
    }







}