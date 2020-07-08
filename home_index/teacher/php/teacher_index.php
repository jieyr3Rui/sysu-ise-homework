<!DOCTYPE html>
<html lang="zh-cn">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="renderer" content="webkit">
  <title>教师首页</title>
  <link rel="icon" href="../images/student.jpg" type="image/x-icon" />
  <link rel="stylesheet" href="../css/pintuer.css">
  <link rel="stylesheet" href="../css/admin.css">
  <script src="../js/jquery.js"></script>
</head>

<body style="background:url(../images/login_bg.jpg); background-repeat:no-repeat; text-align:center; background-size: 100%;">

  <?php
  session_start();
  ?>
  <div class="header bg-main">
    <div style="float:left" class="logo margin-big-left fadein-top">
      <h1><img src="../images/teacher.png" class="radius-circle rotate-hover" height="50" alt="" />教师端</h1>
    </div>
    <div style="float:right; margin-right:5%" class="head-l">
      <!--<a  class="button button-little bg-blue" href="" target="_blank"><span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp;
      <a href="##" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp;-->
      <a class="button button-little bg-red" href="../../../Login/teacher/html/log-in-teacher.html"><span class="icon-power-off"></span> 退出登录</a> </div>
  </div>
  <div class="leftnav">
    <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
    <h2 style="background:#3CF"><a href="teacher_work_list.php" target="right">作业项目</a></h2>
    <h2 style="background:#3CF"><a href="teacher_student_alllist.php" target="right">学生作业</a></h2>
    <h2 style="background:#3CF">我的消息</h2>
    <h2 style="background:#3CF"><a href="teacher_pw_update.html" target="right">个人中心</h2>

  </div>

  
  <?php
  $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
  mysqli_query($link,"set names utf8");
  $sql = "select * from teacher where id = {$_SESSION['user_id']}";
  $result = $link->query($sql);
  $row = $result->fetch_assoc();
  $sql2 = "select * from teach_list where teacher_id = {$_SESSION['user_id']}";
  $result2 = $link->query($sql2);
  $row2 = $result2->fetch_assoc();
  $_SESSION['course_id'] = $row2['course_id'];

  ?>
  <ul class="bread">
    <li style="color:#F00; font-size:20px; font-weight:bold"><?php echo @$row['name'] ?></span>老师&nbsp;&nbsp;<span style="color:#000000">欢迎您!!!</span></li>
  </ul>
  <div class="admin">
    <iframe scrolling="auto" rameborder="0" src="teacher_work_list.php" name="right" width="100%" height="100%"></iframe>
  </div>
</body>

</html>