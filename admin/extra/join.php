<?php
session_start();
include '../hepler/Funtion.php';
include '../hepler/Database.php';
if($_SESSION['level']!=3)
{
    $_SESSION['error']='Hoat dong danh cho hoc sinh';
    header('Location:http://localhost/web_student/admin/extra');
}
else{
    $id_extra=$_GET['id_extra'];
    $db=new Database;
    $db->connect();
    $whereStudent='id_account='.$_SESSION['id'];
    $result=$db->get_list('student',$whereStudent);
    $row=mysqli_fetch_assoc($result);
    $id_student=$row['id'];

    $result=$db->get_list('extra_detail','id_student='.$id_student);
    $count=mysqli_num_rows($reuslt);
    if($count>0)
    {
        $_SESSION['error']='ban da tham gia hoat dong nay roi';
        header("Location:http://localhost/web_student/admin/extra");
    }

    $table=array('id_student'=>$id_student,'id_extra'=>$id_extra);
    $result=$db->insert('extra_detail',$table);
    if($result)
    {
        $_SESSION['success']='dang ky tham gia hoat dong thanh cong';
    }
    else
    {
        $_SESSION['error']='dang ky tham gia hoat dong khong thanh cong';
    }
    $db->dis_connect();
    header("Location:http://localhost/web_student/admin/extra");
}

?>