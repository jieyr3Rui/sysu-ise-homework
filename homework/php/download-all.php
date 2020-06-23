<?php
  // Create zip
function createZip(){
    $zip = new ZipArchive();
    $filename = "/web-file/download/myzipfile.zip";
    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
      exit("cannot open <$filename>\n");
    }
    $project_num = '000000'; //_POST['project_num'];
    $dir = "/web-file/project/'{$project_num}'/homework/";
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
    $zip->addFile($dir.$file); //addFile("filepath");
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
