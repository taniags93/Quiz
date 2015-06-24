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
<style>
body, html {
    height: 100%;
    background-repeat: no-repeat;
    background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
    font-family: "Helvetica Neue", Helvetica;
    font-size: 60px;
}
</style>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <form class="form-signing" style="max-width: 330px; margin-left : auto; margin-right : auto; margin-top: 60px;" method="post" >
            <img src="title.png" align="middle" >
            </br>
            <div class="form-group" style="height: 50px;">
            	<input type="text" name="username" class="form-control input-lg" placeholder="User Name"/><br />
            </div>
            <div class="form-group" style="height: 50px;">
            	<input type="password" name="password" class="form-control input-lg" placeholder="Password"/><br/>
            </div>
            <div class="form-group" style="height: 50px;">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
            </div>
        </form>
    </div>
    <a href=RegisterUser.php>Register user</a>
	<a href=AddQuiz.php>AddQuiz</a>
</body>
</html>
