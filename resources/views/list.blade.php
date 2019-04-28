<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{url('/css/page.css')}}">
    <link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
</head>
<body>

<form action="{{url('list')}}">
  <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
    <input type="text" name="news_name" value="{{$news_name}}">
    <input type="text" name="news_web" value="{{$news_web}}">
<input type="submit" value="搜索">
  </form>
    <table border=1>
        <tr>
            <td>id</td>
            <td>网站名称</td>
            <td>网站网址</td>
            <td>图片LOGO</td>
            <td>链接类型</td>
            <td>网站联系人</td>
            <td>网络介绍</td>
            <td>是否显示</td>
            <td>操作</td>
        </tr>
          @foreach($data as $k=>$v)
        <tr news_id={{$v->news_id}}>
            <td>{{$v->news_id}}</td>
            <td>{{$v->news_name}}</td>
            <td>{{$v->news_web}}</td>
            <td> <img src="http://www.dd.com/{{$v->head}}" alt="图片" width="150px" height="150px" style="float:left"></td>
            <td>
                @if($v->news_logo==1)
                    LOGO链接
                @else
                    文字链接
                @endif
            </td>
            <td>{{$v->user_name}}</td>
            <td>{{$v->news_desc}}</td>
            <td>
            @if($v->is_show==1)
                    是
                @else
                    否
                @endif
            </td>
            <td>
            <input type="hidden" name="news_id" value="{{$v->news_id}}" id="news_id">
            <a href="javascript:;" id="dels">删除</a>
            <a href="{{url('newedit')}}/{{$v->news_id}}">修改</a>
            </td>
        </tr>
        @endforeach
    </table>
    ​{{$data->appends(['news_name'=>$news_name],['news_web'=>$news_web])->render()}}​
</body>
</html>
<script src="{{url('js/jquery-3.2.1.min.js')}}"></script>
<script src="{{url('layui/layui.js')}}"></script>
<script>
$(function(){
    $(document).on('click','#dels',function () {
       
        var news_id=$('#news_id').val();
        console.log(news_id);
        var _token=$("#_token").val();
            $.ajax({
                type:"post",
                url:"{{url('newdel')}}",
                data:{news_id:news_id,_token:_token},
                dataType: 'json'
            }).done(function(res){
                if(res==1){
                    alert('删除成功');
                 history.go()
                }else{
                   alert("删除失败");
            }
        })
    }) 
})
</script>
 