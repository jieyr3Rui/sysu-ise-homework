<?php
$servername = "106.55.171.93";
$username = 'root';
$password = 'qwer1234,.';
$dbname = 'db1';
$port = "3306";

$course_num = $_POST['course_num'];

$conn = mysqli_connect($servename,$username,$password,$dbname,$port);
if(!$conn)
{
	die("Error: ". mysqli_connect_error());
}

$sql1 = "SELECT * FROM project WHERE course_num='{$course_num}';";
$result1 = $conn->query($sql1);
while ($row=mysqli_fetch_row($result1))
{
	echo $row[0]."  ".$row[2]."  ".$row[3]."  ".$row[4];
	echo "\n";
}
?>