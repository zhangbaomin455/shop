<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('logindo')}}" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="_token">
        <table> 
            <tr>
                <td>账号<input type="text" name="user_name"></td>
            </tr>
            <tr>
                <td>密码<input type="password" name="user_pwd"></td>
            </tr>
            <tr>
            <td><input type="submit" value="登录"></td>
            </tr>
        </table>
    </form>
</body>
</html>