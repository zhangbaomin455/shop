<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
class NewsController extends Controller
{
    public function news(){
        return view('news');
    }

     /**添加 */
     public function newsdo(Request $request){
        $post=$request->all();
       // dd($post);die;
        unset($post['_token']);
        if($request->hasFile('head')) {   
            $post['head']=$this->upload($request,'head');
        } 
        $NewsModel=new News;
        $res=$NewsModel->insert($post);
        if($res){
            return redirect('list')->with('msg','添加成功');
        }else{
            echo '<script>alert("添加失败");window.location.href="news";</script>'; 
        }
    }
    /*
     * @content 唯一性
     */
    public function newsdd(Request $request)
    {
        $news_name=$request->news_name;
        $news_id=$request->news_id;
        $type=$request->type;
        $NewsModel=new News;
        if($type==1){
        // var_dump($w_name);
       $data=$NewsModel->where('news_name',$news_name)->first();
       if($data==''){
           echo 1;
       }else{
           echo 2;
       }
   }else if($type==2){
       $where=[
           ['news_id','!=',$news_id],
           ['news_name','=',$news_name]
       ];
       $data=$NewsModel->where($where)->count();
        if($data>0){
            echo 1;
        }else{
            echo 2;
        }
   }
}
    /**文件上传 */
    public function upload(Request $request,$name){
        if ($request->file($name)->isValid()) {
            $photo=$request->file($name);
            $extension = $request->$name->extension(); 
            $newfilename=$photo->store('images');
        
            return  $newfilename;
        }
        exit('文件上传过程出错');
    }
    /**展示 */
    public function list(Request $request)
    {
        $query=$request->all(); 
        $where=[];
        $news_name=$query['news_name']??''; 
        if($news_name){
            $where[]=['news_name','like',"%$news_name%"];
        }
        $news_web=$query['news_web']??'';
        if($news_web){
            $where['news_web']=$news_web;
        }
        $pagesize=config('app.pageSize',1);
        $NewsModel=new News;
        $data= $NewsModel->where($where)->paginate($pagesize);
        return view('list',['data'=>$data,'news_name'=>$news_name,'news_web'=>$news_web]);
    }
       //单删
       public function newdel(Request $request)
       {
           $Newsmodel=new News;
           $where=[
               'news_id'=>$request->news_id,
           ];
           $res= $Newsmodel->where($where)->delete();
           if($res){
               echo 1;
           }else{
               echo 2;
           }
       }

        /**
     * Show the form for editing the specified resource.
     *修改页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function newedit(Request $request)
    {
        $news_id=$request->news_id;
        $where=[
            'news_id'=>$news_id
        ];
        $NewsModel=new News;
        $data =$NewsModel->where($where)->get();
       // dd($data);die;
        return view('newedit',['data'=>$data]);
    }
    public function updatedd(Request $request,$news_id)
    {
             $post=$request->all();
      
            unset($post['_token']);
            if($request->hasFile('edit_head')) {   
                $post['head']=$this->upload($request,'edit_head');
                unset($post['edit_head']);
            } 
          // dd($post);die;
            $NewsModel=new News;
            $res=$NewsModel->where('news_id',$post['news_id'])->update($post);
        if($res==1){
            echo '<script>alert("修改成功");window.location.href="list";</script>';
        }else if($res==0){
            echo '<script>alert("修改成功");window.location.href="list";</script>';
        }else{
             echo '<script>alert("修改失败");window.location.href="list";</script>'; 
        }
       
    }
}
