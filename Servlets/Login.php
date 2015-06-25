<?php
				include($_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php');
				$session = new Session;
				if($_SERVER["REQUEST_METHOD"] == "POST") {
 				$username=$_POST['username'];
  				$password=$_POST['password'];
  					if ($session->Login($username, $password))
    					header("location: Welcome.php");
  					else{
    					$_SESSION["message"]="Your Login Name or Password is invalid";
    				}
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
                <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
            </div>
            <div align="center"><a id="link" href=RegisterUser.php>Register User</a></div>
			<div align="center"><a id="link" href=AddQuiz.php>Upload Quiz</a></div>
			</br>
			<div style='font-size:20px; color: rgb(238,255,54);' align='center'><?=$_SESSION["message"];?></div>

        </form>
    </div>
    
</body>
</html>
