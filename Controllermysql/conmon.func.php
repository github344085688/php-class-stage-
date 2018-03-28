<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/10
 * Time: 15:59
 */
/**
 * 计算function
 * @param $var
 * @param $var2
 * @param string $op
 * @return int
 */

/**
 * 函数
 */
function updata($dataname,$tablename,$updata,$newfname, $newlname, $odfname, $odlname)
{

    try {
        $con = new mysqli('127.0.0.1', 'root', 'root');
        mysqli_set_charset($con, 'utf8');
        $con->select_db($dataname);
        $sql = "UPDATE $tablename SET FirstName='$newfname', LastName='$newlname' WHERE FirstName='$odfname' AND LastName='$odlname'";
        $resul = $con->query($sql);
        if ($resul) {
            echo json_encode(array('code' => 2001, 'msg' => '请求成功sss'));
        }
        $con->close();
    } catch (Exception $e) {
        $con->rollback();
        echo "Error creating database: " . $con->connect_error;
    }
}

/**
 * @param $dbname 数据库名
 * $field 数据表搜索字段
 */

function selectdata($dbname,$tablename,$field){
    $con=new mysqli('127.0.0.1','root','root',$dbname);
    mysqli_set_charset($con,'utf8');
    $msql='SELECT '.$tablename.' FROM $tablename WHERE '.$field.'';

}


function calc($var, $var2, $op = '+'){
    if (!is_numeric($var) || !is_numeric($var)) {
        exit('输入非数字类型');
    }
    switch ($op) {
        case '+';
            $res = $var + $var2;
            break;
        case '-';
            $res = $var - $var2;
            break;
        case '*';
            $res = $var * $var2;
            break;
        case '/';
            if ($var2 != 0) {
                $res = $var * $var2;
            } else {
                exit('0不能当除数');
            }
            break;
        case '%';
            $res = $var % $var2;
            break;


    }
    return $res;

}