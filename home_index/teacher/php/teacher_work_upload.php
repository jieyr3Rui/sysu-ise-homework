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
    <div class="panel-head"><strong class="icon-reorder">作业发布</strong></div>


    <div class="body-content">
      <form method="post" class="form-x" action="" enctype="multipart/form-data">
		  
        <div class="form-group">
          <div class="label">
            <label>作业名：</label>
          </div>
          <div class="field">
            <input type="text" class="input w50" value="" name="project_name" data-validate="required:请输入作业名" />
            <div class="tips"></div>
          </div>
        </div>

		<div class="form-group">
		  <div class="label">
		    <label>作业描述：</label>
		  </div>
		  <div class="field">
		    <input type="text" class="input w50" value="" name="description" data-validate="required:请输入作业描述" />
		    <div class="tips"></div>
		  </div>
		</div>
		
		<div class="form-group">
		  <div class="label">
		    <label>作业提交格式：</label>
		  </div>
		  <div class="field">
		    <input type="text" class="input w50" value="" name="format" data-validate="required:请输入作业提交格式" />
		    <div class="tips"></div>
		  </div>
		</div>
		
        <div class="form-group">
          <div class="label">
            <label>截止时间：</label>
          </div>
          <div class="field">
            <input type="datetime-local" class="input w50" value="" name="ddl" />
            <div class="tips"></div>
          </div>
        </div>
		
        <div class="form-group">
          <div class="label">
            <label>附件及要求：</label>
          </div>
          <div class="field">
            <input type="file" class="input w50" value="" name="req_file" />
            <div class="tips"></div>
          </div>
        </div>
		
		
        <div style="text-align: center" class="field">
          <button name="up" class="button bg-main icon-check-square-o" type="submit"> 上传</button>
        </div>
		<!--答案上传-->
		<div class="form-group">
		  <div class="label">
		    <label>作业答案：</label>
		  </div>
		  <div class="field">
		    <input type="file" class="input w50" value="" name="ans_file" />
		    <div class="tips"></div>
		  </div>
		</div>
		
		
		<!-- <div style="text-align: center" class="field">
		  <button name="up2" class="button bg-main icon-check-square-o" type="submit"> 上传答案</button>
		</div> -->

      </form>
    </div>
  </div>

</body>
</html>


<?php
session_start();
$upload_time = date("Y-m-d H:i:s");
$answer_time = date("Y-m-d H:i:s");
@$course_num = $_SESSION['course_id'];
//echo "<script>alert('$course_num');</script>";
$project_name = $_POST['project_name'];
$description = $_POST['description'];
$ddl = $_POST['ddl'];
$format = $_POST['format'];

$ans_extension = end(explode(".", $_FILES["ans_file"]["name"]));// 获取文件后缀名
$req_extension = end(explode(".", $_FILES["req_file"]["name"]));    

$allowedExts = array("jpeg", "jpg", "png", "pdf", "doc", "docx", "zip", "rar");  //允许上传的文件格式

$conn = mysqli_connect("106.55.171.93","root","qwer1234,.","db1","3306");
if(!$conn)
{
	die("Error: ". mysqli_connect_error());
}

//自动生成作业项目号
$sql1 = "SELECT MAX(project_num) FROM project WHERE course_num='{$course_num}';";
$result1 = $conn->query($sql1);
$arr = $result1->fetch_row();
$last_project_num = $arr[0];
if(empty($last_project_num))
	$project_num = implode(array("$course_num","0001"));
else
{
	$tmp1 = substr($last_project_num,0,6);//截取课程号前六位
	$tmp2 = substr($last_project_num,-2);//截取课程号后两位
	$new_num = (int)$tmp2 + 1;
	if($new_num < 10)
		$project_num = implode(array("$tmp1","000","$new_num"));//000 + 1
	elseif($new_num < 100)
		$project_num = implode(array("$tmp1","00","$new_num"));//00 +12
	elseif($new_num < 1000)
		$project_num = implode(array("$tmp1","0","$new_num"));//0 + 120
	else
		$project_num = implode(array("$tmp1","$new_num"));//1200
}



