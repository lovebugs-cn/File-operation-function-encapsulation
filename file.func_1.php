<?php

//创建文件或目录
function create_file(string $fileName){
    //检测文件是否存在，不存在则创建
    if(file_exists($fileName)){
        return false;
    }

    //检测是否存在目录，不存在则创建
    if(!file_exists(dirname($fileName))){
        //创建目录，设置权限为0777，true表示可以创建多级目录
        mkdir(dirname($fileName),0777,true);
    }
    
    if(touch($fileName)){
        return true;
    }
    return false;
    
    /*
    //另一种创建文件方法：
    if(file_put_contents($fileName,'')!==false){
        return true;
    }
    return false;
    */
}
//var_dump(create_file('1.txt'));

//删除文件
function del_file(string $fileName){
    //检测删除的文件是否存在,并且是否有权限操作
    if(!file_exists($fileName) || !is_writable($fileName)){
        return false;
    }

    if(unlink($fileName)){
        return true;
    }

    return false;
}
//var_dump(del_file('1.txt'));


//拷贝文件
function copy_file(string $fileName,string $dest){
    //检测$dest是否是目标并且这个目录是否存在，不存在则创建
    if(!is_dir($dest)){
        mkdir($dest,0777,true);
    }
    $destName = $dest.DIRECTORY_SEPARATOR.basename($fileName);

    //检测目标路径下是否存在同名文件
    if(file_exists($destName)){
        return false;
    }

    //拷贝文件
    if(copy($fileName,$destName)){
        return true;
    }
    return false;
}
//var_dump(copy_file('1.txt','a'));

//重命名文件
function rename_file(string $oldName,string $newName){
    if(!file_exists($oldName)){
        return false;
    }

    //得到原文件所在的路径
    $path = dirname($oldName);
    $destName = $path.DIRECTORY_SEPARATOR.$newName;

    if(rename($oldName,$destName)){
        return true;
    }
    return false;
}
//var_dump(rename_file('1.txt','222.txt'));

//剪切文件
function cut_file(string $fileName,string $dest){
    if(!file_exists($fileName)){
        return false;
    }

    if(!is_dir($dest)){
        mkdir($dest,0777,true);
    }

    $destName = $dest.DIRECTORY_SEPARATOR.basename($fileName);

    if(file_exists($destName)){
        return false;
    }

    if(rename($fileName,$destName)){
        return true;
    }
    return false;
   
}
//var_dump(cut_file('1.txt','a'));