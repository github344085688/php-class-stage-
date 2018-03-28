<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/15
 * Time: 11:41
 */

namespace Home\index;
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type,api-version');
header('Content-Type:application/x-www-form-urlencoded; charset=utf-8');

require_once '../Model/fileupload.class.php';

use Home\Model\FileUpload;

$upFile = $_FILES['file'];

/**
 * 创建文件夹函数,用于创建保存文件的文件夹
 * @param str $dirPath 文件夹名称
 * @return str $dirPath 文件夹名称
 */


//判断文件是否为空或者出错
if ($upFile['error'] != 0 && !empty($upFile)) {
    $allowtype = array('jpg', 'gif', 'png', 'jpeg'); //设置限制上传文件的类型
    //var_dump($_FILES['file']);
    // $dirpath = creaDir('upload');
    $filename = $_FILES['file'];
    /**
     *$maxsize                //限制文件上传大小（字节）
     *israndname             //设置是否随机重命名文件， false不随机
     *thumbs=true;          //是否生缩略图
     *thumbCutting         //是否生裁切缩略图
     *thumbsize           //是否压缩尺寸
     *Original           //是否保留原图尺寸
     */
    $fileuplo = new FileUpload(1000, true, true );
    $fileuplo->path = "uploade";
    $fileuplo->maxsize = "10000";
    $fileuplo->thumbs = true;
    $fileuplo->Original = true;
    $fileuplo->thumbCutting = true;
    $fileuplo->Upload($filename);
}




















/*  $imagesurl=array();
     foreach ($filename  as  $key => $value){
         $fileType=$_FILES['file']['type'][$key];
         print_r($fileType) ;
         echo "\n";
         $Types=explode("/", $fileType);
         echo "\n";
         var_dump($Types) ;
        // echo explode("/", $fileType);
        // is_array('aa',$allowtype);
         $queryPath = './'.$dirpath.'/'.$value;
         if(move_uploaded_file($_FILES['file']['tmp_name'][$key],$queryPath)){
             $imagesurl[] .= dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]) .'/'. $dirpath .'/'. $value ;
         }
     }
  echo json_encode($imagesurl);*/
/*echo "<hr>";
var_dump($filename);
echo "<hr>";
$queryPath = './'.$dirpath.'/'.$filename;
//move_uploaded_file将浏览器缓存file转移到服务器文件夹
if(move_uploaded_file($_FILES['file']['tmp_name'][0],$queryPath)){
    echo $queryPath;
}*/


/*if (isset($_REQUEST['data'])) {
    $files=$_REQUEST['data'];
    var_dump($files);




}*/