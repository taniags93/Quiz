<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';

$session = new Session;
if (!$session->isValid())
  header("Location: Login.php");
?>
<style>
body, html {
    height: 100%;
    background-repeat: no-repeat;
    background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
    font-family: "Helvetica Neue", Helvetica;
}

form {
	background: rgb(240,248,255);
	border-radius: 20px ;
}

H2,td {
	text-align: center;
}
</style>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
	<body>

		<div class="modal-dialog">
			<div align="right"><a class="btn btn-info" style="width: 100px"
				href=Logout.php>Logout</a></div>
			<div align="center"><img src="images/title-sm.png"></div>
       	 	<form class="welcome" style="max-width: 1200px; margin-left : auto; margin-right : auto; margin-top: 10px; height: 400px;" method="post" >
           	 	</br>
           	 	<table class="table table-hover">
           	 		<tr>
    					<th><div align="center">Quiz<div></th>
  					</tr>
           	 	<?php
  					if(isset($_SESSION) && isset($_SESSION['user']) && isset($_SESSION['userid']))
   			 			echo "<H2> Welcome ".$_SESSION['user']."</H2>";
  					$quizdao = new QuizDAO;
  					$quizzes = $quizdao->ReadAllQuiz();
  					echo "</br></br>";
  					foreach ($quizzes as $QuizID => $QuizTitle) {
      					echo "<tr><td><a href=TakeQuiz.php?QuizID=$QuizID>$QuizTitle</a></td></tr>";
  				}
  				?>	
  				</table>		
        	</form>
    	</div>
	</body>
</html>

