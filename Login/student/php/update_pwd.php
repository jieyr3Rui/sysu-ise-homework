<?php 
    header('content-type:text/html;charset="utf-8"');


    $password = $_POST['password1'];
    $repassword = $_POST['password2'];

    //1.链接数据库
    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1");

    //2.判断是否连接成功
    if(!$link){
        echo '<html><head><Script Language="JavaScript">alert("数据库链接失败");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/reset_pwd.html\">";
        exit;
    }
    
    mysqli_set_charset("utf8");

    if($password == $repassword){

            $pwd = md5($password);
	    
            $email = $_COOKIE['email'];

            $sql = "update student set password='$pwd' where email='$email'";

            //6.发送sql语句
            $res = mysqli_query($link,$sql);

            if($res){
                echo "<script>confirm('修改密码成功，即将跳转至登录页面！');location='../html/log-in.html'</script>";
                setcookie('email','',time()-1,'/');
            }else{
                echo "<script>alert('修改密码失败！');location='../html/reset_pwd.html'</script>";
            }
    }else{
        echo "<script>location='../html/reset_pwd.html';alert('两次输入密码不一致！');</script>";
    }
	
    //8.关闭数据库
    mysqli_close($link);
	

?>
