<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!-- @if ($errors->any())     
<div class="alert alert-danger">         
<ul>           
  @foreach ($errors->all() as $error)               
  <li>{{ $error }}</li>           
    @endforeach      
     </ul>  
</div> @endif  -->
 
    <form action="{{url('store')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
        <table>
            <tr>
                <td>姓名<input type="text" name="user_name"></td>
            </tr>
            <tr>
                <td>年龄<input type="text" name="user_age" ></td>
            </tr>
            <tr>
                <td>头像<input type="file" name="head"></td>
            </tr>
            
            <tr>
                <td><input type="submit" value="提交" id="btn"></td>
            </tr>
        </table>
    </form>
</body>
</html>
<script src="{{url('js/jquery-3.2.1.min.js')}}"></script>
<script>
$(function(){
        var name_flag=false;
        var age_flag=false;
    $('input[name=user_name]').blur(function(){
        //验证为空
        var user_name=$('input[name=user_name]').val();
        var _token=$("#_token").val();
        var reg=/^[\u4e00-\u9fa5]+$/;
        if(user_name==''){
            $('input[name=user_name]').next().remove();
            $('input[name=user_name]').after('<b style=color:red>姓名必填</b>');
            name_flag=false;
        }else if(!reg.test(user_name)){
            $('input[name=user_name]').next().remove();
            $('input[name=user_name]').after('<b style=color:red>姓名必须是中文</b>');
            name_flag=false;
         }else{
                $.post(
                    "{{url('indexdd')}}",
                    {user_name:user_name,_token:_token},
                    function(res){
                        if(res==1){
                            $('input[name=user_name]').next().remove();
                            $('input[name=user_name]').after('<b style=color:red>姓名已经存在</b>');
                            name_flag=false;
                        }else{
                            $('input[name=user_name]').next().remove();
                            $('input[name=user_name]').after('<b style=color:red>ok</b>');
                            name_flag=true;
                        }
                }   
            );
         }
    })
    $('input[name=user_age]').blur(function(){
        //验证为空
        var user_age=$('input[name=user_age]').val();
        var reg=/^[1-9]{1,3}$/;
        $('input[name=user_age]').next().remove();
        if(user_age==''){
            $('input[name=user_age]').next().remove();
            $('input[name=user_age]').after('<b style=color:red>年龄必填</b>');
            age_flag=false;
        }else if(!reg.test(user_age)){
            $('input[name=user_age]').next().remove();
            $('input[name=user_age]').after('<b style=color:red>年龄必须满足正则</b>');
            age_flag=false;
        }else{
            $('input[name=user_age]').next().remove();
            $('input[name=user_age]').after('<b style=color:red>ok</b>');
            age_flag=true
        }
    });
    $('#btn').click(function(){
        $('input[name=user_name]').trigger('blur');
        $('input[name=user_age]').trigger('blur');
      
        return name_flag&&age_flag;
      });
})




</script>