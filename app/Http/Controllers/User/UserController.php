<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Test;
class UserController extends Controller
{
    //登录
    public function login(){
        return view('login');
    }
    //登录执行
    public function logindo(Request $request){
        $user_name=$request->user_name;
        $user_pwd=$request->user_pwd;
        $TestModel=new Test;
        $data=$TestModel->where('user_name',$user_name)->first(); 
         session(['user_id'=>$data->user_id]);
         if($data){
           
             return redirect('news')->with('msg','登录成功');
         }else{
            echo '<script>alert("登录失败");window.location.href="login";</script>'; 
         }
      
        
    }
    //注册页面
    public function register(){
        return view('register');
    }
    //注册执行页面
    public function registerdo(Request $request){
        $user_name=$request->user_name;
        $user_pwd=$request->user_pwd;
        $user_pwd1=$request->user_pwd1;
        $user_pwd=$user_pwd==$user_pwd1;
        $user_pwd=encrypt($user_pwd);
        
        $TestModel=new Test;
        $res=$TestModel->insert(['user_name'=>$user_name,'user_pwd'=>$user_pwd]);
        if($res){
            return redirect('login')->with('msg','添加成功');
        }else{
            echo '<script>alert("添加失败");window.location.href="registerdo";</script>'; 
        }
    }
}
