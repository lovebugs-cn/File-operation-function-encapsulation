<?php

//读取文件内容，返回字符串
function read_file(string $fileName){

    if(is_file($fileName) && is_readable($fileName)){
        return file_get_contents($fileName);
    }

    return false;
}
//var_dump(read_file('a/1.txt'));


//读取文件内容到数组中
function read_file_array(string $fileName,bool $skip_empty_lines=false){
    
    if(is_file($fileName) && is_readable($fileName)){
        //是否过滤掉空行
        if($skip_empty_lines){
            return file($fileName,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
        }
        return file($fileName);
    }
    return false;
}
//var_dump(read_file_array('a/1.txt'));
//var_dump(read_file_array('a/1.txt',true));


//向文件中写入内容
function write_file(string $fileName,$data,bool $clearFlag=false){

    $dirName = dirname($fileName);
    //检测目标路径是否存在
    if(!file_exists($dirName)){
        mkdir($dirName,0777,true);
    }

    //读取文件内容，之后和新写入的内容拼装到一起
    if(is_file($fileName) && is_readable($fileName)){
        if(filesize($fileName) > 0){
            $src_date = file_get_contents($fileName);
        }
    }

    //判断内容是否是数组或对象
    if(is_array($data) || is_object($data)){
        $data = serialize($data);
    }

    //判断是否清空原来的内容
    $data = $clearFlag ? $data : $src_date.$data;

    //向文件中写入内容
    if(file_put_contents($fileName,$data)){
        return true;
    }
    return false;

}

//var_dump(write_file('a/1.txt','hello'));
//var_dump(write_file('a/1.txt','world',true));


//截断文件到指定大小
function truncate_file(string $fileName,int $length){

    if(is_file($fileName) && is_writable($fileName)){
        $handle = fopen($fileName,'r+');
        $length = $length < 0 ? 0 : $length;
        ftruncate($handle,$length);
        fclose($handle);
        return true;
    }
    return false;
}
//var_dump(truncate_file('a/1.txt',2));