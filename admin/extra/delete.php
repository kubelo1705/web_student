<?php
include '../hepler/Funtion.php';
include '../hepler/Database.php';
session_start();
$id=$_GET['id'];
$where='id='.$id;
$db=new Database;
$db->connect();

$result=$db->remove('extra',$where);
if(!$result)
{
    $db->dis_connect();
    $_SESSION['error']='xoa khong thanh cong';
}
else{
$_SESSION['success']='xoa thanh cong';
}
header("Location: http://localhost/web_student/admin/extra/");
$db->dis_connect();

?>