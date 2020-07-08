<?php
header("Content-type:text/html;charset=UTF-8");
$link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
mysqli_query($link,"set names utf8");
//检查连接是否成功
if(!$link){ 
	die(“失败连接：”. mysqli_connect_error());
}
$project_num = $_GET['project_num'];


$sql = "SELECT answer_file FROM `project` WHERE project_num =  '{$project_num}'";

$result = $link->query($sql);

$row = $result->fetch_assoc();

$file = $row["answer_file"];

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
