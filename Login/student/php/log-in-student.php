<?php ob_start (); ?>
<?php
header("Content-type:text/html;charset=UTF-8");

session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$autologin = isset($_POST['autologin']) ? 1 : 0;   //获取是否选择了自动登录
$is_first = 0;//0表示第一次登录，1表示不是第一次登录
$_SESSION['user_id']=$username;

/*
 * 首先进行判空操作，通过后再进行数据库验证。
 * */
if (checkEmpty($username, $password)) {
    if (checkUser($username, $password)) {
        $_SESSION['username'] = $username; //保存此时登录成功的用户名
        if ($autologin == 1) {        //如果用户勾选了自动登录就把用户名和加了密的密码放到cookie里面
            setcookie("username", $username, time() + 3600 * 24 * 3);  //有效期设置为3天
            setcookie("password", md5($password), time() + 3600 * 24 * 3);
        } else {
            setcookie("username", "", time() - 1);  //如果没有选择自动登录就清空cookie
            setcookie("password", "", time() - 1);
        }
        setcookie('username',$username,time()+3600,'/');
        if($is_first == 0){
            header("location:../html/first_login.html");      //全部验证都通过之后跳转到首页
        }else{
            header("location:../../../home_index/student/php/student_index.php"); 
        }

    }
}
//方法：判断是否为空
function checkEmpty($username, $password)
{
    if ($username == null || $password == null) {
        echo '<html><head><Script Language="JavaScript">alert("用户名或密码为空");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/log-in.html\">";
    } else {
        return true;
    }
}

//方法：查询用户是否在数据库中
function checkUser($username, $password)
{
    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1");
    if(!$link){
        echo '<html><head><Script Language="JavaScript">alert("数据库链接失败");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/log-in.html\">";
        exit;
    }
    mysqli_set_charset("utf8");

    $str = md5($password);
    $sql = "select * from student where id='{$username}' and password='{$str}';";
    $res = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        global $is_first;
        $is_first = $row['isfirst'];
        return true;
    } else {
        echo '<html><head><Script Language="JavaScript">alert("用户名或者密码错误");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html/log-in.html\">";
    }
    mysqli_close($link);
}
