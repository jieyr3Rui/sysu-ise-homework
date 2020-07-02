<?php
$servername = "106.55.171.93";
$username = 'root';
$password = 'qwer1234,.';
$dbname = 'db1';
$port = "3306";

$upload_time = date("Y-m-d H:i:s");
$answer_time = date("Y-m-d H:i:s");
$project_num = $_POST['project_num'];
$course_num = $_POST['course_num'];
$project_name = $_POST['project_name'];
$description = $_POST['description'];
$ddl = $_POST['ddl'];
$format = $_POST['format'];
$answer_remark = $_POST['answer_remark'];

$ans_extension = end(explode(".", $_FILES["ans_file"]["name"]));// 获取文件后缀名
$req_extension = end(explode(".", $_FILES["req_file"]["name"]));    

$allowedExts = array("jpeg", "jpg", "png", "pdf", "doc", "docx", "zip", "rar");  //允许上传的文件格式

$conn = mysqli_connect($servename,$username,$password,$dbname,$port);
if(!$conn)
{
	die("Error: ". mysqli_connect_error());
}
// 查询project表中是否已有答案记录
$sql1 = "SELECT answer_file FROM project WHERE project_num='{$project_num}';";
$result1 = $conn->query($sql1);
$sql2 = "SELECT file FROM project WHERE project_num='{$project_num}';";
$result2 = $conn->query($sql2);

