<?php 
    header('content-type:text/html;charset="utf-8"');

    $verify = $_GET['verify'];
    $nowtime = time();

    //1.链接数据库
    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1");

    //2.判断是否连接成功
    if(!$link){
        $msg = "数据库连接失败！";
        exit;
    }

    mysqli_set_charset("utf8");


    $sql1 = "select code_date,email from student where val_code='$verify'";
    

    //6.发送sql语句
    $res = mysqli_query($link,$sql1);

    //7.取出一行数据
    $row = mysqli_fetch_assoc($res);

    $email = $row['email'];


    if($row){
        if($nowtime>$row['code_date']){

            $msg = "该链接已过期！";

        }else{

            $msg = 1;

            setcookie('email',$email,time()+3600,'/');

        }

    }else{
        $msg = "无效的链接！";
    }

echo "<script>
        if($msg==1){
            alert('请重新设置密码！');location='../html/reset_pwd.html';
        }else{
            alert($msg);}
    </script>";

    mysqli_close($link);
 

?>
