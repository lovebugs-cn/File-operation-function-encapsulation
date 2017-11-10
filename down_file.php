<?php

function down_file(string $fileName,array $allowDownExt=array('jpeg','jpg','png','gif','txt','html','php','rar','zip')){
    //检测下载文件是否存在，并且可读
    if(!is_file($fileName)||!is_readable($fileName)){
      return false;
    }

    //检测文件类型是否允许下载
    $ext=strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
    if(!in_array($ext,$allowDownExt)){
      return false;
    }

    //通过header()发送头信息
  
    //告诉浏览器输出的是字节流
    header('Content-Type:application/octet-stream');
  
    //告诉浏览器返回的文件大小是按照字节进行计算的
    header('Accept-Ranges: bytes');
  
    $filesize=filesize($fileName);
    //告诉浏览器返回的文件大小
    header('Accept-Length: '.$filesize);
  
    //告诉浏览器文件作为附件处理，告诉浏览器最终下载完的文件名称
    header('Content-Disposition: attachment;fileName=down_'.basename($fileName));
  
    //读取文件中的内容
  
    //规定每次读取文件的字节数为1024字节，直接输出数据
    $read_buffer=1024;
    $sum_buffer=0;
    $handle=fopen($fileName,'rb');
    while(!feof($handle) && $sum_buffer<$filesize){
      echo fread($handle,$read_buffer);
      $sum_buffer+=$read_buffer;
    }
    fclose($handle);
    exit;
  }