<?php
header("Content-type:text/html;charset=UTF-8");
$servername = "localhost";
$username = "root";
$password = "qwer1234,.";
$dbname = "db1";

get_new_number();

function get_new_number(){
    $number = 0;
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("failure connection: " . $conn->connect_error);
    } 
    
    $sql = "SELECT COUNT(project_num) FROM project";
    $result = $conn->query($sql);
    if(($result) && (($result->num_rows > 0)){
        while($row = $result->fetch_assoc()) {
            $number = $row['COUNT(project_num)'];
        }
        //return number;
        echo 'num is' . strval($number);
    }
    else{
        echo 'error';
    }
    
}

?>
