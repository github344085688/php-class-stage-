<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/16
 * Time: 15:15
 */

/**
 * 文件上传模型
 */

namespace Home\Model;
require_once 'fileCompress.class.php';
require_once '../Controller/ConmontMysql.php';

use Home\Model\fileCompress;
use Home\Controller\ConmontMysql;

/**
 * Class fileupload
 * @package Home\fileupload
 */
class FileUpload
{
    public $path = "uploade";             //上传文件保存的路径
    public $jsonpath = "jsonuploade";     //上传文件保存的路径
    public $allowtype = array('jpg', 'gif', 'png', 'jpeg'); //设置限制上传文件的类型
    public $maxsize = 100;                //限制文件上传大小（字节）
    public $israndname = true;           //设置是否随机重命名文件， false不随机
    public $thumbs = true;                 //是否生缩略图
    public $thumbCutting = true;           //是否生裁切
    public $thumbsize = [240, 260];         //是否压缩尺寸
    public $Original = true;               //是否保留原图尺寸
    function __construct($maxsize = 10000, $israndname = true, $Original = true, $thumbsize = [240, 260], $path = "uploade", $allowtype = array('jpg', 'gif', 'png', 'jpeg'), $maxsize = 1000000)
    {
        $this->maxsize = $maxsize;
        $this->israndname = $israndname;
        if ($this->thumbsize[0] == 240 && $this->thumbsize[1] == 260) {
            $this->thumbCutting = false;
        }
        $this->thumbsize = $thumbsize;
        $this->Original = $Original;
        $this->path = $path;
        $this->allowtype = $allowtype;
        $this->maxsize = $maxsize;
    }

    public function Upload($filedata)
    {
       // print_r($filedata);
        $dirpath = $this->creaDir($this->path);
        $dirpathjson = $this->creaDir($this->jsonpath);
        $filesname = $filedata['name'];
        $imagesurlmin = [];
        $imagesurlmax = [];
        foreach ($filesname as $key => $value) {


            /*  if ($this->JudgementSize($filesname[$key],$filedata['size'][$key], $this->maxsize)) {
                  echo "ssssssssssss";
              } else {
                  echo "aaaaa";
              }*/


            $nametype = $this->extractName($filedata['type'][$key], '/', 1);
            $aytype = $this->extractName($filedata['name'][$key], '.', 2);
            $newname = $this->proRandName($aytype, $nametype);
            //保存图片地址
            if (in_array($nametype, $this->allowtype)) {
                $queryPath = '../../' . $dirpath . '/' . $newname;
                $queryPathanme = '../' . $dirpath . '/' . $newname;
                if (move_uploaded_file($filedata['tmp_name'][$key], $queryPath)) {
                    //压缩图片并生成新缩略图：是否需要保留原图
                    if ($this->thumbs) {
                        $image = new fileCompress(dirname(dirname(__DIR__)) . '/');
                        $image->compress($queryPathanme, $nametype, $this->thumbsize[0], $this->thumbsize[1], $this->thumbCutting);
                        $minimg = dirname("http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER["REQUEST_URI"])) . "/" . $dirpath . "/" . str_replace('.' . $nametype, '', $newname) . $this->thumbsize[0] . "_" . $this->thumbsize[1] . "." . $nametype;
                        $maximg = dirname("http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER["REQUEST_URI"])) . "/" . $dirpath . "/" . $newname;
                        $imagesurlmin[] .= $minimg;
                        //删除原图
                        if ($this->Original) {
                            $imagesurlmax[] .= $maximg;
                        }

                    } else if ($this->Original) {
                        $imagesurlmax[] .= dirname("http://" . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"]) . "/" . $dirpath . "/" . $newname;
                    }
                    //删除原图
                    if (!$this->Original) {
                        unlink($queryPath);
                    }
                }
            } else {
                //保存其他格式文件
                $queryPath = './' . $dirpathjson . '/' . $value;
                if (move_uploaded_file($filedata['tmp_name'][$key], $queryPath)) {
                    $imagesurlmax[] .= dirname('http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"]) . '/' . $dirpath . '/' . $newname;
                }
            }
        }
        if (count($imagesurlmin) > 0 && count($imagesurlmax) > 0) {
            $imagesurl = array("minimg" => $imagesurlmin, "maximg" => $imagesurlmax);
        } else
            if (count($imagesurlmin) > 0) {
                $imagesurl = array("minimg" => $imagesurlmin);
            } else
                if (count($imagesurlmax) > 0) {
                    $imagesurl = array("maximg" => $imagesurlmax);
                } else {
                    $imagesurl = array();
                }

        $install = new ConmontMysql('my_db', 'myguests');
        $indata = $install->install(array('firstname', 'lastname', 'email'), array('values' => array('ss', 'dd', 'cc')), 1);
        echo $indata;

        echo json_encode($imagesurl, JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param $dirPath 文件名
     * @return mixed 创建保存图片的文件名
     */
    private function creaDir($dirPath)
    {
        $curPath = dirname(dirname(__FILE__));
        $path = dirname($curPath) . '\\' . $dirPath;
        if (is_dir($path) || mkdir($path, 0777, true)) {
            return $dirPath;
        }
    }

    /**
     * 提取文件的后缀名
     * @param $filtype
     * @return mixed
     */
    private function extractName($filtype, $Division, $index)
    {
        $Types = explode($Division, $filtype);
        return ($Types[count($Types) - $index]);

    }

    /**
     * 文件重命名
     * @return string
     */

    private function proRandName($oldname, $type)
    {
        $fileName = $this->random(20, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
        return $fileName . '.' . $type;
    }

    /**
     * 随机生成字母
     * @param $length
     * @param string $chars
     * @return string
     */
    private function random($length, $chars = '0123456789')
    {
        $hash = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    /**
     * 判断文件大小
     * @param $filesize
     * @param $Setupsize
     */
    private function JudgementSize($filename, $filesize, $Setupsize)
    {
        if ($filesize < $Setupsize) {
            return false;
        } else {
            return true;
        }

    }


}