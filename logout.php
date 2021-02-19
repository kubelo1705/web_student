<?php 

session_start();
session_destroy();
header("Location:http://localhost/web_student/login.php");

?>