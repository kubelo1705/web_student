<?php
session_start();
include '../hepler/Funtion.php';
include '../hepler/Database.php';
$frontend=baseUrl().'/public';

  
if(!isset($_SESSION['level']))
{
    $_SESSION['error']='vui long dang nhap de thuc hien thao tac nay';
    header("Location:http://localhost/web_student/login.php");
    die();
}

$id=$_GET['id'];
$db=new Database;
$db->connect();
$result=$db->get_list('extra','id='.$id);
if(mysqli_num_rows($result)==0){
    $_SESSION['error']='thong tin khong hop le';
    header("Location:localhost/web_student/404.php");
    die();
}
else{
    $data=mysqli_fetch_assoc($result);
}


$resultExtra=$db->get_list('extra_detail','id_extra='.$id);
$count=mysqli_num_rows($result);
$db->dis_connect();
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
                    <h1 class="m-0 text-dark">Thong tin ngoai khoa</h1>
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="acctivity">Ten:</label>
                            <label class="form-control"><?php echo $data['acctivity'] ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="content">Noi dung:</label>
                            <label class="form-control"><?php echo $data['content'] ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <label
                                class="form-control"><?php if($data['status']==1) echo 'Hoạt động'; else echo 'Không hoạt động'?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">So luong hoc sinh tham gia:</label>
                            <label
                                class="form-control"><?php echo $count;?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php

include '../layout/footer.php';
?>