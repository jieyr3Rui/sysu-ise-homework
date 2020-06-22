$file = $_POST['file'];
$remark = $_POST['remark'];

//上传作业  需要先判断是否已上传
function uploadHomework($project_num, $id)
{
    $time=date("Y-m-d H:i:s");
    
    $conn = new Mysql();
    $sql = "select * from homework where project_num='{$project_num}' and id='{$id}';";
    $result = $conn->sql($sql);

    if ($result) {    //已上传过，需要覆盖
        
        $sql="update homework set file='$file',time='$time',remark='$remark',download_flag='0' WHERE project_num='{$project_num}' and id='{$id}'";
        mysql_query($sql,$conn);
        echo '<html><head><Script Language="JavaScript">alert("重新上传成功！");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html page/log-in.html\">";
    }
    else {
        $sql="insert into homework values('$project_num','$id','$file','$time','$remark','0')";
        mysql_query($sql,$conn);
        echo '<html><head><Script Language="JavaScript">alert("上传成功！");</Script></head></html>' . "<meta http-equiv=\"refresh\" content=\"0;url=../html page/log-in.html\">";
    }
    $conn->close();
}
