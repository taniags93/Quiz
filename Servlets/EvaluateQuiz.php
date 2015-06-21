<!DOCTYPE HTML>
<html>
<body>


<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
$session = new Session;

  $Score = 0;
  $StudentID = $_SESSION['userid'];
  $QuizID = $_POST['QuizID'];
  $TestID = $_POST['TestID'];
  $QuizDao = new QuizDAO;
  if(isset($_POST['Submit'])) {
    foreach($_POST['answers'] as $OptionID) {
      $QuizDao->RecordTestAnswers($TestID, $OptionID);
    }
  $Score = $QuizDao->GetTestResult($TestID);
  echo "You scored ".$Score. " out of ";
  echo "<br><a href=TrackProgress.php?QuizID=$QuizID>Track progress of this Quiz</a><br>";
  }
?>

</body>
</html>
