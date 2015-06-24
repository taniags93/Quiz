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

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<body>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';

  $session = new Session;
  $SubjectString = "";

  if(isset($_FILES) && isset ($_FILES["fileToUpload"])) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'].'/Quiz/Workspace/';
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    if(isset($_POST["submit"])) {
      $quizdao = new QuizDAO;
      $quizdao->AddFromFile($_POST['title'], $_POST['duration'],$_POST['subjectid'], $_FILES["fileToUpload"]["tmp_name"]);
      header("location: Login.php");
    }
  }
  else {
    $quizdao = new QuizDAO;
    $Subject = $quizdao->GetAllSubjects();
    foreach ($Subject as $key => $value ) {
      $SubjectString .= "<option value='$key'>$value</option>";
    }
  }
?>
<div class="modal-dialog">
			<div align="right"><a class="btn btn-info" style="width: 100px"
				href=Login.php>Login</a></div>
			<div align="center"><img src="images/title-sm.png"></div>
       	 	<form action="AddQuiz.php" enctype="multipart/form-data" class="welcome" style="max-width: 1200px; margin-left : auto; margin-right : auto; margin-top: 10px; height: 400px;" method="post" >
           	 	</br>
           	 	</br>
           	 	</br>
           	 	<div align="center" style="height: 50px;">
           	 		<input style="width: 334px;" class="form-control input" type="text" name="title" id="title" placeholder="Test Title" required>
           	 	</div>
    			<div align="center"><select style="width: 334px;" name="subjectid" class="form-control">
      				<?php echo $SubjectString ?>
    			</select></div>
    			</br>
    			<div align="center" style="height: 50px;">
    				<input style="width: 334px;" class="form-control input" type="text" name="duration" id="duration" placeholder="Test Duration" required> <br>
    			</div>
    			<div align="center" style="height: 50px;">
    				<input style="width: 334px;" type="file" name="fileToUpload" id="fileToUpload" required> <br>
    			</div>
    			<div align="center" style="height: 50px;">
    			<input style="width: 334px;" class="btn btn-primary btn-lg btn-block" type="submit" value="Upload Quiz" name="submit">
        		</div>
        	</form>
    	</div>


</body>
</html>
