<?php
$allowedExts = array("pdf", "doc", "docx");// 允许上传的图片后缀
$extension = end(explode(".", $_FILES["file"]["name"]));// 获取文件后缀名
if ((($_FILES["file"]["type"] == "text/pdf") || 
     ($_FILES["file"]["type"] == "application/msword")) && 
     in_array($extension, $allowedExts)){
	if ($_FILES["file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
		// 若文件已存在，先删除原文件
		if (file_exists("upload/" . $_FILES["file"]["name"]))
			$res = unlink("upload/" . $_FILES["file"]["name"]);

		move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
		echo "上传成功！";
	}
}
else
{
	echo "非法的文件格式";
}


$file = "upload/" . $_FILES["file"]["name"];
$remark = $_POST['remark'];

//上传作业  需要先判断是否已写入数据库
function uploadHomework($project_num, $id)
{
    $time = date("Y-m-d H:i:s");
    
    $conn = new Mysql();
    $sql = "select * from homework where project_num='{$project_num}' and id='{$id}';";
    $result = $conn->sql($sql);

    if ($result) {    //已上传过，需要覆盖
        
        $sql="update homework set file='$file',time='$time',remark='$remark',download_flag='0' WHERE project_num='{$project_num}' and id='{$id}';";
        mysql_query($sql,$conn);
        echo '<html><head><Script Language="JavaScript">alert("重新上传成功！");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html page/log-in.html\">";
    }
    else {
        $sql="insert into homework values('$project_num','$id','$file','$time','$remark','0');";
        mysql_query($sql,$conn);
        echo '<html><head><Script Language="JavaScript">alert("上传成功！");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html page/log-in.html\">";
    }
    $conn->close();
}

?>
