<?php
header("Content-type:text/html;charset=UTF-8");
$servername = "106.55.171.93";
$username = 'root';
$password = 'qwer1234,.';
$dbname = 'db1';
$port = "3306";

$number = get_new_number($servername, $username, $password, $dbname, $port);
$temp_str1 = '000000' . strval($number);
$project_num = substr($temp_str1, strlen($temp_str1) - 6, 6);
echo 'project_num = ' . $project_num . '\n';
$course_num = 'ISE300'; //_POST['course_num'];
$project_name = '软件工程作业my ' . strval($number) . 'th project'; //_POST['project_name'];
$description = 'description: this is my ' . strval($number) . 'th project'; //_POST['discription'];
$ddl = '2020-6-21'; //_POST['ddl']'
$format = 'excel'; //_POST['format'];
$upload_time = '2020-6-10'; //_POST['upload_time'];
$submit_number = 0; //smallint(6)
$submit_per = 0.0; //smallint(6)
$score_number = 0; //smallint(6)
$file = 'none';


$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($conn->connect_error) {
    die("failure connection: " . $conn->connect_error);
}
$sql = 'INSERT INTO project (project_num, course_num, project_name, description, ddl, format, upload_time, submit_number, submit_per, score_number, file) 
        VALUES ("' .
        $project_num           . '", "' .
        $course_num            . '", "' .
        $project_name          . '", "' .
        $description           . '", "' .
        $ddl                   . '", "' .
        $format                . '", "' .
        $upload_time           . '", "' .
        strval($submit_number) . '", "' .
        strval($submit_per)    . '", "' .
        strval($score_number)  . '", "' .
        $file                  . '");';

if ($conn->query($sql) === TRUE) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}







function get_new_number($servername, $username, $password, $dbname, $port){
    $number = 0;
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    // Check connection
    if ($conn->connect_error) {
        die("failure connection: " . $conn->connect_error);
    } 
    $sql = "SELECT COUNT(project_num) FROM project";
    $result = $conn->query($sql);
    if($result){
        while($row = $result->fetch_assoc()) {
            $number = $row['COUNT(project_num)'];
        }
        // return number;
        // echo 'num is' . strval($number);
        return $number;
    }
    else{
        echo 'error';
    }
}

?>
