<?php
session_start();
include '../hepler/Funtion.php';
include '../hepler/Database.php';
$frontend=baseUrl().'/public';
include '../layout/header.php';
  
if(!isset($_SESSION['level']))
{
    $_SESSION['error']='vui long dang nhap de thuc hien thao tac nay';
    header("Location:http://localhost/web_student/login.php");
    die();
}
else if($_SESSION['level'] != 1) {
    if($_SESSION['level'] == 3 || $_SESSION['id'] != $_GET['id']){
        $_SESSION['error']='ban khong co quyen truy cap';
        header("Location:http://localhost/web_student/404.php");
        die();
    }
    
}
else
{

}
$id_account=$_GET['id'];
$db=new Database;
$db->connect();
$result=$db->get_list('teacher','id_account='.$id_account);
if(mysqli_num_rows($result)==0){
    $_SESSION['error']='thong tin khong hop le';
    header("Location:localhost/web_student/404.php");
    die();
}
else{
    $data=mysqli_fetch_assoc($result);
    // echo "<pre>";
    // var_dump($data);
    // echo "</pre>";
   
}
$db->dis_connect();

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="row">
                </div>
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Thong tin giao vien</h1>
                    <?php include '../hepler/notify.php'; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Teacher</li>
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
                <form action="<?php echo urlTeacher().'/edit_sol.php?id='.$id_account ?>" method="post"
                    class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <label class="form-control"><?php echo $data['name'] ?></label>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <label class="form-control"><?php echo $data['phone'] ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <label class="form-control"><?php echo $data['email'] ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthday">Birthday:</label>
                                <label class="form-control"><?php echo $data['birthday'] ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="education">Education:</label>
                                <label class="form-control"><?php echo $data['education'] ?></label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience">Experience:</label>
                                <label class="form-control"><?php echo $data['experience'] ?></label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <label class="form-control"><?php echo $data['address'] ?></label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="family">Family:</label>
                                <label class="form-control" rows='4'><?php echo $data['family'] ?></label>
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
                </form>
            </div>
        </div>
    </section>
</div>


<?php

include '../layout/footer.php';
?>