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

<body style="background:url(../images/login_bg.jpg); background-repeat:no-repeat; text-align:center; background-size: 100%;">

  
    <div class="panel admin-panel">
      <div class="panel-head"><strong class="icon-reorder">课程列表</strong></div>
      <?php
      session_start();
      @$yh = $_SESSION['user_id'];
      $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
      mysqli_query($link,"set names utf8");

      
      // $r=$row['select_course'];
      $sql = "select distinct c.* 
    from student a,elective b,course c
    where a.id=b.student_id and b.course_id=c.id and a.id=$yh";

      $rs = $link->query($sql);
      ?>
      <table class="table table-hover text-center">
        <tr>
          <td width="300">
            <div align="center">课程号</div>
          </td>
          <td width="300">
            <div align="center">课程名称</div>
          </td>
          <td width="300">
            <div align="center">开课时间</div>
          </td>
          <td width="300">
            <div align="center">课程学期</div>
          </td>
          <td width="300">
            <div align="center">选课人数</div>
          </td>
          <td width="300">
            <div align="center">课程作业</div>
          </td>
        </tr>
        <!--<tr>-->
        <!--<td>-->
        <?php
        while ($row = $rs->fetch_assoc()) {
        ?>

          <tr>
            <td align="center"><?php echo $row['id'] ?></td>
            <td align="center"><?php echo $row['name'] ?></td>
            <td align="center"><?php echo $row['time'] ?></td>
            <td align="center"><?php echo $row['term'] ?></td>
            <td align="center"><?php echo $row['number'] ?></td>
            <td align="center"><a href="student_course_detail.php?course_id=<?php echo $row['id']?>"><button class="button_new button_green">详情></button></a>
            </td>
            <?php   
            }
            ?>
    
      </table>
      
    </div>
</body>

</html>