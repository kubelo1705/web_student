<?php
session_start();
include '../hepler/Funtion.php';
include '../hepler/Database.php';
$frontend=baseUrl().'/public';

if(!isset($_SESSION['level']))
{
    $_SESSION['error']='vui long dang nhap de thuc hien thao tac nay';
    header("Location:http://localhost/web_student/login.php");
  
}
else{
    if($_SESSION['level'] == '3' ){
        $_SESSION['error']='ban khong co quyen truy cap';
        header("Location: http://localhost/web_student/404.php");
       
    }
}
$id_account=$_GET['id'];
$db=new Database;
$db->connect();
$result=$db->get_list('student','id_account='.$id_account);
if(mysqli_num_rows($result)==0){
    $_SESSION['error']='thong tin khong hop le';
    header("Location:localhost/web_student/404.php");
  
}
else{
    $data=mysqli_fetch_assoc($result);
}
if(isset($_POST['edit'])){
  
    $error=[];
    $name=postInput('name');
    $phone=postInput('phone');
    $address=postInput('address');
    $birthday=postInput('birthday');
    $email=postInput('email');
    $family=postInput('family');
    $code_batch=postInput('code_batch');
    $mark=postInput('mark');
    $feedback=postInput('feedback');
    $id_teacher=postInput('id_teacher');
    $status=postInput('status');
    
    $check=0;
    
    if(!checkName($name))
    {
        $error['name']='vui long nhap ho ten chinh xac';
        $check=1;
    }
    if(!checkEmail($email))
    {
        $error['email']='nhap email bi loi';
        $check=1;
    }
    if(empty($name)){
        $error['name']='vui nhap day du ho ten';
        $check=1;
    }
    if(empty($phone)){
        $error['phone']='vui nhap sdt';
        $check=1;
    }
    if(empty($address)){
        $error['address']='vui nhap dia chi';
        $check=1;
    }
    if(empty($birthday)){
        $error['birthday']='vui nhap ngay thang nam sinh';
        $check=1;
    }
    if(empty($email)){
        $error['email']='vui nhap email';
        $check=1;
    }
    if(empty($family)){
        $error['family']='vui nhap thong tin gia dinh';
        $check=1;
    }
    if(empty($code_batch)){
        $error['code_batch']='vui nhap thong tin';
        $check=1;
    }
    if($check==0)
    {
        $where='id_account='.$id_account;
        $table_student=array('name'=>$name,'phone'=>$phone,'address'=>$address,'birthday'=>$birthday,'id_teacher'=>$id_teacher,'code_batch'=>$code_batch,'mark'=>$mark,'feedback'=>$feedback,'status'=>$status);
        $result=$db->update('student',$table_student,$where);
        $db->dis_connect();
        if($result)
        {
            $_SESSION['success']='da sua thanh cong';
            header('Location:'.urlStudent().'/index.php');
            die();
        }
        $_SESSION['error']='da xay ra loi khi sua';
        header('Location:'.urlStudent().'/edit.php?id='.$_GET['id']);
    }

}
   


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
                    <h1 class="m-0 text-dark">Sua thong tin hoc sinh</h1>
                    <?php include '../hepler/notify.php'; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student</li>
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
            <form action="<?php echo urlStudent().'/edit.php?id='.$id_account ?>" method="post" class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" value='<?php echo $data['name'] ?>'>
                                <p style='color:red'><?php if(isset($error['name'])) echo $error['name']; ?></p>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="int" class="form-control" name="phone"
                                    value='<?php echo $data['phone'] ?>'>
                                    <p style='color:red'><?php if(isset($error['phone'])) echo $error['phone']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" name="address"
                                    value='<?php echo $data['address'] ?>'>
                                    <p style='color:red'><?php if(isset($error['address'])) echo $error['address']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthday">Birthday:</label>
                                <input type="text" class="form-control" name="birthday"
                                    value='<?php echo $data['birthday'] ?>'>
                                    <p style='color:red'><?php if(isset($error['birthday'])) echo $error['birthday']; ?></p>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email"
                                    value='<?php echo $data['email'] ?>'>
                                    <p style='color:red'><?php if(isset($error['email'])) echo $error['email']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="family">Family:</label>
                                <input type="text" class="form-control" name="family"
                                    value='<?php echo $data['family'] ?>'>
                                    <p style='color:red'><?php if(isset($error['family'])) echo $error['family']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                                <label for="id_teacher">ID teacher:</label>
                                <select id="id_teacher" name='id_teacher' class='form-control' >
                                    <?php 
                                    $dataTeacher=new Database;
                                    $dataTeacher->connect();
                                    $result=$dataTeacher->get_list('teacher','1=1');
                                    while($row=mysqli_fetch_assoc($result))
                                    {?>
                                    <option value='<?php echo $row['id']; ?>' <?php if($data['id_teacher']==$row['id']) echo 'selected';  ?>  ><?php echo $row['name'] ?></option>
                                    <?php }
                                    $dataTeacher->dis_connect();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code_batch">Code batch:</label>
                                <input type="text" class="form-control" name="code_batch"
                                    value='<?php echo $data['code_batch'] ?>'>
                                    <p style='color:red'><?php if(isset($error['code_batch'])) echo $error['code_batch']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mark">Mark:</label>
                                <input type="text" class="form-control" name="mark" value='<?php echo $data['mark'] ?>'>
                                <p style='color:red'><?php if(isset($error['mark'])) echo $error['mark']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="feedback">Feedback:</label>
                                <input type="text" class="form-control" name="feedback"
                                    value='<?php echo $data['feedback'] ?>'>
                                    <p style='color:red'><?php if(isset($error['feedback'])) echo $error['feedback']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" <?php if($data['status']=='1') echo 'selected';  ?>>Hoạt động
                                    </option>
                                    <option value="0" <?php if($data['status']=='0') echo 'selected';  ?>>Không kích
                                        hoạt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name='edit' class="btn btn-info" value="Thay doi">
                </form>
            </div>
        </div>
    </section>
</div>


<?php

include '../layout/footer.php';
?>