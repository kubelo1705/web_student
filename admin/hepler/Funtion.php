<?php 
function postInput(string $param)
{
    return isset($_POST[$param])?$_POST[$param]:'';
}
function getInput(string $param)
{
    return isset($_GET[$param])?$_GET[$param]:'';
}

function baseUrl()
{
    return $url="http://localhost/web_student/admin/";
}

function urlTeacher()
{
    return baseUrl().'teacher';
}
function urlAddTeacher()
{
    return baseUrl().'teacher/add.php';
}
function urlEditTeacher()
{
    return baseUrl().'teacher/edit.php';
}
function urlDelteTeacher()
{
    return baseUrl().'teacher/delete.php';
}

function urlStudent()
{
    return baseUrl().'student';
}
function urlAddStudent()
{
    return baseUrl().'student/add.php';
}
function urlDelteStudent()
{
    return baseUrl().'student/delete.php';
}
function urlEditStudent()
{
    return baseUrl().'student/edit.php';
}

function urlExtra()
{
    return baseUrl().'extra';
}
function urlAddExtra()
{
    return baseUrl().'extra/add.php';
}
function urlDeleteExtra()
{
    return baseUrl().'extra/delete.php';
}
function urlEditExtra()
{
    return baseUrl().'extra/edit.php';
}

function urlNotify()
{
    return baseUrl().'helper/notify.php';
}

function checkAdmin()
{
    return ($_SESSION['level']==1)?1:0;
}
function checkTeacher()
{
    return ($_SESSION['level']==2)?1:0;
}
function checkStudent()
{
    return ($_SESSION['level']==3)?1:0;
}

function checkEmail(string $email)
{
    return (filter_var($email, FILTER_VALIDATE_EMAIL));
}

function checkName(string $name)
{
    if(substr($name,0,1)==' ')
        return 0;
    return (preg_match("/^[a-zA-Z-' ]*$/",$name));
}
function checkPassword(string $password)
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    return ($uppercase && $lowercase && $number && $specialChars);
}

function checkJpg(string $fileName,string $fileType,string $fileError,int $fileSize)
{
    $success=0;
    session_start();
    if(postInput('uploadImage'))
    {
        if($fileError==0)
        {
            echo 0;
        $allow=array('jpg','jpeg','bmp');
        $fileExt=explode('.',$fileName);
        $fileAtualExt=strtolower(end($fileExt));
        if(in_array($fileAtualExt,$allow))
        {
            $allowSize= 50000;
            if($fileSize<$allowSize)
            {
                $success=1;
            }
            else
            {
                $_SESSION['error']= "ban khong the upload file qua lon";
            }
        }
        else
        {
            $_SESSION['error']= "ban khong the upload file ".$fileType;
        }
        }
        else{
            $_SESSION['error']= "upload file bi loi";
        }
    }
    else
        $_SESSION['error']= "ban chua upload file";
    return $success;
}
function uploadJpg(string $fileTmp,string $fileDes)
{
    if(move_uploaded_file($fileTmp,$fileDes))
    {
        $_SESSION['success']="ban da upload file thanh cong";
        return 1;
    }
    return 0;
}
function setImageDes(int $idUser,int $levelUser)
{
    $fileName='image_';
    if($levelUser==1)
        $fileName.='admin_'.$idUser;
    else if($levelUser==2)
        $fileName.='teacher_'.$idUser;
    else if($levelUser==3)
        $fileName.='student_'.$idUser;
    $fileDes='upload/'.$fileName;
    return $fileDes;
}






// check jpg 
//upload file into folder
?>