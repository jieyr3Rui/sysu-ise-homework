<!DOCTYPE html>
<html lang="zh-cn">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="renderer" content="webkit">
  <title></title>
  <link rel="stylesheet" href="../css/pintuer.css">
  <link rel="stylesheet" href="../css/admin.css">
  <script src="../js/jquery.js"></script>
  <script src="../js/pintuer.js"></script>
</head>

<body style="background:url(images/login_bg.jpg); background-repeat:no-repeat; text-align:center; background-size: 100%;">

  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder">已发布作业列表</strong></div>
    <div align="center"><a href="teacher_work_upload.php"><button class="button_new button_blue">新建作业项目+</button></a>
    </div>
    <?php
    session_start();
    @$yh = $_SESSION['user_id'];
    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
    mysqli_query($link,"set names utf8");

    $sql = "select p.* 
			from teacher a , teach_list t , project p
			where a.id = t.teacher_id and t.course_id = p.course_num and a.id=$yh";
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
          <div align="center">截止时间</div>
        </td>
        <td width="100">
          <div align="center">上传时间</div>
        </td>
        <td width="100">
          <div align="center">学生作业</div>
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
          <?php
          if ($row['ddl'] <= date("Y-m-d H:i:s", time())) {
          ?>
            <td style="color: red;text-align:center;"><?php echo $row['ddl'] ?></td>
          <?php } else { ?>
            <td style="color:green;text-align:center;"><?php echo $row['ddl'] ?></td>
          <?php } ?>
          
            <td align="center"><?php echo $row['upload_time'] ?></td>
            <td align="center"><a href="teacher_student_list.php?project_num=<?php echo $row['project_num']?>"><button class="button_new button_green">详情></button></a>
            </td>
	    <td align="center"><a href="delete.php?project_num=<?php echo $row['project_num']?>"><button class="button_new button_red">删除</button></a>
            </td>
        </tr>
      <?php
      }

      ?>
    </table>
  </div>

</body>

</html>