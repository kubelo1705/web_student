<?php
session_start();
include './admin/hepler/Funtion.php';
include './admin/hepler/Database.php';
if(isset($_SESSION['username']))
{
  header("Location:".baseurl());
}

$frontend = baseUrl()."/public";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <h><?php echo isset($_SESSION['error'])?$_SESSION['error']:'';unset($_SESSION['error']);?></h>
</body>
</html>


<?php
$username=postInput('username');
$password=postInput('password');
if(isset($_POST['submit_login']))
{
  $check = true;
  if(empty(postInput('username')))
  {
    $check= false;
    $_SESSION['error_username']="vui long nhap usename";
  }
  if(empty(postInput('password')))
  {
    $check = false;
    $_SESSION['error_password']='vui long nhap password';
  }
  if($check)
  {

    $db=new Database;
    $db->connect();
    $result=$db->checkAccount($username,$password);
    $db->dis_connect();
    if($result)
    {
      $_SESSION['username']=$username;
      $_SESSION['id']=$result['id'];
      $_SESSION['level']=$result['level'];
      $_SESSION['success']='dang nhap thanh cong';
      header("Location:".baseurl());
    }
    else{
      $_SESSION['error_login']='dang nhap khong thanh cong';
    }
    
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $frontend ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo $frontend ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $frontend ?>/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
 
  <div class="card">
   
       <div class="login-logo">
           login
       </div>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username" value="<?= isset($username)?$username:'' ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" value="<?= isset($password)?$password:'' ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
         
        </div>
        <div class="mb-3">
            <ul>
            <?php  if(isset($_SESSION['error_login'])){?>
              <li><span style="color:red"><?php echo $_SESSION['error_login'];unset($_SESSION['error_login'])?></span></li>
            <?php } ?>
            <?php  if(isset($_SESSION['error_username'])){?>
              <li><span style="color:red"><?php echo $_SESSION['error_username'];unset($_SESSION['error_username'])?></span></li>
            <?php } ?>
            <?php if(isset($_SESSION['error_password'])){?>
              <li><span style="color:red"><?php echo $_SESSION['error_password'];unset($_SESSION['error_password'])?></span></li>
            <?php } ?>
            </ul>

        </div>
        <div class="row">
     
          <!-- /.col -->
          <div class="btn btn-block btn-primary">
            <input type="submit" class="btn btn-primary btn-block" name='submit_login' value="login">
          </div>
          <!-- /.col -->
        </div>
      </form>

     
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo $frontend ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $frontend ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $frontend ?>/dist/js/adminlte.min.js"></script>

</body>
</html>
