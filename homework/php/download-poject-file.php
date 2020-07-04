<?php
header("Content-type:text/html;charset=UTF-8");
$servername = "106.55.171.93";
$username = 'root';
$password = 'qwer1234,.';
$dbname = 'db1';
$port = "3306";
$conn = mysqli_connect($servename,$username,$password,$dbname,$port);
//检查连接是否成功
if(!$conn){ 
	die(“失败连接：”. mysqli_connect_error());
}
$project_num = $_POST['project_num'];
//$project_num = 'ISE3000002';
$sql = "SELECT file FROM project WHERE project_num = '{$project_num}'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$file = $row["file"];

if(!file_exists($file)){
	echo "-1";
	die('file not found');
} else {
	echo "2";
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment;filename=$file");
	header("Content-Type: application/zzip");
	header("Content-Transfer-Encoding: binary");

	//read the file from disk
	readfile($file);
}
?>
