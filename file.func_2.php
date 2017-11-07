<?php
header('content-type:text/html;charset=utf-8');
//返回文件信息函数
function get_file_info(string $fileName){

    if(!is_file($fileName) || !is_readable($fileName)){
        return false;
    }

    return [
        '最后访问时间：'=>date('H-m-d H:i:s',fileatime($fileName)),
        '文件修改时间：'=>date('H-m-d H:i:s',filemtime($fileName)),
        'inode修改时间：'=>date('H-m-d H:i:s',filectime($fileName)),
        '文件大小：'=>trans_byte(filesize($fileName)),
        '文件类型：'=>filetype($fileName)
    ];
}
//var_dump(get_file_info('a/1.txt'));

//字节单位转换函数
function trans_byte(int $byte,int $precision=2){
    $kb = 1024;
    $mb = 1024 * $kb;
    $gb = 1024 * $mb;
    $tb = 1024 * $gb;
    if($byte < $kb){
        return $byte.'B';
    }elseif($byte < $mb){
        return round($byte/$kb,$precision).'KB';
    }elseif($byte < $gb){
        return round($byte/$mb,$precision).'MB';
    }elseif($byte < $tb){
        return round($byte/$gb,$precision).'GB';
    }else{
        return round($byte/$tb,$precision).'TB';
    }
}
//var_dump(trans_byte(12345678));
