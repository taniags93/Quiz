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
  $QuizDao = new QuizDAO;
  if(isset($_POST['Submit'])) {
    foreach($_POST['answers'] as $OptionID) {
      $Score += $QuizDao->ReadOptionScore($OptionID);
    }
  }
  $QuizDao->saveQuizResultToTranscript($StudentID, $QuizID, $Score / $_POST['MaximumScore']);
  echo "You scored ".$Score. " out of ".$_POST['MaximumScore'];
  echo "<br><a href=TrackProgress.php?QuizID=$QuizID>Track progress of this Quiz</a><br>";

?>

</body>
</html>
