<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/19
 * Time: 14:05
 */
/**
 * 文件上传生成缩略图
 */
namespace Home\Model;


class fileCompress
{
    private $imgsrc;
    private $pathimg;
    private $image;
    private $imageinfo;
    private $percent = 0.5;

    public function __construct($path)
    {
        $this->imgsrc = $path;
    }

    public function compress($imgsrc, $aytype, $resize_width, $resize_height, $isCut)
    {
        $this->pathimg = $this->imgsrc . substr($imgsrc, 2);
        if ($aytype == "jpg") {
            $im = imagecreatefromjpeg($this->pathimg);
        }
        if ($aytype == "jpeg") {
            $im = imagecreatefromjpeg($this->pathimg);
        }
        if ($aytype == "gif") {
            $im = imagecreatefromgif($this->pathimg);
        }
        if ($aytype == "png") {
            $im = imagecreatefrompng($this->pathimg);
        }

        $full_length = strlen($this->pathimg);

        $type_length = strlen($aytype);
        $name_length = $full_length - $type_length;
        $name = substr($this->pathimg, 0, $name_length - 1);
        $dstimg = $name . $resize_width . '_' . $resize_height . "." . $aytype;
        $width = imagesx($im);

        $height = imagesy($im);
        $resize_ratio = ($resize_width) / ($resize_height);
        $ratio = ($width) / ($height);
        $secX = $width / 2 - ($height) * $resize_ratio / 2;
        $secY = $height / 2 - (($width) / $resize_ratio) / 2;
        if ($isCut) { //裁图
            if ($ratio >= $resize_ratio) { //高度优先
                $newimg = imagecreatetruecolor($resize_width, $resize_height);
                imagecopyresampled($newimg, $im, 0, 0, $secX, 0, $resize_width, $resize_height, (($height) * $resize_ratio), $height);
                ImageJpeg($newimg, $dstimg);
            }
            if ($ratio < $resize_ratio) { //宽度优先
                $newimg = imagecreatetruecolor($resize_width, $resize_height);
                imagecopyresampled($newimg, $im, 0, 0, 0, $secY, $resize_width, $resize_height, $width, (($width) / $resize_ratio));
                ImageJpeg($newimg, $dstimg);
            }
        } else { //不裁图
            if ($ratio >= $resize_ratio) {
                $newimg = imagecreatetruecolor($resize_width, ($resize_width) / $ratio);
                imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, ($resize_width) / $ratio, $width, $height);
                ImageJpeg($newimg, $dstimg);
            }
            if ($ratio < $resize_ratio) {
                $newimg = imagecreatetruecolor(($resize_height) * $ratio, $resize_height);
                imagecopyresampled($newimg, $im, 0, 0, 0, 0, ($resize_height) * $ratio, $resize_height, $width, $height);
                ImageJpeg($newimg, $dstimg);
            }
        }
        ImageDestroy($im);

    }

}