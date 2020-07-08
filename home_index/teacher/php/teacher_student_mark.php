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
      <div class="body-content">
        <form name="myForm" onsubmit="return validateForm()" method="post" class="form-x" action="">
          <div class="form-group">            
            <div class="label">
              <label>分数：</label>
            </div>
            <div class="field">
              <input type="text" class="input w50" placeholder="0~100" name="score" />
              <div class="tips"></div>
              <button name="up" class="button bg-main icon-check-square-o" type="submit"> 提交</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <script>
          function validateForm() {
            var x = document.forms["myForm"]["grade"].value;
            if (isNaN(x) || x < 0 || x > 100) {
              alert("分数必须为0~100");
              return false;
            }
          }
        </script>

</body>

</html>

<?php
session_start();
$tno = $_SESSION['user_id'];
$link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
mysqli_query($link,"set names utf8");

if (isset($_POST['up'])) {
  $stu = $_GET['sno'];
  $grade = $_POST['score'];
  $project_num =  $_GET['project_num'];

  $sql = "update homework set score=$grade where id=$stu and project_num='$project_num' ";
  $rs = $link->query($sql);
  if ($rs == true) {
    ?>
    <td align="center"><a href="teacher_student_list.php?project_num=<?php echo $project_num?>"><button class="button bg-main icon-check-square-o">评分成功，返回</button></a>
    <?php
  } else {
    ?>
    <td align="center"><a href="teacher_student_list.php?project_num=<?php echo $project_num?>"><button class="button bg-main icon-check-square-o">评分失败，返回</button></a>
    <?php
  }
}

?>