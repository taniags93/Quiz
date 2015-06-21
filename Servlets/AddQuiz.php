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
      header("location: Welcome.php");
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
<!DOCTYPE html>
<html>
<body>

<form action="AddQuiz.php" method="post" enctype="multipart/form-data">
    <input type="text" name="title" id="title" placeholder="Test Title" required><br>
    <select name="subjectid">
      <?php echo $SubjectString ?>
    </select>
    <input type="text" name="duration" id="duration" placeholder="Test Duration" required> <br>
    <input type="file" name="fileToUpload" id="fileToUpload" required> <br>
    <input type="submit" value="Upload Quiz" name="submit">
</form>

</body>
</html>
