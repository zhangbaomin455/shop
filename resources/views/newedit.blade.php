<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{url('updatedd'.$data[0]->news_id)}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
    <input type="hidden" id="news_id" name="news_id" value="{{$data[0]->news_id}}">
        <table>
            <tr>
                <td>网站名称<input type="text" name="news_name" id="news_name"  value="{{$data[0]->news_name}}"></td>
            </tr>
            <tr>
                <td>网站网址<input type="text" name="news_web" id="news_web" value="{{$data[0]->news_web}}"></td>
            </tr>
            <tr>
                <td>链接类型
                @if($data[0]->news_web==1)
                    <input type="radio" name="news_logo" value=1 >LOGO链接
                    <input type="radio" name="news_logo" value=2 checked>文字链接
                @else
                    <input type="radio" name="news_logo" value=1 checked>LOGO链接
                    <input type="radio" name="news_logo" value=2 >文字链接
                @endif
                </td>
            </tr>
            <tr>
            <td>图片<img src="http://www.dd.com/{{$data[0]->head}}" alt="图片" width="150px" height="150px" style="float:left"><input type="file" name="edit_head"></td>
            </tr>
            <tr>
                <td>网站联系人:<input type="text" name="user_name"  value="{{$data[0]->user_name}}"></td>
            </tr>
            <tr>
                <td>
                    网络介绍<textarea id="" cols="30" rows="10" name="news_desc">{{$data[0]->news_desc}}</textarea>
                </td>
            </tr>
                <td>
                @if($data[0]->is_show==1)
                    是否显示:<input type="radio" name="is_show" value=1 checked>是
                    <input type="radio" name="is_show" value=2 >否
               @else
                     是否显示:<input type="radio" name="is_show" value=1 >是
                    <input type="radio" name="is_show" value=2 checked>否
               @endif
                
                </td>
            </tr>
            <tr>
            <td><input type="submit" value="修改" id="btn"></td>
            </tr>
        </table>
    </form>
</body>
</html>
<script src="{{url('js/jquery-3.2.1.min.js')}}"></script>
<script>
$(function(){
        var name_flag=false;
        var web_flag=false;
    $('#news_name').blur(function(){
        //验证为空
        var news_name=$('#news_name').val();
        var news_id=$('#news_id').val();
        var _token=$("#_token").val();
        var reg=/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/;
        if(news_name==''){
            $('#news_name').next().remove();
            $('#news_name').after('<b style=color:red>网站名称必填</b>');
            name_flag=false;
        }else if(!reg.test(news_name)){
            $('#news_name').next().remove();
            $('#news_name').after('<b style=color:red>网站名称必须是中文字母数字下划线</b>');
            name_flag=false;
         }else{
                $.post(
                    "{{url('newsdd')}}",
                    {news_id:news_id,news_name:news_name,_token:_token,type:2},
                    function(res){
                        if(res==1){
                            $('#news_name').next().remove();
                            $('#news_name').after('<b style=color:red>网站名称已经存在</b>');
                            name_flag=false;
                        }else{
                            $('#news_name').next().remove();
                            $('#news_name').after('<b style=color:red>ok</b>');
                            name_flag=true;
                    }
                }   
            );
         }
    })
        $('#news_web').blur(function(){
            //验证网站网址为空
            var news_web=$('#news_web').val();
            var reg=/(http|https):\/\/([\w.]+\/?)\S*/;
            $('#news_web').next().remove();
            if(news_web==''){
                $('#news_web').next().remove();
                $('#news_web').after('<b style=color:red>网站网址必填</b>');
                web_flag=false;
            }else if(!reg.test(news_web)){
                $('#news_web').next().remove();
                $('#news_web').after('<b style=color:red>网站网址格式应该以http://开头</b>');
                web_flag=false;
            }else{
                $('#news_web').next().remove();
                $('#news_web').after('<b style=color:red>ok</b>');
                web_flag=true
            }
            
        });
        $('#btn').click(function(){
            $('#news_name').trigger('blur');
            $('#news_web').trigger('blur');
             return name_flag&& web_flag;
      });
})
</script>