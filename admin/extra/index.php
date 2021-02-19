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
$db=new Database;
$db->connect();
$result=$db->get_list('extra','1 = 1');
$db->dis_connect();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Danh sach hoạt động</h1>
                    <?php include '../hepler/notify.php'; ?>

                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Extra</li>
                    </ol>
                </div>


            </div>

        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Acctivity</th>
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
                                <td><?= $row['acctivity']?></td>
                                <td>
                                    <?php 
                            if($row['status'])
                            {?>
                                    <span class="badge bg-primary">Hoạt động</span>
                                    <?php }else{ ?>
                                    <span class="badge bg-danger">Không kích hoạt</span>
                                    <?php }?>
                                </td>
                                
                                <td>
                                    <?php if($_SESSION['level']=='1') { ?>
                                    <a href=<?php echo 'edit.php?id='.$row['id']; ?> class="btn btn-warning">Sửa</a>
                                    <?php } ?>

                                    <?php if($_SESSION['level']=='1') { ?>
                                    <a href=<?php echo 'delete.php?id='.$row['id']; ?> class="btn btn-danger">Xóa</a>
                                    <?php } ?>

                                    <?php if(isset($_SESSION['level'])) { ?>
                                    <a href=<?php echo 'detail.php?id='.$row['id'];?> class="btn btn-info">Chi tiết</a>
                                    <?php } ?>

                                    <?php if($_SESSION['level']==3) { ?>
                                    <?php 
                                    $db=new Database;
                                    $db->connect();
                                    $result1=$db->get_list('student','id_account='.$_SESSION['id']);
                                    $check=0;
                                    if(mysqli_num_rows($result1)>0)
                                    {
                                        $row1=mysqli_fetch_assoc($result1);
                                        $result2=$db->get_list('extra_detail','id_student='.$row1['id']);
                                        if(mysqli_num_rows($result2)>0)
                                        {
                                            $check=1;
                                        }
                                    }
                                    $db->dis_connect();
                                    if($check==0)
                                    {?>
                                        <a href=<?php echo 'join.php?id_extra='.$row['id'];?> class='btn btn-success'>Tham gia</a>
                                    <?php }
                                    else
                                    {
                                        ?>
                                            <a class='btn btn-secondary'>Da tham gia</a>
                                        <?php 
                                    }
                                    } ?>
                                </td>
                               
                                
                            </tr>
                            <?php 
            }
        }
          ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</div>


<?php

include '../layout/footer.php';
?>