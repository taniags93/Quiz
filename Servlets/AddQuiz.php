<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';

  $session = new Session;

  if(isset($_FILES) && isset ($_FILES["fileToUpload"])) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'].'/Quiz/Workspace/';
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    if(isset($_POST["submit"])) {
      $quizdao = new QuizDAO;
      $quizdao->AddFromFile($_POST['title'], $_POST['duration'], $_FILES["fileToUpload"]["tmp_name"]);
      header("location: Welcome.php");
    }
  }
?>
<!DOCTYPE html>
<html>
<body>

<form action="AddQuiz.php" method="post" enctype="multipart/form-data">
    <input type="text" name="title" id="title" placeholder="Test Title"><br>
    <input type="text" name="duration" id="duration" placeholder="Test Duration"> <br>
    <input type="file" name="fileToUpload" id="fileToUpload"> <br>
    <input type="submit" value="Upload Quiz" name="submit">
</form>

</body>
</html>
