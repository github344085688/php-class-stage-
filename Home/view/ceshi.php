<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/1/10
 * Time: 16:33
 */
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type,api-version');
include_once 'Controllermysql/ConmontMysql.php';
//echo $_SERVER['HTTP_API_VERSION'];


if (isset($_GET['getdata']) && $_GET['getdata'] === 'selct') {
    $selct = array('firstname'=>$_POST['firstname'],'lastname'=>$_POST['lastname'],'email'=>$_POST['email']);
    $selectdata = new ConmontMysql('my_db', 'myguests');
    $seldata = $selectdata->selectdata(array('firstname', 'lastname', 'email'), $selct);
    $daat = array();
    echo json_encode($daat);
}
if (isset($_GET['getdata']) && $_GET['getdata'] === 'updates') {
    $updates = new ConmontMysql('my_db', 'myguests');
    $updata = $updates->updatas(array('firstname' => 'ddd', 'firstname' => 'www'), array('id' => '5'));
    echo $updata;
}

if (isset($_GET['getdata']) && $_GET['getdata'] === 'install') {
    $install = new ConmontMysql('my_db', 'myguests');
    $indata = $install->install(array('firstname', 'lastname', 'email'), array('values' => array('ss', 'dd', 'cc')), 1);
    echo $indata;
}

if (isset($_GET['getdata']) && $_GET['getdata'] === 'delete') {
    $delete = new ConmontMysql('my_db', 'myguests');
    $deldata = $delete->delete(array('firstname' => 'ss'));
    echo $deldata;
}


