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
      <div class="panel-head"><strong class="icon-reorder">学生作业列表</strong></div>
      <?php
      session_start();
      @$tno = $_SESSION['user_id'];
      $project_num =  $_GET['project_num'];

      $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
      mysqli_query($link,"set names utf8");
      //$sql="select * from student ";
      $sql = "select a.*,h.*
    	from student a,homework h
    	where a.id=h.id  and h.project_num='$project_num' ";
      $result = $link->query($sql);

      ?>
      <td align="center">
      <a href="download-all.php?project_num=<?php echo $project_num ?>"><button class="button_new button_red">下载全部</button></a>
      <a href="download-rest.php?project_num=<?php echo $project_num?>"><button class="button_new button_red">下载未下载的全部</button></a>
    </td>
      
      <table class="table table-hover text-center">
        <tr>
          <td width="100">
            <div align="center">ID</div>
          </td>
          <td width="100">
            <div align="center">学号</div>
          </td>
          <td width="100">
            <div align="center">姓名</div>
          </td>

          <td width="100">
            <div align="center">分数</div>
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
            <td align="center"><?php echo $row['id'] ?></td>
            <td align="center"><?php echo $row['name'] ?></td>
            <!-- 分数外观显示判断 -->
            <?php if ($row['score'] == NULL) { ?>
              <td align="center" style="color:yellowgreen;font-weight:bolder">
                待评分
              </td>
            <?php } elseif ($row['score'] >= 60) { ?>
              <td align="center" style="color: green;font-weight:bolder">
                <?php echo $row['score'] ?>
              </td>
            <?php } else { ?>
              <td align="center" style="color: red;font-weight:bolder">
                <?php echo $row['score'] ?>
              </td>
            <?php  } ?>
            
            <td align="center">
              <a href="teacher_student_mark.php?sno=<?php echo $row['id'] ?>&project_num=<?php echo $row['project_num']?>"><button class="button_new button_green">评分</button></a>
              <a href="download.php?id=<?php echo $row['id'] ?>&project_num=<?php echo $row['project_num']?>"><button class="button_new button_blue">下载</button></a>
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