if (isset($_POST['up'])) //点击上传
{
	if(empty($_FILES["ans_file"]["tmp_name"]) && empty($_FILES["req_file"]["tmp_name"])) //两个文件都没有上传
	{
		$sql2 = "INSERT INTO project (project_num, course_num, project_name, description, file, ddl, format, upload_time, answer_file, answer_remark, answer_time) 
			VALUES ('{$project_num}', '{$course_num}', '{$project_name}', '{$description}', NULL, '{$ddl}', '{$format}', '{$upload_time}', 
			NULL, NULL, '{$answer_time}');";
		if(!mysqli_query($conn,$sql2))
			echo "mysql error" .mysqli_error($conn);
		//echo "success1";
	}
    elseif(empty($_FILES["ans_file"]["tmp_name"]) && (!empty($_FILES["req_file"]["tmp_name"]))
        && ($_FILES["req_file"]["size"] < 2147483648) && in_array($req_extension, $allowedExts)) //只上传了作业要求
	{
		$req_path = "/web-file/project/{$project_num}/requirement/"; //规定的文件路径
		$req_name = $req_path . $project_num . 'requirement' . '.' . $req_extension;
		mkdirs($req_path, $mode = 0777);

		move_uploaded_file($_FILES["req_file"]["tmp_name"], $req_path . $_FILES['req_file']['name']);       
		rename($req_path . $_FILES['req_file']['name'], $req_name);
		$sql3 = "INSERT INTO project (project_num, course_num, project_name, description, file, ddl, format, upload_time, answer_file, answer_remark, answer_time) 
			VALUES ('{$project_num}', '{$course_num}', '{$project_name}', '{$description}', '{$req_name}', '{$ddl}', '{$format}', '{$upload_time}', NULL, NULL, '{$answer_time}');";
		if(!mysqli_query($conn,$sql3))
			echo "mysql error" .mysqli_error($conn);
		//echo "success2";
	}
    elseif((!empty($_FILES["ans_file"]["tmp_name"])) && empty($_FILES["req_file"]["tmp_name"])
        && ($_FILES["ans_file"]["size"] < 2147483648) && in_array($ans_extension, $allowedExts)) //只上传了作业答案
	{

		$ans_path = "/web-file/project/{$project_num}/answer/"; //规定的文件路径
		$ans_name = $ans_path . $project_num . 'answer' . '.' . $ans_extension;
		mkdirs($ans_path, $mode = 0777);

		move_uploaded_file($_FILES["ans_file"]["tmp_name"], $ans_path . $_FILES['ans_file']['name']);       
		rename($ans_path . $_FILES['ans_file']['name'], $ans_name);
		$sql4 = "INSERT INTO project (project_num, course_num, project_name, description, file, ddl, format, upload_time, answer_file, answer_remark, answer_time) 
			VALUES ('{$project_num}', '{$course_num}', '{$project_name}', '{$description}', NULL, '{$ddl}', '{$format}', '{$upload_time}', '{$ans_name}', NULL, '{$answer_time}');";
		if(!mysqli_query($conn,$sql4))
			echo "mysql error" .mysqli_error($conn);
		//echo "success3";
	}
	elseif(($_FILES["ans_file"]["size"] < 2147483648) && in_array($ans_extension, $allowedExts) //两个文件都有上传
		&&($_FILES["req_file"]["size"] < 2147483648) && in_array($req_extension, $allowedExts))
	{
		if ($_FILES["ans_file"]["error"] > 0)
			echo "错误： " . $_FILES["ans_file"]["error"] . "<br>";
		elseif ($_FILES["req_file"]["error"] > 0)
			echo "错误： " . $_FILES["req_file"]["error"] . "<br>";
		else
		{	
			$ans_path = "/web-file/project/{$project_num}/answer/"; //规定的文件路径
			$ans_name = $ans_path . $project_num . 'answer' . '.' . $ans_extension;
			mkdirs($ans_path, $mode = 0777);

			$req_path = "/web-file/project/{$project_num}/requirement/"; //规定的文件路径
			$req_name = $req_path . $project_num . 'requirement' . '.' . $req_extension;
			mkdirs($req_path, $mode = 0777);
	

			move_uploaded_file($_FILES["ans_file"]["tmp_name"], $ans_path . $_FILES['ans_file']['name']);       
			rename($ans_path . $_FILES['ans_file']['name'], $ans_name);
			move_uploaded_file($_FILES["req_file"]["tmp_name"], $req_path . $_FILES['req_file']['name']);       
			rename($req_path . $_FILES['req_file']['name'], $req_name);

			$sql5 = "INSERT INTO project (project_num, course_num, project_name, description, file, ddl, format, upload_time, answer_file, answer_remark, answer_time) 
				VALUES ('{$project_num}', '{$course_num}', '{$project_name}', '{$description}', '{$req_name}', '{$ddl}', '{$format}', '{$upload_time}', '{$ans_name}', NULL, '{$answer_time}');";
			if(!mysqli_query($conn,$sql5))
				echo "mysql error" .mysqli_error($conn);
			//echo "success4";
		}
	}
	else
	{
		echo "请检查文件大小是否小于2GB,且格式为jpeg, jpg, png, pdf, doc, docx, zip, rar";
	}

	if($conn->affected_rows > 0) //跳转页面
		echo "<script>alert('添加成功');window.location='teacher_work_list.php'</script>";
	else 
		echo "<script>alert('添加失败');window.location='teacher_work_list.php'</script>";
}




function mkdirs($dir, $mode = 0777)
{
if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;

if (!mkdirs(dirname($dir), $mode)) return FALSE;

return @mkdir($dir, $mode);
}
?>