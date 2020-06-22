<?php
header("Content-type:text/html;charset=UTF-8");
$servername = "106.55.171.93";
$username = 'root';
$password = 'qwer1234,.';
$dbname = 'db1';
$port = "3306";
$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($conn->connect_error) {
    die("failure connection: " . $conn->connect_error);
}

$teacher_id = '10007';//_POST['teacher_id'];

$sql = "SELECT project_name FROM project WHERE course_num IN 
       (SELECT course_id FROM teach_list WHERE teacher_id = '{$teacher_id}')";
echo $sql;

?>
