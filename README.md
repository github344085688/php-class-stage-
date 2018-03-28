# php-class-stage-
自己写的php类上传保存mysql、
图片上传、设置生成缩略图、设置尺寸中心点裁切不然<br>
//判断文件是否为空或者出错

   
   # 
     *$maxsize                //限制文件上传大小（字节）
     *israndname             //设置是否随机重命名文件， false不随机
     *thumbs=true;          //是否生缩略图
     *thumbCutting         //是否生裁切缩略图
     *thumbsize           //是否压缩尺寸
     *Original           //是否保留原图尺寸
 #   
  $filename = $_FILES['file'];<br>
  if ($upFile['error'] != 0 && !empty($upFile)) {<br>
   $allowtype = array('jpg', 'gif', 'png', 'jpeg'); //设置限制上传文件的类型  <br>
    $dirpath = creaDir('upload');<br>
    $fileuplo = new FileUpload(1000, true, true );<br>
    $fileuplo->path = "uploade";<br>
    $fileuplo->maxsize = "10000";<br>
    $fileuplo->thumbs = true;<br>
    $fileuplo->Original = true;<br>
    $fileuplo->thumbCutting = true;<br>
    $fileuplo->Upload($filename);<br>
}#
