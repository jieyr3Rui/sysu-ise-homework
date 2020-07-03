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
$project_num = $_POST['project_num'];
$student_id = $_POST['student_id'];
$score = $_POST['score'];

$sql = "UPDATE homework set score='$score' WHERE project_num='$project_num' AND id='$student_id'";

echo $sql . '<br>';

$result = $conn->query($sql);
if($result){
    echo "score success";
}

?>
