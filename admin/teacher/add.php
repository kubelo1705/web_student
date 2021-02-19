<?php
session_start();
  include '../hepler/Funtion.php';
  $frontend=baseUrl().'/public';
 
  include '../hepler/Database.php';
  
  if(isset($_SESSION['level']))
  {
      if($_SESSION['level']!=1)
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


  $db=new Database;
  if(isset($_POST['add'])){
    $error = [];
    $name=postInput('name');
    $phone=postInput('phone');
    $address=postInput('address');
    $birthday=postInput('birthday');
    $email=postInput('email');
    $family=postInput('family');
    $education=postInput('education');
    $experience=postInput('experience');
    
    $username=postInput('username');
    $password=postInput('password');
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
    if(!checkPassword($password))
    {
        $error['password']='password khong hop le';
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
    if(empty($education)){
        $error['education']='vui nhap thong tin';
        $check=1;
    }
    if(empty($experience)){
        $error['experience']='vui nhap thong tin';
        $check=1;
    }
    if(empty($username)){
        $error['username']='vui nhap username';
        $check=1;
    }
    else{
        $result=$db->get_list('account','username='.$username);
        $count=mysqli_num_rows($result);
        if($count>0)
        {
            $error['username']='username da co nguoi su dung';
            $check=1;
        }
    }
    if(empty($password)){
        $error['password']='vui nhap password';
        $check=1;
    }   
}
if(isset($check) && $check==0){

    $db->connect();
    $table_accTeacher=array('username'=>$username,'password'=>$password,'status'=>$status,'level'=>'2');
    $result=$db->insert('account',$table_accTeacher);
    if($result)
    {
        $result=$db->get_list('account',"username="."'".$username."'");
        $account=mysqli_fetch_assoc($result);
        $id_account=$account['id'];
        $table_teacher=array('name'=>$name,'phone'=>$phone,'address'=>$address,'birthday'=>$birthday,'email'=>$email,'family'=>$family,'education'=>$education,'experience'=>$experience,'id_account'=>$id_account,'status'=>$status);
        $result=$db->insert('teacher',$table_teacher);
    }
   
    if($result)
    {
        $_SESSION['success']='da them thanh cong';
        header('Location:'.urlTeacher().'/index.php');
        die();
    }
    $_SESSION['error']='da xay ra loi khi them';
    
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
                    <h1 class="m-0 text-dark">Nhap thong tin giao vien</h1>
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
                <form action="<?php echo urlTeacher().'/add.php' ?>" method="post" class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" value="<?php if(isset($name)) echo $name;?>" name="name">
                                <p style='color:red'><?php if(isset($error['name'])) echo $error['name']; ?></p>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="int" class="form-control" value="<?php if(isset($phone)) echo $phone;?>" name="phone">
                                <p style='color:red'><?php if(isset($error['phone'])) echo $error['phone']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">username:</label>
                                <input type="text" class="form-control" value="<?php if(isset($username)) echo $username;?>" name="username">
                                <p style='color:red'><?php if(isset($error['username'])) echo $error['username']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">password:</label>
                                <input type="password" class="form-control" value="<?php if(isset($password)) echo $password;?>" name="password">
                                <p style='color:red'><?php if(isset($error['password'])) echo $error['password']; ?></p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" value="<?php if(isset($email)) echo $email;?>" class="form-control" name="email">
                                <p style='color:red'><?php if(isset($error['email'])) echo $error['email']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthday">Birthday:</label>
                                <input type="text" value="<?php if(isset($birthday)) echo $birthday;?>" class="form-control" name="birthday">
                                <p style='color:red'><?php if(isset($error['birthday'])) echo $error['birthday']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="education">Education:</label>
                                <input type="text" value="<?php if(isset($education)) echo $education;?>" class="form-control" name="education">
                                <p style='color:red'><?php if(isset($error['education'])) echo $error['education']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience">Experience:</label>
                                <input type="text" class="form-control" value="<?php if(isset($experience)) echo $experience;?>" name="experience">
                                <p style='color:red'><?php if(isset($error['experience'])) echo $error['experience']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea type="text" class="form-control" rows="4" cols="50" name="address"><?php if(isset($address)) echo $address;?></textarea>
                                <p style='color:red'><?php if(isset($error['address'])) echo $error['address']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="family">Family:</label>
                                <textarea type="text" class="form-control" rows="4" cols="50" name="family"><?php if(isset($family)) echo $family;?></textarea>
                                <p style='color:red'><?php if(isset($error['family'])) echo $error['family']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="status">Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" <?php if(isset($status)) if($status=='1') echo 'selected';  ?>>Hoạt động</option>
                                    <option value="0" <?php if(isset($status)) if($status=='0') echo 'selected';  ?>>Không kích hoạt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="add" class="btn btn-info" value="Thêm mới">
                </form>
            </div>
        </div>
    </section>
</div>


<?php

include '../layout/footer.php';
?>