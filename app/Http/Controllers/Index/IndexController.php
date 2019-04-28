<?php

namespace App\Http\Controllers\index;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogPost;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\Models\User;
class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id=$request->user_id;
        $where=[
            'user_id'=>$user_id
        ];
        $UserModel=new User;
        $res = $UserModel->where($where)->delete();
        if($res == 1){
             echo '<script>alert("删除成功");window.location.href="/show";</script>';
            
            }else{
            echo '<script>alert("删除失败");window.location.href="show";</script>'; 
            
            }
    }
    // /**表单验证第二种 */
    // public function validate(){

    // }
    /**
     * Store a newly created resource in storage.
     *保存
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //表单验证第一种
        // $validatedData = $request->validate([       
        //       'user_name' => 'required|unique:user|max:30|min:3',  
        //        'user_age' => 'required|unique:user|max:3|min:1',   
        // ],[
        //     'user_name.required' => '用户名必填',
        //     'user_name.unique' => '用户名已经存在',
        //     'user_name.max' => '用户名最大30个字节',
        //     'user_name.min' => '用户名最小3个字节',
        //     'user_age.required' => '年龄必填',   
        //     'user_age.max' => '年龄最大3字节', 
        //     'user_age.min' => '年龄最小1字节', 
        // ]); 
        /**表单验证第三种*/ 
         $post=$request->all();
    //     $dd=Validator::make($post, [  
    //         'user_name' => 'required|unique:user|max:30|min:3',  
    //     ],[
    //         'user_name.required' => '用户名必填',
    //     ])
    //         ->validate();
    //    // $errors=$dd->errors();
    //      if($dd->fails()){
    //         return redirect('add')->withErrors($dd)-withInput();
    //      }
        unset($post['_token']);
        if($request->hasFile('head')) {   
            $post['head']=$this->upload($request,'head');
        } 
        $UserModel=new User;
        $res=$UserModel->insert($post);
        if($res){
            return redirect('show')->with('msg','添加成功');
        }else{
            echo '<script>alert("添加失败");window.location.href="index";</script>'; 
        }
       
    }
    /**文件上传 */
    public function upload(Request $request,$name){
        if ($request->file($name)->isValid()) {
            $photo=$request->file($name);
            $extension = $request->$name->extension(); 
            $newfilename=$photo->store('images');
            //$newfilename = ;
        
            return  $newfilename;
        }
        exit('文件上传过程出错');
    }
    /**
     * Display the specified resource.
     *修改展示
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $query=$request->all(); 
        $where=[];
        $user_name=$query['user_name']??''; 
        if($user_name){
            $where[]=['user_name','like',"%$user_name%"];
        }
        $user_age=$query['user_age']??'';
        if($user_age){
            $where['user_age']=$user_age;
        }
        $pagesize=config('app.pageSize',3);
        $UserModel=new User;
        $data=  $UserModel->where($where)->paginate($pagesize);
    
        return view('show',['data'=>$data,'user_name'=>$user_name,'user_age'=>$user_age]);
    }

    /**
     * Show the form for editing the specified resource.
     *修改页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user_id=$request->user_id;
        $where=[
            'user_id'=>$user_id
        ];
        $UserModel=new User;
        $data =$UserModel->where($where)->get();
        return view('edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *修改执行
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$user_id)
    {
        $post=$request->all();
      
        unset($post['_token']);
        if($request->hasFile('edit_head')) {   
            $post['head']=$this->upload($request,'edit_head');
            unlink('/images/$post[head]');
        } 
        unset($post['edit_head']);
       //dd($post);die;
       $UserModel=new User;
       $res=$UserModel->where('user_id',$post['user_id'])->update($post);
    //   dd($res);die;
        if($res == 1){
            echo '<script>alert("修改成功");window.location.href="show";</script>';
            
            }else{
            echo '<script>alert("修改失败");window.location.href="show";</script>'; 
            
            }
    }

    /*
     * @content 唯一性
     */
    public function indexdd(Request $request)
    {
        $user_name=$request->user_name;
        $UserModel=new User;
        $data=$UserModel->where('user_name',$user_name)->count();
        if($data>0){
            return 1;
        }else{
            return 2;
        }
    }
   
}