if(empty($_FILES["ans_file"]["tmp_name"]) && empty($_FILES["req_file"]["tmp_name"])) //两个文件都没有上传
{
	if ($result1->num_rows > 0)
	{
		$sql3 = "UPDATE project SET project_name = '{$project_name}', ddl = '{$ddl}', format = '{$format}',  
		description = '{$description}',  answer_remark = '{$answer_remark}',  answer_time = '{$answer_time}'  WHERE project_num ='{$project_num}';";
		if(!mysqli_query($conn,$sql3)) 
			echo "mysql error" .mysqli_error($conn);
		echo "success1";
	}
	else
	{
		$sql4 = "INSERT INTO project (project_num, course_num, project_name, description, file, ddl, format, upload_time, answer_file, answer_remark, answer_time) 
			VALUES ('{$project_num}', '{$course_num}', '{$project_name}', '{$description}', NULL, '{$ddl}', '{$format}', '{$upload_time}', 
			NULL, '{$answer_remark}', '{$answer_time}');";
		if(!mysqli_query($conn,$sql4))
			echo "mysql error" .mysqli_error($conn);
		echo "success2";
	}
}
elseif(empty($_FILES["ans_file"]["tmp_name"]) && (!empty($_FILES["req_file"]["tmp_name"]))) //只上传了作业要求
{
	$req_path = "/web-file/project/{$project_num}/requirement/"; //规定的文件路径
	$req_name = $req_path . $project_num . 'requirement' . '.' . $req_extension;
	mkdirs($req_path, $mode = 0777);
	if ($result2->num_rows > 0)
	{
		while($r = $result2->fetch_assoc())   //删除原文件
		{
			$row_del = unlink($r['file']);
		}
		move_uploaded_file($_FILES["req_file"]["tmp_name"], $req_path . $_FILES['req_file']['name']);       
		rename($req_path . $_FILES['req_file']['name'], $req_name);
		$sql5 = "UPDATE project SET project_name = '{$project_name}', ddl = '{$ddl}', format = '{$format}', file = '{$req_name}', 
			description = '{$description}',  answer_remark = '{$answer_remark}',  answer_time = '{$answer_time}'  WHERE project_num ='{$project_num}';";
		if(!mysqli_query($conn,$sql5)) 
			echo "mysql error" .mysqli_error($conn);
		echo "success3";
	}
	else
	{
		move_uploaded_file($_FILES["req_file"]["tmp_name"], $req_path . $_FILES['req_file']['name']);       
		rename($req_path . $_FILES['req_file']['name'], $req_name);
		$sql6 = "INSERT INTO project (project_num, course_num, project_name, description, file, ddl, format, upload_time, answer_file, answer_remark, answer_time) 
			VALUES ('{$project_num}', '{$course_num}', '{$project_name}', '{$description}', '{$req_name}', '{$ddl}', '{$format}', '{$upload_time}', NULL, '{$answer_remark}', '{$answer_time}');";
		if(!mysqli_query($conn,$sql6))
			echo "mysql error" .mysqli_error($conn);
		echo "success4";
	}
}
elseif((!empty($_FILES["ans_file"]["tmp_name"])) && empty($_FILES["req_file"]["tmp_name"])) //只上传了作业答案
{
	$ans_path = "/web-file/project/{$project_num}/answer/"; //规定的文件路径
	$ans_name = $ans_path . $project_num . 'answer' . '.' . $ans_extension;
	mkdirs($ans_path, $mode = 0777);
	if ($result1->num_rows > 0) //如有记录，先删除原文件
	{ 	
		while($row = $result1->fetch_assoc()) 
		{
			$row_del = unlink($row['file']);
		}
		move_uploaded_file($_FILES["ans_file"]["tmp_name"], $ans_path . $_FILES['ans_file']['name']);       
		rename($ans_path . $_FILES['ans_file']['name'], $ans_name);
		$sql7 = "UPDATE project SET project_name = '{$project_name}', ddl = '{$ddl}', format = '{$format}', 
			description = '{$description}', answer_file ='{$ans_name}', answer_remark = '{$answer_remark}',  
			answer_time = '{$answer_time}'  WHERE project_num ='{$project_num}';";
		if(!mysqli_query($conn,$sql7)) 
			echo "mysql error" .mysqli_error($conn);
		echo "success5";
	}
	else
	{
		move_uploaded_file($_FILES["ans_file"]["tmp_name"], $ans_path . $_FILES['ans_file']['name']);       
		rename($ans_path . $_FILES['ans_file']['name'], $ans_name);
		$sql8 = "INSERT INTO project (project_num, course_num, project_name, description, file, ddl, format, upload_time, answer_file, answer_remark, answer_time) 
		VALUES ('{$project_num}', '{$course_num}', '{$project_name}', '{$description}', NULL, '{$ddl}', '{$format}', '{$upload_time}', '{$ans_name}', '{$answer_remark}', '{$answer_time}');";
		if(!mysqli_query($conn,$sql8))
			echo "mysql error" .mysqli_error($conn);
		echo "success6";
	}
}
elseif(($_FILES["ans_file"]["size"] < 2147483648) && in_array($ans_extension, $allowedExts) //两个文件都有上传
	&&($_FILES["req_file"]["size"] < 2147483648) && in_array($req_extension, $allowedExts))
	if ($_FILES["ans_file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["ans_file"]["error"] . "<br>";
	}
	elseif ($_FILES["req_file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["req_file"]["error"] . "<br>";
	}
	else
	{	
		$ans_path = "/web-file/project/{$project_num}/answer/"; //规定的文件路径
		$ans_name = $ans_path . $project_num . 'answer' . '.' . $ans_extension;
		mkdirs($ans_path, $mode = 0777);

		$req_path = "/web-file/project/{$project_num}/requirement/"; //规定的文件路径
		$req_name = $req_path . $project_num . 'requirement' . '.' . $req_extension;
		mkdirs($req_path, $mode = 0777);

		if ($result1->num_rows > 0) //如有记录，先删除原文件
		{ 	
			//修改作业答案文件
			while($row = $result1->fetch_assoc()) 
			{
				$row_del = unlink($row['file']);
			}
			move_uploaded_file($_FILES["ans_file"]["tmp_name"], $ans_path . $_FILES['ans_file']['name']);       
			rename($ans_path . $_FILES['ans_file']['name'], $ans_name);

			//修改作业要求文件
			while($r = $result2->fetch_assoc()) 
			{
				$r_del = unlink($r['file']);
			}
			move_uploaded_file($_FILES["req_file"]["tmp_name"], $req_path . $_FILES['req_file']['name']);       
			rename($req_path . $_FILES['req_file']['name'], $req_name);
			$sql9 = "UPDATE project SET project_name = '{$project_name}', ddl = '{$ddl}', format = '{$format}', file = '{$req_name}', 
				description = '{$description}', answer_file ='{$ans_name}', answer_remark = '{$answer_remark}',  
				answer_time = '{$answer_time}'  WHERE project_num ='{$project_num}';";
			if(!mysqli_query($conn,$sql9)) 
				echo "mysql error" .mysqli_error($conn);
			echo "success7";
		}
		else
		{
			move_uploaded_file($_FILES["ans_file"]["tmp_name"], $ans_path . $_FILES['ans_file']['name']);       
			rename($ans_path . $_FILES['ans_file']['name'], $ans_name);

			move_uploaded_file($_FILES["req_file"]["tmp_name"], $req_path . $_FILES['req_file']['name']);       
			rename($req_path . $_FILES['req_file']['name'], $req_name);

			$sql10 = "INSERT INTO project (project_num, course_num, project_name, description, file, ddl, format, upload_time, answer_file, answer_remark, answer_time) 
				VALUES ('{$project_num}', '{$course_num}', '{$project_name}', '{$description}', '{$req_name}', '{$ddl}', '{$format}', '{$upload_time}', '{$ans_name}', '{$answer_remark}', '{$answer_time}');";
			if(!mysqli_query($conn,$sql10))
				echo "mysql error" .mysqli_error($conn);
			echo "success8";
		}
	}
else
{
	echo "请检查文件大小是否小于2GB,且格式为jpeg, jpg, png, pdf, doc, docx, zip, rar";
}


function mkdirs($dir, $mode = 0777)

{

if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;

if (!mkdirs(dirname($dir), $mode)) return FALSE;

return @mkdir($dir, $mode);

}
?>