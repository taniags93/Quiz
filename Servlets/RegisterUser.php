<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/UserDAO.class.php';

$session = new Session;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $userdao = new UserDAO;
  $username=$_POST['username'];
  $password=$_POST['password'];
  if ($userdao->Add($username, $password))
    header("location: Welcome.php");
  else
    $error="User add failed";
}
?>
<form action="" method="post">
<label>UserName :</label>
<input type="text" name="username"/><br />
<label>Password :</label>
<input type="password" name="password"/><br/>
<input type="submit" value=" Add this user "/><br />
</form>
