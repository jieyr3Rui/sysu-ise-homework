<?php
// 允许上传的图片后缀
$servername = "106.55.171.93";
$username = 'root';
$password = 'qwer1234,.';
$dbname = 'db1';
$port = "3306";

$time = date("Y-m-d H:i:s");
$path = "/upload/";
$id = '17363000';
$name = "徐嘉鸿";
$project_num = "aaa";
$extension = end(explode(".", $_FILES["file"]["name"]));     // 获取文件后缀名
$file = $path . $id . '.' . $extension;
$remark = "xxx";

if ($_FILES["file"]["error"] > 0)
{
	echo "错误：: " . $_FILES["file"]["error"] . "<br>";
}
else
{	
	if (file_exists($path . $_FILES["file"]["name"]))
		$res = unlink($path . $_FILES["file"]["name"]);

	move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES['file']['name']);       
	rename($path . $_FILES['file']['name'], $path . $id . '.' . $extension);
    echo "上传成功！";
    
	// 更新数据库
	$conn = mysqli_connect($servename,$username,$password,$dbname,$port);
	//检查连接是否
	if(!$conn)
		die("Error: ". mysqli_connect_error());
	$sql = "UPDATE homework SET file='{$path}',submit_time='{$time}',remark='{$remark}',download_flag='{0}' WHERE project_num='{$project_num}' and id='{$id}'";
	if(!mysqli_query($conn,$sql)) 
		echo "Error updating record: " .mysqli_error($conn); 

}
?>
