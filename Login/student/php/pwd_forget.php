<?php
    header('content-type:text/html;charset="utf-8"');
    require_once("/var/www/html/Login/mail/mail.php");
  
    //取出传的数据
    $email = $_POST['email'];
    $currTime = time();

    //用户激活识别码
    $token = md5($email.$currTime);

    //过期时间为60分钟后
    $token_exptime = $currTime + 60*60;

     //1.链接数据库
    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1");

    //2.判断是否连接成功
    if(!$link){
        echo '<html><head><Script Language="JavaScript">alert("数据库链接失败");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/pwd_forget.html\">";
        exit;
    }

    mysqli_set_charset("utf8");

    //5.准备sql语句，验证是否存在该注册邮箱
    $sql1 = "select * from student where email='{$email}'";
    
    //6.发送sql语句
    $res = mysqli_query($link,$sql1);
    $row = mysqli_fetch_assoc($res);
    if(!$row){
        echo '<html><head><Script Language="JavaScript">alert("该邮箱尚未注册或者邮箱名错误");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/pwd_forget.html\">";
        exit;
    }else{
        $sql2 = "UPDATE student SET val_code='{$token}',code_date= $token_exptime WHERE email='{$email}'";
	    mysqli_query($link,$sql2);

        $emailbody = "亲爱的" . $email ."用户" . "：<br/>请点击下面的链接重置密码<br/><br/><a href='http://106.55.171.93/Login/student/php/reset.php?verify=" . $token . "' target='_blank'>http://106.55.171.93/Login/student/php/reset.php?verify=" . $token . "</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接十分钟内有效。<br/>如果此次修改密码请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>--------</p>";
	$res2 = sendMail($email,'修改密码',$emailbody);
        if($res2){
            echo '<html><head><Script Language="JavaScript">alert("已发送邮件，请登录邮箱进行密码修改");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/log-in.html\">";
        }else{
            echo '<html><head><Script Language="JavaScript">alert("邮件发送失败，请再次尝试");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/pwd_forget.html\">";
        }

    }
    
    //8.关闭数据库
    mysqli_close($link);


?>