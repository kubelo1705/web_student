<?php
include '../hepler/Funtion.php';
include '../hepler/Database.php';

$id_account=$_GET['id'];
$where='id_account='.$id_account;
$whereAccount='id='.$id_account;
$db=new Database;
$db->connect();

$result=$db->remove('teacher',$where);
if(!$result)
{
    $db->dis_connect();
    $_SESSION['error']='xoa khong thanh cong';
    header("Location: http://localhost/web_student/404.php");
    die();
}
$result=$db->remove('account',$whereAccount);
if(!$result)
{
    $db->dis_connect();
    $_SESSION['error']='xoa khong thanh cong';
    header("Location: http://localhost/web_student/404.php");
    die();
}
$_SESSION['success']='xoa thanh cong';
header("Location: http://localhost/web_student/admin/teacher/");
$db->dis_connect();

?>