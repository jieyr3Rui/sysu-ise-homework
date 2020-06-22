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

$student_id = '17363098';//_POST['student_id'];

$sql = "SELECT project_name FROM project WHERE course_num IN 
       (SELECT course_id FROM elective WHERE student_id = '{$student_id}');";
echo $sql . '<br>';
$result = $conn->query($sql);
if($result){
    echo 'i found ' . strval($result->num_rows) . ' projects:' . '<br>';
    while($row = $result->fetch_assoc()){
        echo $row['project_name'] . '<br>';
        
    }
}

?>
