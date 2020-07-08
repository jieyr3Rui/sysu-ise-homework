<?php
header("Content-type:text/html;charset=UTF-8");

    $zip = new ZipArchive();
    $filename = "/web-file/download/myzipfile.zip";
    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }
    $project_num = $_GET['project_num'];
    $link = mysqli_connect("106.55.171.93","root","qwer1234,.","db1")or die("链接数据库失败");;
    mysqli_query($link,"set names utf8");

    
    $sql = "SELECT id, file FROM homework WHERE project_num='{$project_num}' AND download_flag=0;";
    $result = $link->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
	//$extension = end(explode(".", $row['file']));  
        $zip->addFile($row["file"], basename($row["file"]));
        echo "file: " . $row["file"]. "<br>";
      }
    } else {
      echo "<script>alert('没有未下载的作业！');window.location='teacher_work_list.php'</script>";    }
    
    $zip->close();
    
    $sql2 = "UPDATE homework SET download_flag=1 WHERE project_num='{$project_num}';";
    if(!$link->query($sql2)) 
         echo "mysql error: " .mysqli_error($link);


if (file_exists($filename)) {
    echo "3";
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Content-Length: ' . filesize($filename));
    ob_clean();
    flush();
    readfile($filename);
    // delete file
    unlink($filename);
}


?>
