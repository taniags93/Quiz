<!DOCTYPE HTML>
<html>
<body>
<form method=POST action=EvaluateQuiz.php>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';

  $QuizID = $_GET['QuizID'];
  $QuizDao = new QuizDAO;
  $Quiz = $QuizDao->ReadOneQuiz($QuizID);
  echo "<H2> $Quiz->Title </H2>";
  echo "\n<input type=hidden name='MaximumScore' value=$Quiz->MaximumScore>\n";
  echo "\n<input type=hidden name='QuizID' value=$QuizID>\n";
  foreach ($Quiz->Questions as $Q ) {
    echo "\n<B> $Q->Title </B><br>";
    foreach ($Q->Options as $Option) {
      echo "\n\t<input type='checkbox' name='answers[]' value='".$Option->OptionID."'>".$Option->Title."<br>";
    }
  }
?>
  <input type="submit" name="Submit" value="Submit">
</form>
</body>
</html>
