<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
  $session = new Session;
  $QuizID = $_GET['QuizID'];
  $QuizDao = new QuizDAO;
  $StudentID = $_SESSION['userid'];
  $Quiz = $QuizDao->ReadOneQuiz($QuizID);
  $TestID = $QuizDao->StartTakingQuiz($StudentID, $QuizID);

?>

<!DOCTYPE HTML>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {

      });
    </script>
  </head>
<body>
  <form method=POST action=EvaluateQuiz.php>
  
    <H2><?= $Quiz->Title ?></H2>
    <input type=hidden name='<?= $QuizID; ?>' value=$QuizID>
    <input type=hidden name='<?= $TestID; ?>' value=$TestID>

<?php foreach ($Quiz->Questions as $Q ) : ?>
    <B> <?= $Q->Title ?></B><br>
<?php   foreach ($Q->Options as $Option) : ?>
    <input type='checkbox' name='answers[]' value='<?= $Option->OptionID; ?>'><?=$Option->Title?><br>
<?php endforeach; endforeach; ?>
    <input type="submit" name="Submit" value="Submit">
  </form>

</body>
</html>
