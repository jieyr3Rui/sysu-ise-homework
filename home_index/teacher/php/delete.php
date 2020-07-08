<?php
header("Content-type:text/html;charset=UTF-8");
$link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
mysqli_query($link,"set names utf8");

$project_num = $_GET['project_num'];
$sql2 = "SELECT file,answer_file FROM `project` WHERE project_num =  '{$project_num}'";
$result2 = $link->query($sql2);
$row = $result2->fetch_assoc();
$file = $row["file"];
$answer_file = $row["answer_file"];

$sql = "DELETE FROM `project` WHERE project_num= '{$project_num}' ";

$result = $link->query($sql);
if(!result){
    echo "<script>alert('删除失败');window.location='teacher_work_list.php'</script>";
}else{
    unlink($file);
    unlink($answer_file);
    echo "<script>alert('删除成功');window.location='teacher_work_list.php'</script>";
}



?>