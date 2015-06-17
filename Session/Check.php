<?php
include($_SERVER['DOCUMENT_ROOT'].'/Quiz/Db/config.php');
print getcwd();
session_start();
$user_check=$_SESSION['login_user'];

$ses_sql=mysqli_query($db,"select username from Student where username='$user_check' ");

$row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

$login_session=$row['username'];

if(!isset($login_session))
{
header("Location: Session/Login.php");
}
?>
