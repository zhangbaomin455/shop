<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{url('/css/page.css')}}">
</head>
<body>
@if (session('msg'))  
   <div class="alert alert-success">   
         {{ session('msg') }}   
  </div> 
  @endif
  <form action="{{url('show')}}">
  <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
    <input type="text" name="user_name" value="{{$user_name}}">
    <select name="user_age" id="">
    <option value="">请选择</option>
        @for($i=5;$i<=23;$i++)
          
            <option value="{{$i}}" @if('{{$user_age}}'==$i) selected @endif>{{$i}}</option>
           
        @endfor
</select>
<input type="submit" value="搜索">
  </form>
    <table border=1>
        <tr>
            <td>id</td>
            <td>姓名</td>
            <td>年龄</td>
            <td>头像</td>
            <td>操作</td>

        </tr>
          @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->user_id}}</td>
            <td>{{$v->user_name}}</td>
            <td>{{$v->user_age}}</td>
            <td> <img src="http://www.dd.com/{{$v->head}}" alt="图片" width="150px" height="150px" style="float:left"></td>
            <td><a href="{{url('create')}}/{{$v->user_id}}">删除</a><a href="{{url('edit')}}/{{$v->user_id}}">修改</a></td>
        </tr>
        @endforeach
    </table>
    ​{{$data->appends(['user_name'=>$user_name],['user_age'=>$user_age])->render()}}​
    
    
    
    
</body>
</html>