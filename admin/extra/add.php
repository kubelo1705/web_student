<?php
session_start();
include '../hepler/Funtion.php';
$frontend=baseUrl().'/public';

include '../hepler/Database.php';
if(isset($_SESSION['level']))
{
    if(!$_SESSION['level']=='1')
    {
        $_SESSION['error']='ban khong co quyen truy cap';
        header("Location:".baseUrl());
      }
}
else
{
   $_SESSION['error']='vui long dang nhap de thuc hien thao tac nay';
    header("Location:http://localhost/web_student/login.php");
    die();
}
if(isset($_POST['add']))
{
    $error=[];
    $acctivity=postInput('acctivity');
    $content=postInput('content');
    $status=postInput('status');

    $db=new Database;
    $db->connect();
    $check=0;
    if(empty($acctivity))
    {
        $error['acctivity']='vui long day du ten hoat dong';
        $check=1;
    }
    if(empty($content))
    {
        $error['content']='vui long day du noi dung hoat dong';
        $check=1;
    }
    if(!$check)
    {
        $tableExtra=array('acctivity'=>$acctivity,'content'=>$content,'status'=>$status);
        $result=$db->insert('extra',$tableExtra);
        $db->dis_connect();
        if($result)
        {
            $_SESSION['success']='da them thanh cong';
        }
        else{
        $_SESSION['error']='da xay ra loi khi them';
        }
    }
}
include '../layout/header.php';
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="row">
                </div>
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Nhap thong tin hoạt động</h1>
                    <?php include '../hepler/notify.php'; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Extra</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-12">

                    </div>

                </div>

            </div>

        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="card card-default">
                <form action="<?php echo urlExtra().'/add.php' ?>" method="post" class="card-body">
                    <div class="form-group">
                        <label for="acctivity">Name:</label>
                        <input type="text" class="form-control" name="acctivity">
                    </div>

                    <div class="form-group">
                        <label for="content">Content:</label>
                        <textarea type="text" class="form-control" rows='4' name="content"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Hoạt động</option>
                            <option value="0">Không kích hoạt</option>
                        </select>
                    </div>

                    <input type="submit" name='add' class="btn btn-info" value="Thêm mới">
                </form>
            </div>
        </div>
    </section>
</div>


<?php

include '../layout/footer.php';
?>