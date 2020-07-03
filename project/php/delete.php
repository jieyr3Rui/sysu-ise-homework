<?php
$servername = "106.55.171.93";
$username = 'root';
$password = 'qwer1234,.';
$dbname = 'db1';
$port = "3306";

$project_num = $_POST['project_num'];

$conn = mysqli_connect($servename,$username,$password,$dbname,$port);
if(!$conn)
{
	die("Error: ". mysqli_connect_error());
}
$sql1 = "SELECT * FROM project WHERE project_num='{$project_num}';";
$result1 = $conn->query($sql1);
while($row = $result1->fetch_assoc())
{
	$ans_del = unlink($row['answer_file']); //删除项目答案文件
	$req_del = unlink($row['file']);  //删除项目要求文件
}

$sql2 = "SELECT file FROM homework WHERE project_num='{$project_num}';";
$result2 = $conn->query($sql2);
while($r = $result2->fetch_assoc())
{
	$home_del = unlink($r['file']); //删除学生作业文件
}

$path1 = "/web-file/project/{$project_num}/homework/";
$path2 = "/web-file/project/{$project_num}/answer/";
$path3 = "/web-file/project/{$project_num}/requirement/";
$path4 = "/web-file/project/{$project_num}/";
$del1 = rmdir($path1);
$del2 = rmdir($path2);
$del3 = rmdir($path3);
$del4 = rmdir($path4);
echo "删除成功！";


// $sql3 = "DELETE project,homework FROM project,homework WHERE project.project_num = homework.project_num AND project.project_num = '{$project_num}';";
// $result3 = $conn->query($sql3);
// if(!mysqli_query($conn,$sql3)) 
// 	echo "mysql error" .mysqli_error($conn);
// else
// 	echo "删除成功！";

$sql3 = "DELETE homework FROM homework WHERE project_num = '{$project_num}';";
if(!mysqli_query($conn,$sql3)) 
	echo "mysql error" .mysqli_error($conn);
else
	echo "成功删除学生作业！";

$sql4 = "DELETE project FROM project WHERE project_num = '{$project_num}';";
if(!mysqli_query($conn,$sql4)) 
	echo "mysql error" .mysqli_error($conn);
else
	echo "成功删除作业项目！";

?>