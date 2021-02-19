<?php
session_start();
include '../hepler/Funtion.php';
$frontend=baseUrl().'/public';
include '../layout/header.php';
include '../hepler/Database.php';

if(!isset($_SESSION['level']))
{
    $_SESSION['error']='vui long dang nhap de thuc hien thao tac nay';
    header("Location:http://localhost/web_student/login.php");
    die();
}
else if($_SESSION['level']==3)
{
    $where='id_account='.$_SESSION['id'];
}
else{
    $where='1=1';
}
$db=new Database;
$db->connect();
$result=$db->get_list('student',$where);
$db->dis_connect();

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Danh sach hoc sinh</h1>
                    <?php include '../hepler/notify.php'; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <?php include '../hepler/notify.php'; ?>
            <div class="row">
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result))
            { ?>
                            <tr>
                                <td><?= $row['id']?></td>
                                <td><?= $row['name']?></td>
                                <td><?=$row['phone']?></td>
                                <td><?=$row['address']?></td>
                                <td><?=$row['email']?></td>
                                <td>
                                    <?php 
                            if($row['status'])
                            {?>
                                    <span class="badge bg-primary">Hoạt động</span>
                                    <?php }else{ ?>
                                    <span class="badge bg-danger">Không kích hoạt</span>
                                    <?php }?>
                                </td>
                                <?php if($_SESSION['level']=='1' || $_SESSION['id']==$row['id_account']) { ?>
                                <td>
                                    <a href=<?php echo 'edit.php?id='.$row['id_account']; ?>
                                        class="btn btn-warning">Sửa</a>

                                    <?php } ?>
                                    <?php if($_SESSION['level']=='1') { ?>

                                    <a href=<?php echo 'delete.php?id='.$row['id_account']; ?>
                                        class="btn btn-danger">Xóa</a>
                                    <?php } ?>
                                    <?php if($_SESSION['level']=='1' || $_SESSION['id']==$row['id_account']) { ?>
                                    <a href=<?php echo 'detail.php?id='.$row['id_account']; ?> class="btn btn-info">Chi
                                        tiet</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php 
            }
         } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</div>
<?php

include '../layout/footer.php';
?>