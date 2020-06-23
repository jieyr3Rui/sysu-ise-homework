<?php
header("Content-type:text/html;charset=UTF-8");
  // Create zip
function createZip(){
    $zip = new ZipArchive();
    $filename = "/download/myzipfile.zip";
    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }
  
    $dir = '/upload/';
    //文件夹操作
    if (is_dir($dir)){
  
      if ($dh = opendir($dir)){
         while (($file = readdir($dh)) !== false){
   
           // If file
           if (is_file($dir.$file)) {
              if($file != '' && $file != '.' && $file != '..'){
   
                 $zip->addFile($dir.$file);//添加文件到zip
              }
           }else{
              // If directory
              if(is_dir($dir.$file) ){
  
                if($file != '' && $file != '.' && $file != '..'){
  
                  // Add empty directory
                  $zip->addEmptyDir($dir.$file);//添加空文件夹到zip
  
                  $folder = $dir.$file.'/';
   
                  // Read data of the folder
                  createZip($zip,$folder);
                }
              }
           }
         }
         closedir($dh);
       }
    }

    $servername = "106.55.171.93";
    $username = 'root';
    $password = 'qwer1234,.';
    $dbname = 'db1';
    $port = "3306";
    $project_num = 000000;
    $conn = mysqli_connect($servename，$username，$password，$dbname，$port);
    //检查连接是否成功
		if(!$conn){ 
			die(“失败连接：”. mysqli_connect_error());
    }
    $sql = "SELECT file FROM homework WHERE project_num = '{$project_num}' AND download_flag = 0 ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $zip->addFile($row["file"]); //addFile("filepath");
        echo "file: " . $row["file"]. "<br>";
      }
    } else {
      echo "0 results";
    }
    
    $zip->close();
  }
// Download Created Zip file
if(isset($_POST['download'])){
echo "1";
createZip();
echo "2";
$filename = "/download/myzipfile.zip";

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

}
?>
