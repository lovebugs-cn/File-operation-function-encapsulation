<?php

/**
 * 压缩单个文件
 * @method zip_file
 * @param  string   $filename 文件名
 * @return boolean             true|false
 */
function zip_file(string $filename){
  if(!is_file($filename)){
    return false;
  }
  $zip=new ZipArchive();
  $zipName=basename($filename).'.zip';
  //打开指定压缩包，不存在则创建，存在则覆盖
  if($zip->open($zipName,ZipArchive::CREATE|ZipArchive::OVERWRITE)){
    //将文件添加到压缩包中
    if($zip->addFile($filename)){
      @unlink($filename);//压缩后删除了原文件
    }
    $zip->close();
    return true;
  }else{
    return false;
  }
}
// var_dump(zip_file('22.txt'));



/**
 * 多文件压缩
 * @method zip_files
 * @param  string    $zipName 压缩包的名称，.zip结尾
 * @param  string     $files   需要压缩文件名，可以是多个
 * @return boolean             true|false
 */
function zip_files(string $zipName,...$files){
  //检测压缩包名称是否正确
  $zipExt=strtolower(pathinfo($zipName,PATHINFO_EXTENSION));
  if('zip'!==$zipExt){
    return false;
  }
  $zip=new ZipArchive();
  if($zip->open($zipName,ZipArchive::CREATE|ZipArchive::OVERWRITE)){
    foreach($files as $file){
      if(is_file($file)){
        $zip->addFile($file);
      }
    }
    $zip->close();
    return true;
  }else{
    return false;
  }
}
// var_dump(zip_files('test1.zip','22.txt'));
// var_dump(zip_files('test2.zip','doUpload.php','downLoad.html','upload.html'));

/**
 * 解压缩
 * @method unzip_file
 * @param  string     $zipName 压缩包名称
 * @param  string     $dest    解压到指定目录
 * @return boolean              true|false
 */
function unzip_file(string $zipName,string $dest){
  //检测要解压压缩包是否存在
  if(!is_file($zipName)){
    return false;
  }
  //检测目标路径是否存在
  if(!is_dir($dest)){
    mkdir($dest,0777,true);
  }
  $zip=new ZipArchive();
  if($zip->open($zipName)){
    $zip->extractTo($dest);
    $zip->close();
    return true;
  }else{
    return false;
  }
}
// var_dump(unzip_file('test2.zip','a'));


