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
    <div class="panel-head"><strong class="icon-reorder">作业详情</strong></div>
    <?php
    session_start();
    @$yh = $_SESSION['user_id'];
    $project_num = $_GET['project_num'];
    $_SESSION['project_num'] = $project_num;
    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
    mysqli_query($link,"set names utf8");

    $sql = "select * from project where project_num='$project_num'";
    $result = $link->query($sql);
    $row = $result->fetch_assoc();
    $sql2 = "select score from homework where id=$yh and project_num='$project_num'";
    $result2 = $link->query($sql2);
    $row2 = $result2->fetch_assoc();

    ?>

    <div class="body-content" font size="20">
        <div align="center" class="form-group">
          <div class="label">
            <label>作业项目名称：</label>
          </div>
          <div class="field">
            <?php echo $row['project_name'] ?>
          </div>
        </div>

        <div align="center" class="form-group">
          <div class="label">
            <label>作业项目描述：</label>
          </div>
          <div class="field">
            <?php echo $row['description'] ?>
          </div>
        </div>

        <div align="center" class="form-group">
          <div class="label">
            <label>作业截止时间：</label>
          </div>
          <div class="field">
            <?php echo $row['ddl'] ?>
          </div>
        </div>

        <div align="center" class="form-group">
          <div class="label">
            <label>作业提交格式：</label>
          </div>
          <div class="field">
            <?php echo $row['format'] ?>
          </div>
        </div>

        <div align="center" class="form-group">
          <div class="label">
            <label>作业要求文件：</label>
          </div>
          <a href="download_require.php?project_num=<?php echo $row['project_num']?>"><button class="button_new button_blue">下载</button></a>
        </div>

        <div align="center" class="form-group">
          <div class="label">
            <label>作业答案文件：</label>
          </div>
          <?php
            if ($row['ddl'] >= date("Y-m-d H:i:s", time())) {
            ?>
              <button class="button_new button_red" style="background-color: red;color:white;cursor: not-allowed">DDL之后才能下载</button>

            <?php
            } else {
              ?>
              <a href="download_answer.php?project_num=<?php echo $row['project_num']?>"><button class="button_new button_blue">下载</button></a>
            <?php
              
            }
            ?>
          
        </div>

        <div align="center" class="form-group">
          <div class="label">
            <label>作业评分：</label>
          </div>
          <?php
            if ($result2) {
            ?>
          <div class="field">
            <?php echo $row2['score'] ?>
          </div>
          <?php
            } else {
              ?>
              <div class="field">
            <?php echo '暂无评分' ?>
            </div>
            <?php
            }
            ?>
        </div>


      <form method="post" align="center" class="form-x" action="upload.php" enctype="multipart/form-data">
        
          <div class="label"><label for="file">作业提交：</label>
          </div>
          <?php
            if ($row['ddl'] <= date("Y-m-d H:i:s", time())) {
            ?>
              <button class="button_new button_red" style="background-color: red;color:white;cursor: not-allowed">已截止</button>

            <?php
            } else {
              ?>
              <input type="file" name="file" id="file">
          <button name="submit" class="button bg-main icon-check-square-o" type="submit">提交</button>
            <?php
            }
            ?>
          
          


      </form>

      


    </div>
  </div>

</body>

</html>
