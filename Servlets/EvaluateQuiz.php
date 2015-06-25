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
#score{
	font-family: "Helvetica Neue", Helvetica;
	font-size:34px;
}
</style>
<!DOCTYPE HTML>
<html>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<body>
	<div class="modal-dialog">
			<div align="right"><a class="btn btn-info" style="width: 100px"
				href=Welcome.php>Home</a></div>
			<div align="center"><img src="images/title-sm.png"></div>
			<form class="welcome" style="max-width: 1200px; margin-left : auto; margin-right : auto; margin-top: 10px; height: 400px;" method="post" >
				</br>
				</br>
				</br>
				<?php
					require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
					require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
					$session = new Session;

					$Score = 0;
  					$QuizID = $_POST['QuizID'];
  					$TestID = $_POST['TestID'];
  					$QuizDao = new QuizDAO;
  					$Score = $QuizDao->GetTestResult($TestID);
            if ($Score < 0)
              $Score = 0;
  					echo "<div align='center' id='score'>You scored ".$Score. " %</div>";
  					echo "</br></br></br></br>";
  					echo "<div align='center' ><a class='btn btn-info' style='width: 200px' href='TrackProgress.php?QuizID=$QuizID'>Track Progress</a></div>";
			?>
			</form>
	</div>

</body>

</html>
