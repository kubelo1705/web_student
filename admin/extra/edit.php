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
else if($_SESSION['level'] != 1) {
        $_SESSION['error']='ban khong co quyen truy cap';
        header("Location:http://localhost/web_student/404.php");
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
if(isset($_POST['edit']))
{
    $error=[];
    $acctivity=$_POST['acctivity'];
    $content=$_POST['content'];
    $status=$_POST['status'];
    $check=0;
    if(empty($acctivity))
    {
        $error['acctivity']='vui long nhap ten hoat dong';
        $check=1;
    }
    if(empty($content))
    {
        $error['content']='vui long nhap noi dung hoat dong';
        $check=1;
    }
    if($check==0)
    {
        $where='id='.$id;
        $table_extra=array('acctivity'=>$acctivity,'content'=>$content,'status'=>$status);
        $result=$db->update('extra',$table_extra,$where);
        $db->dis_connect();
        if($result)
        {
            $_SESSION['success']='da sua thanh cong';
            header('Location:'.urlExtra().'/index.php');
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
                    <h1 class="m-0 text-dark">Sua thong tin ngoai khoa</h1>
                    <?php include '../hepler/notify.php'; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">extra</li>
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
                <form action="<?php echo urlextra().'/edit.php?id='.$id ?>" method="post" class="card-body">
                <div class="form-group">
                        <label for="acctivity">Name:</label>
                        <input type="text" class="form-control" name="acctivity" value='<?php echo $data['acctivity'] ?>'>
                        <p style='color:red'><?php if(isset($error['acctivity'])) echo $error['acctivity']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="content">Content:</label>
                        <textarea type="text" class="form-control" rows='4' name="content"><?php echo $data['content'] ?></textarea>
                        <p style='color:red'><?php if(isset($error['content'])) echo $error['content']; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="form-control">
                                    <option value="1" <?php if($data['status']=='1') echo 'selected';  ?>>Hoạt động
                                    </option>
                                    <option value="0" <?php if($data['status']=='0') echo 'selected';  ?>>Không kích
                                        hoạt</option>
                        </select>
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