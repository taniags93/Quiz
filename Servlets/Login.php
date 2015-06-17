<?php
include($_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php');
$session = new Session;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $username=$_POST['username'];
  $password=$_POST['password'];
  if ($session->Login($username, $password))
    header("location: Welcome.php");
  else
    $error="Your Login Name or Password is invalid";
}
?>
<form action="" method="post">
<label>UserName :</label>
<input type="text" name="username"/><br />
<label>Password :</label>
<input type="password" name="password"/><br/>
<input type="submit" value=" Submit "/><br />
</form>
