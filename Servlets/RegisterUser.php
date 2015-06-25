<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/UserDAO.class.php';

$session = new Session;
$_SESSION["message"] = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $userdao = new UserDAO;
  $username=$_POST['username'];
  $password=$_POST['password'];
  if ($userdao->Add($username, $password))
   {
        $_SESSION["message"] = "User Added";
    	header("location: Welcome.php");
   }
  else
      	$_SESSION["message"] ="Failed to add user.";
}
?>
<style>
body, html {
    height: 100%;
    background-repeat: no-repeat;
    background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
    font-family: "Helvetica Neue", Helvetica;
    font-size: 60px;
}
#link{
	font-size:18px;
	color: rgb(255,255,255);
}
</style>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <form class="form-signing" style="max-width: 330px; margin-left : auto; margin-right : auto; margin-top: 60px;" method="post" >
            <img src="images/title.png" align="middle" >
            </br>
            <div class="form-group" style="height: 50px;">
            	<input type="text" name="username" class="form-control input-lg" placeholder="User Name"/><br />
            </div>
            <div class="form-group" style="height: 50px;">
            	<input type="password" name="password" class="form-control input-lg" placeholder="Password"/><br/>
            </div>
            <div class="form-group" style="height: 50px;">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Add User</button>
            </div>
            <div align="center"><a id="link" href=Login.php>Return to Login</a></div>
       		</br>
			<div style='font-size:20px; color: rgb(238,255,54);' align='center'><?=$_SESSION["message"];?></div>

       
        </form>
    </div>
    
</body>
</html>
