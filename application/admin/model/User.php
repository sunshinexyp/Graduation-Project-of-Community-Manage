<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/16
 * Time: 21:01
 */
namespace app\admin\model;
use think\Model;
class User extends Model
{
    protected $table='adminuser';
  public static function saveValidateUser($request){
      //给用户传来的密码加盐加密
      $token =config("secure.token_sault");
      $mdpass = md5($request['password'].$token);
      $res = self::create([
          'username' => $request['username'],
          'password' => $mdpass,
          'create_time' => date('Y-m-d H:i:s',time()),
          'update_time' => date('Y-m-d H:i:s',time()),
        ]);
      return $res;
  }
    public function getUserByUsername($username){
        if(!$username){
            exception("用户名不合法");

        }
        $data =['username' =>$username];
        return $this->where($data)->find();
    }
    public function updateById($data,$id){
        return $this->allowField(true)->save($data,['id'=>$id]);
    }

}