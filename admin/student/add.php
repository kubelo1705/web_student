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
          die();
      }
  }
  else
  {
      $_SESSION['error']='vui long dang nhap de thuc hien thao tac nay';
      header("Location:http://localhost/web_student/login.php");
      die();
  }
  $db=new Database;
if(isset($_POST['add']))
{
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
    if(empty($code_batch)){
        $error['code_batch']='vui nhap thong tin';
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
    
    if($check==0){
        
        $db->connect();
        $table_accStudent=array('username'=>$username,'password'=>$password,'status'=>$status,'level'=>'3');
        $result=$db->insert('account',$table_accStudent);
        if($result)
        {
            $result=$db->get_list('account',"username="."'".$username."'");
            $account=mysqli_fetch_assoc($result);
            $id_account=$account['id'];
            $table_student=array('name'=>$name,'phone'=>$phone,'address'=>$address,'birthday'=>$birthday,'email'=>$email,'family'=>$family,'mark'=>$mark,'feedback'=>$feedback,'code_batch'=>$code_batch,'id_teacher'=>$id_teacher,'id_account'=>$id_account,'status'=>$status);
            $result=$db->insert('student',$table_student);
        }
        if($result)
        {
            $_SESSION['success']='da them thanh cong';
            header('Location:'.urlStudent().'/index.php');
            die();
        }
        $_SESSION['error']='da xay ra loi khi them';
        
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
                    <h1 class="m-0 text-dark">Nhap thong tin hoc sinh</h1>
                    <?php include '../hepler/notify.php'; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Student</li>
                        <li class="breadcrumb-item"><a href="http://localhost/web_student/admin/student/add.php">Them
                                moi</a></li>
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
                <form action="<?php echo urlstudent().'/add.php' ?>" method="post" class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" value="<?php if(isset($name)) echo $name;?>"
                                    name=" name">
                                <p style='color:red'><?php if(isset($error['name'])) echo $error['name']; ?></p>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="int" class="form-control" value="<?php if(isset($phone)) echo $phone;?>"
                                    name=" phone">
                                <p style='color:red'><?php if(isset($error['phone'])) echo $error['phone']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">username:</label>
                                <input type="text" class="form-control"
                                    value="<?php if(isset($username)) echo $username;?>" name=" username">
                                <p style='color:red'><?php if(isset($error['username'])) echo $error['username']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">password:</label>
                                <input type="password" class="form-control"
                                    value="<?php if(isset($password)) echo $password;?>" name=" password">
                                <p style='color:red'><?php if(isset($error['password'])) echo $error['password']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control"
                                    value="<?php if(isset($address)) echo $address;?>" name=" address">
                                <p style='color:red'><?php if(isset($error['address'])) echo $error['address']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthday">Birthday:</label>
                                <input type="text" class="form-control"
                                    value="<?php if(isset($birthday)) echo $birthday;?>" name=" birthday">
                                <p style='color:red'><?php if(isset($error['birthday'])) echo $error['birthday']; ?></p>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" value="<?php if(isset($email)) echo $email;?>"
                                    name=" email">
                                <p style='color:red'><?php if(isset($error['email'])) echo $error['email']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="family">Family:</label>
                                <input type="text" class="form-control" value="<?php if(isset($family)) echo $family;?>"
                                    name="family">
                                <p style='color:red'><?php if(isset($error['family'])) echo $error['family']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code_batch">Code batch:</label>
                                <input type="text" class="form-control"
                                    value="<?php if(isset($code_batch)) echo $code_batch;?>" name="code_batch">
                                <p style='color:red'><?php if(isset($error['code_batch'])) echo $error['code_batch']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mark">Mark:</label>
                                <input type="text" class="form-control" value="<?php if(isset($mark)) echo $mark;?>"
                                    name="mark">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="feedback">Feedback:</label>
                        <textarea type="text" class="form-control" rows='4' cols='50'
                            name="feedback"><?php if(isset($feedback)) echo $feedback;?></textarea>
                    </div>
                    <!-- <div class="row">
                        
                        <div class="col-xs-5">
                            <select name="from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
                                <option value="1">Item 1</option>
                                <option value="2">Item 5</option>
                                <option value="2">Item 2</option>
                                <option value="2">Item 4</option>
                                <option value="3">Item 3</option>
                            </select>
                        </div>

                        <div class="col-xs-2">
                            <button type="button" id="multiselect_rightAll" class="btn btn-block"><i
                                    class="glyphicon glyphicon-forward"></i></button>
                            <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i
                                    class="glyphicon glyphicon-chevron-right"></i></button>
                            <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i
                                    class="glyphicon glyphicon-chevron-left"></i></button>
                            <button type="button" id="multiselect_leftAll" class="btn btn-block"><i
                                    class="glyphicon glyphicon-backward"></i></button>
                        </div>

                        <div class="col-xs-5">
                            <select name="to[]" id="multiselect_to" class="form-control" size="8"
                                multiple="multiple"></select>
                        </div>
                        <div class="form-group">
                            <label>Chon hoat dong</label>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_teacher">ID teacher:</label>
                                <select id="id_teacher" name='id_teacher' class='form-control'>
                                    <?php 
                                    $data=new Database;
                                    $data->connect();
                                    $result=$data->get_list('teacher','1=1');
                                    while($row=mysqli_fetch_assoc($result))
                                    {?>
                                    <option value='<?php echo $row['id']; ?>'
                                        <?php if(isset($id_teacher)) if($id_teacher==$row['id']) echo 'selected';  ?>>
                                        <?php echo $row['name'] ?></option>
                                    <?php }
                                    $data->dis_connect();
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" <?php if(isset($status)) if($status=='1') echo 'selected';  ?>>
                                        Hoạt động</option>
                                    <option value="0" <?php if(isset($status)) if($status=='0') echo 'selected';  ?>>
                                        Không kích hoạt</option>
                                </select>
                            </div>
                        </div>
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
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#multiselect').multiselect();
});
</script>