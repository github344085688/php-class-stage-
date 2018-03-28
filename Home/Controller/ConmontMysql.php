<?php
/** 数据库操作
 * Class ConmontMysql
 */
namespace Home\Controller;
include 'MysqLinters.php';
use Home\Controller\MysqLinters;
class ConmontMysql extends MysqLinters
{
    /*
        private $mysqlhost = '127.0.0.1';
        private $mysqluser = 'root';
        private $mysqpasswd = 'root';
    */
    public $mysqbd;
    public $tablename;

    function __construct($mysqldb, $tablename)
    {
        $this->mysqbd = $mysqldb;
        $this->tablename = $tablename;
    }
    /**
     * 更新数据
     * @param $newdata FirstName新数据
     * @param $olddata LastName新数据
     */
    public function updatas($newdata, $olddata)
    {
        $newup = parent::arraytostring($newdata, ',');
        $oldup = parent::arraytostring($olddata, ' AND ');
        $sql = "UPDATE $this->tablename SET $newup WHERE $oldup";
        return parent::operationmysql($this->mysqbd, $sql);

    }

    /**
     * 查看数据
     * @param $newdata
     * @param $olddata
     * @param string $links
     * @return string
     */

    public function selectdata($newdata, $olddata,$links='')
    {
        $newup = parent::arraytostring($newdata, ',');
        $dataup = parent::arraytostring($olddata,' AND ');
        if($links){
            $sql = "SELECT $newdata FROM $this->tablename WHERE $links";
        }else{
            $sql = "SELECT $newup FROM $this->tablename WHERE $dataup";
        }
        return parent::operationmysql($this->mysqbd, $sql,2);

    }
    /**
     * 插入数据
     * @param $newdata 插入字段
     * @param $olddata 插入
     * @return data
     */
    public function install($newdata, $olddata)
    {
        $newup = $this->arraytostring($newdata, ',');
        $oldup = $this->arraytostring($olddata, ',');
        $sql = "INSERT INTO $this->tablename ($newup) VALUES ($oldup)";
        return parent::operationmysql($this->mysqbd, $sql);

    }
    /**
     * 删除数据
     * @param $newdata 删除字段
     * @return string
     */
    public function delete($newdata)
    {
        $newup = $this->arraytostring($newdata, ',');
        $sql = "DELETE FROM $this->tablename WHERE $newup";
        return parent::operationmysql($this->mysqbd, $sql);

    }

}