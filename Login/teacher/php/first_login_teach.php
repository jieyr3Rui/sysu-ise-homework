<?php 
    header('content-type:text/html;charset="utf-8"');


    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $email = $_POST['email'];

    //1.链接数据库
    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1");

    //2.判断是否连接成功
    if(!$link){
        echo '<html><head><Script Language="JavaScript">alert("数据库链接失败");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/first_login_teach.html\">";
        exit;
    }
    
    mysqli_set_charset("utf8");

    if($password == $repassword){

            $pwd = md5($password);
            $temp = 1;
	    
            $username = $_COOKIE['username'];
    

            $sql = "update teacher set password='$pwd',email = '$email',isfirst = '$temp' where id ='$username'";

            //6.发送sql语句
            $res = mysqli_query($link,$sql);

            if($res){
                echo "<script>confirm('修改密码成功，即将跳转至登录页面！');location='../html/log-in-teacher.html'</script>";
                setcookie('username','',time()-1,'/');
            }else{
                echo "<script>alert('修改密码失败！');location='../html/first_login_teach.html'</script>";
            }
    }else{
        echo "<script>location='../html/first_login_teach.html';alert('两次输入密码不一致！');</script>";
    }
	
    //8.关闭数据库
    mysqli_close($link);
	

?>
