<?php
namespace app\admin\controller;

use app\admin\validate\security\RegisterValidate;
use app\admin\validate\security\LoginValidate;
use think\Controller;
use think\Request;
use think\captcha\Captcha;
use app\admin\model\User as AdminUser;
use think\Db;
use think\Exception;

class User extends Controller
{
    //用户注册
    public function register(Request $request){
        if($request->isPost()){
           $res = (new RegisterValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            $isExist  = (new AdminUser)->getUserByUsername($request->param('username'));
            if(!empty($isExist)){
                return $this->error("用户名已经存在");
            }
            if($request->param('password')!== $request->param('repassword')){
                return $this->error("两次密码输入不一致");
            }
            $ins = AdminUser::saveValidateUser($request->param());
            if($ins){
                return $this->success("注册成功@~@","user/login");
            }
        }else{
            return view("user/register");
        }

    }
    //登录
    public function login(Request $request){

        if($request->isPost()){
            $res = (new LoginValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            $username =$request->param('username');
            $password = $request->param('password');

            $token =config("secure.token_sault");
            $password = md5($password.$token);;
            $where =array(
                'username' => $username,
                'password' => $password
            );
            $res  = Db::table("adminuser")->where($where)->find();

            session('username',$username,'think');
            if($res){
                return $this->success("登陆成功@~@",'display/index');
            }else{
                return $this->error("登录失败，用户名或密码错误");
            }
        }else{
            return view("user/login");
        }

    }
    //修改密码
    public function changePassword(Request $request){
        if($request->isPost()){
            //做数据校验
            $token =config("secure.token_sault");
            $password = md5($request->param('repassword').$token);
            $res = (new LoginValidate())->goCheck();
            if($res!==true){
                return $this->error($res);
            }
            try{
                $user =(new AdminUser)->getUserByUsername($request->param('username'));
                if(!$user || $user->status !=1){
                    $this->error("该用户不存在");

                }
                if($request->param('password')!== $request->param('repassword')){
                    return $this->error("两次密码输入不一致");
                }
               $res = (new AdminUser)->updateById(['password'=>$password],$user->id);
                if($res){
                   return $this->success('找回密码成功',url('user/login'));
                }
            }catch(Exception $e){
                $this->error($e->getMessage());
            }

        }else{
            return view("user/changepassword");
        }

    }
    public function show_captcha(){

        $config =array(
            'codeSet'     =>   '3456789abcdefghijkmnpqrstuvwxy' ,
            'fontSize'    =>    14,
            'length'      =>    4,
            'useNoise'    =>    false,
            'imageH'      =>    45,
            'imageW' 	  =>      90,
            'expire'      =>    1800,
            'fontttf'     =>    '6.ttf' ,
            'useImaBg'    =>     true
        );
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    /**用户退出
     * @return array
     */
    public function logout()
    {
        session(null,'');
        return $this->redirect("login");
    }

    //用户管理
    public function userUploadManagement(){
        $username = session('username','','think');
        if(empty($username)){
            return $this->error('您未登录，请先登录','user/login');
        }
        if(Request::instance()->isPost()){
            $file = request()->file('file');
            $info = $file->move(ROOT_PATH.'public'.DS.'uploads');
            $path = DS . 'uploads' . DS . $info->getSaveName();

            $path=str_replace("\\","/",$path);
            $res = db('adminuser')->where('username',$username)
                                  ->update(['avatar'=>$path]);
            if($info &&$res !==false){
                return json_encode([
                    'code' => 'ok',
                    'src'  => $path,
                    'name' =>$info->getSaveName()
                ]);
            }else{
                return  json_encode([
                    'code' => 'error',
                    'src'  => ''
                ]);
            }
        }else{
            $user = db('adminuser')
                ->where('username',$username)
                ->field('avatar')->find();
            $this->assign('username',$user);
            $this->assign('username',$username);
            $latestNotice = viewNotice();
            return view('user/management',['latestNotice'=>$latestNotice]);
        }
    }
    public function userManagement(){
        $username = session('username','','think');
        if(empty($username)){
            return $this->error('您未登录，请先登录','user/login');
        }
        if(Request::instance()->isPost()){
            $isrename =(new AdminUser)->getUserByUsername(Request::instance()->param('nickname'));
            if($isrename['username']&&$isrename['username'] != $username){
                return $this->error("该昵称已被占用");
            }
            $res = db('adminuser')->where('username',$username)
                   ->update(['username'=>Request::instance()->param('nickname'),
                       'lock' =>Request::instance()->param('lock')]);
            session('username',Request::instance()->param('nickname'),'think');
            if($res!==false){
                return $this->success("成功@~@");
            }
        }else{
            $user = db('adminuser')
                ->where('username',$username)
                ->field('avatar,lock,username')->find();
            $this->assign('username',$username);
            $latestNotice = viewNotice();
            return view('user/management',['latestNotice'=>$latestNotice,'user'=>$user]);
        }
    }
}
