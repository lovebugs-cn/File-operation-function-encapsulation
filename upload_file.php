<?php
/**
 * 单文件上传
 * @method upload_file
 * @param  string       $fileName   上传的文件名
 * @param  string      $uploadPath 文件上传默认路径
 * @param  boolean     $imageFlag  是否检测真实图片
 * @param  array       $allowExt   允许上传的文件类型
 * @return mixed                  成功返回文件最终保存路径及名称，失败返回false
 */
function upload_file(string $fileName,string $uploadPath='./uploads',bool $imageFlag=true,array $allowExt=array('jpeg','jpg','png','gif'),int $maxSize=2097152){

    $fileInfo = $_FILES($fileName);

    define('UPLOAD_ERRS',[
      'upload_max_filesize'=>'超过了PHP配置文件中upload_max_filesize选项的值',
      'form_max_size'=>'超过了表单MAX_FILE_SIZE选项的值',
      'upload_file_partial'=>'文件部分被上传',
      'no_upload_file_select'=>'没有选择上传文件',
      'upload_system_error'=>'系统错误',
      'no_allow_ext'=>'非法文件类型',
      'exceed_max_size'=>'超出允许上传的最大值',
      'not_true_image'=>'文件不是真实图片',
      'not_http_post'=>'文件不是通过HTTP POST方式上传上来的',
      'move_error'=>'文件移动失败'
    ]);
  
    //检测是否上传是否有错误
    if($fileInfo['error'] === UPLOAD_ERR_OK){
      //检测上传文件类型
      $ext=strtolower(pathinfo($fileInfo['name'],PATHINFO_EXTENSION));
      if(!in_array($ext,$allowExt)){
        echo  UPLOAD_ERRS['no_allow_ext'];
        return false;
      }
      //检测上传文件大小是否符合规范
      if($fileInfo['size'] > $maxSize){
        echo UPLOAD_ERRS['exceed_max_size'];
        return false;
      }
      //检测是否是真实图片
      if($imageFlag){
        if(@!getimagesize($fileInfo['tmp_name'])){
          echo UPLOAD_ERRS['not_true_image'];
          return false;
        }
      }
      //检测文件是否通过HTTP POST方式上传上来的
      if(!is_uploaded_file($fileInfo['tmp_name'])){
        return UPLOAD_ERRS['not_http_post'];
      }
      //检测目标目录是否存在，不存在则创建
      if(!is_dir($uploadPath)){
        mkdir($uploadPath,0777,true);
      }
      //生成唯一文件名，防止重名产生覆盖
      $uniName=md5(uniqid(microtime(true),true)).'.'.$ext;
      $dest=$uploadPath.DIRECTORY_SEPARATOR.$uniName;
  
      //移动文件
      if(@!move_uploaded_file($fileInfo['tmp_name'],$dest)){
        echo UPLOAD_ERRS['move_error'];
        return false;
      }
      echo '文件上传成功';
      return $dest;
    }else{
      switch($fileInfo['error']){
        case 1:
        // $mes='超过了PHP配置文件中upload_max_filesize选项的值';
        $mes=UPLOAD_ERRS['upload_max_filesize'];
        break;
        case 2:
        $mes=UPLOAD_ERRS['form_max_size'];
        break;
        case 3:
        $mes=UPLAOD_ERRS['upload_file_partial'];
        break;
        case 4:
        $mes=UPLOAD_ERRS['no_upload_file_select'];
        break;
        case 6:
        case 7:
        case 8:
        $mes=UPLAOD_ERRS['upload_system_error'];
        break;
      }
      echo $mes;
      return false;
    }
  }
