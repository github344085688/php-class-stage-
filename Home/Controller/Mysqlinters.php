<?php
namespace Home\Controller;
abstract class MysqLinters
{
    const MYSQLHOST = '127.0.0.1';
    const MYSQLUSER = 'root';
    const MYSQLPASSED = 'root';
    /**
     * 数组转字符串
     * @param $array
     * @return string
     */
    public static function arraytostring($arrays, $op = '')
    {
        $string = [];
        if ($arrays && is_array($arrays)) {
            if (key($arrays) != '0' && key($arrays) != 'values') {
                foreach ($arrays as $key => $value) {
                    $string[] .= $key . '=' . "'" . $value . "'";
                }
            } else if (key($arrays) === 'values') {
                foreach ($arrays['values'] as $key => $value) {
                    $string[] .= "'" . $value . "'";
                }
            } else {
                foreach ($arrays as $key) {
                    $string[] .= $key;
                }
            }
        }
        return implode("$op", $string);
    }

    /**
     * mysql数据库操作
     * @param $sql
     */
    protected static function operationmysql($mysqbd, $sql, $op = 1)
    {

        try {
            $con = new mysqli(self::MYSQLHOST, self::MYSQLUSER, self::MYSQLPASSED, $mysqbd);
            mysqli_set_charset($con, 'utf8');
            $resul = $con->query($sql);
            if ($op === 2) {
                if ($resul->num_rows > 0) {
                    $row = $resul->fetch_all();
                    return $row;
                } else {
                    return "0 结果";
                }
            } else {
                if ($resul) {
                    return json_encode(array('code' => 2001, 'msg' => '请求成功'));
                } else {
                    return json_encode(array('code' => 2002, 'msg' => '请求失败'));
                }
            }
        } catch (Exception $e) {
            $con->rollback();
            echo "Error creating database: " . $con->connect_error;
        }
        $con->close();
    }
}