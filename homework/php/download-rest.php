<?php
header("Content-type:text/html;charset=UTF-8");

    $zip = new ZipArchive();
    $filename = "/web-file/download/myzipfile.zip";
    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }

    $servername = "106.55.171.93";
    $username = 'root';
    $password = 'qwer1234,.';
    $dbname = 'db1';
    $port = "3306";
    $project_num = '000007';
    $conn = mysqli_connect($servename, $username, $password, $dbname, $port);
    //检查连接是否成功
    if(!$conn){ 
	die(“失败连接：”. mysqli_connect_error());
    }
    $sql = "SELECT id, file FROM homework WHERE project_num='{$project_num}' AND download_flag=0;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
	//$extension = end(explode(".", $row['file']));  
        $zip->addFile($row["file"], basename($row["file"]));
        echo "file: " . $row["file"]. "<br>";
      }
    } else {
      echo "0 results";
    }
    
    $zip->close();
    
    $sql = "UPDATE homework SET download_flag=1 WHERE project_num='{$project_num}';";
    if(!mysqli_query($conn,$sql)) 
         echo "mysql error: " .mysqli_error($conn);


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
