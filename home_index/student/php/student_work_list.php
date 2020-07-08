<!DOCTYPE html>
<html lang="zh-cn">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="renderer" content="webkit">
  <title></title>
  <link rel="stylesheet" type="text/css" href="../css/pintuer.css">
  <link rel="stylesheet" type="text/css" href="../css/admin.css">
  <script src="../js/jquery.js"></script>
  <script src="../js/pintuer.js"></script>
</head>

<body style="background:url(../images/login_bg.jpg); background-repeat:no-repeat; text-align:center; background-size: 100%;">

  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder">作业项目列表</strong></div>
    <?php
    session_start();
    @$yh = $_SESSION['user_id'];

    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
    mysqli_query($link,"set names utf8");
    $sql = "select distinct d.*
    from student a,elective b,course c,project d
    where a.id=b.student_id and b.course_id=c.id and c.id=d.course_num and a.id=$yh";

    $result = $link->query($sql);


    ?>
    <table class="table table-hover text-center">
      <tr>
        <td width="100">
          <div align="center">ID</div>
        </td>
        <td width="100">
          <div align="center">作业名</div>
        </td>
        <td width="100">
          <div align="center">课程号</div>
        </td>
        <td width="100">
          <div align="center">发布时间</div>
        </td>
        <td width="100">
          <div align="center">截止日期</div>
        </td>
        <td width="100">
          <div align="center">操作</div>
        </td>
      </tr>

      <?php

      while ($row = $result->fetch_assoc()) {
      ?>

        <tr>
          <td align="center"><?php echo $row['project_num'] ?></td>
          <td align="center"><?php echo $row['project_name'] ?></td>
          <td align="center"><?php echo $row['course_num'] ?></td>
          <td align="center"><?php echo $row['upload_time'] ?></td>
          <td align="center"><?php echo $row['ddl'] ?></td>
          <td align="center">
              <a href="download_require.php?project_num=<?php echo $row['project_num']?>"><button class="button_new button_blue">下载</button></a>
              <a href="student_work_detail.php?project_num=<?php echo $row['project_num']?>"><button class="button_new button_green">作业详情></button></a>
          </td>
        </tr>
      <?php
      }

      ?>
    </table>
  </div>
  <!-- </form> -->
</body>

</html>