<?php 
session_start();
$yh=$_SESSION['user_id'];
$link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
mysqli_query($link,"set names utf8");

$mpass=$_POST['mpass'];
$newpass=$_POST['newpass'];
$pwd = md5($newpass);
$sql="select * from teacher where id='$yh'";
$rs=$link->query($sql);
$row=$rs->fetch_assoc();
if(md5($mpass)==$row['password']){
	$sql1="update teacher set password='$pwd ' where id='$yh'";
    $result=$link->query($sql1);
        if($result){
				  echo "<script>alert('修改密码成功');window.location='teacher_work_list.php'</script>";
			}else{
				echo "<script>alert('修改密码失败');window.location='teacher_pw_update.html'</script>";
				}
		
	}else{
		echo "<script>alert('修改密码失败,请检查原密码是否正确');window.location='teacher_pw_update.html'</script>";
	}

?>
