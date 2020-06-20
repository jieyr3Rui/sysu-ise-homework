<?php ob_start (); ?>
<?php
header("Content-type:text/html;charset=UTF-8");
require "mysql.php";      //导入mysql.php访问数据库

get_new_number();

function get_new_number(){
    $number = 0;
    $conn = new Mysql();
    $sql = "SELECT COUNT(project_num) FROM project";
    $result = $conn->sql($sql);
    echo 'debug';
    if(($result) && (($result->num_rows > 0)){
        while($row = $result->fetch_assoc()) {
            $number = $row['COUNT(project_num)'];
        }
        //return number;
        echo 'num is' . strval($number);
    }
    else{
        echo '<html><head><Script Language="JavaScript">alert("数据库查询错误");</Script></head></html>';
    }
    
}

?>
