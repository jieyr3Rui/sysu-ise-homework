<?php

$servername = "106.55.171.93";
$username = 'root';
$password = 'qwer1234,.';
$dbname = 'db1';
$port = "3306";

$time = date("Y-m-d H:i:s");
session_start();
@$id = $_SESSION['user_id'];
@$project_num = $_SESSION['project_num'];
$extension = end(explode(".", $_FILES["file"]["name"]));     // 获取文件后缀名
$file = $path . $id . '.' . $extension;
$allowedExts = array("jpeg", "jpg", "png", "pdf", "doc", "docx", "zip", "rar");  //允许上传的文件格式

if (($_FILES["file"]["size"] < 2147483648) && in_array($extension, $allowedExts)) //小于2GB
	if ($_FILES["file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{	
		$conn = mysqli_connect($servename,$username,$password,$dbname,$port);
		//检查连接是否
		if(!$conn){
			die("Error: ". mysqli_connect_error());
		}
		// 查询homework表中是否已有提交记录
		$sql1 = "SELECT file FROM homework WHERE id='{$id}' AND project_num='{$project_num}';";
		$result1 = $conn->query($sql1);
			if ($result1->num_rows > 0) { // 已有上传记录，则删除原上传记录以及文件
				while($row = $result1->fetch_assoc()) {
			echo "file: " . $row['file']. "<br>";
					$res_del = unlink($row['file']);
				}
			$sql2 = "DELETE FROM homework WHERE id='{$id}' AND project_num='{$project_num}';";
			if(!mysqli_query($conn,$sql2)) 
			echo "mysql error" .mysqli_error($conn);
			} 
			//echo 'submit!' . '<br>';
		$path = "/web-file/project/{$project_num}/homework/"; //规定的文件路径
		mkdirs($path, $mode = 0777);
		//移动文件到目录下并按规则重命名
		$new_name = $path . $id . '.' . $extension;
		move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES['file']['name']);       
		rename($path . $_FILES['file']['name'], $new_name);
		$sql3 = "INSERT INTO homework (project_num, id, file, submit_time, download_flag, score) VALUES 
					('{$project_num}', '{$id}', '{$new_name}', '{$time}',  0, 0);";
		//echo $sql3 . '<br>';
		if(!mysqli_query($conn,$sql3)) 
			echo "mysql error: " .mysqli_error($conn);
		echo "<script>alert('提交成功');window.location='student_course_list.php'</script>";
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