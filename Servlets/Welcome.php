<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';

$session = new Session;
if (!$session->isValid())
  header("Location: Login.php");
?>

<body>
<h1> Welcome
  <?php
  if(isset($_SESSION) && isset($_SESSION['user']) && isset($_SESSION['userid']))
    echo "<H2>Hello ".$_SESSION['user']."</H2>";
  $quizdao = new QuizDAO;
  $quizzes = $quizdao->ReadAllQuiz();
  foreach ($quizzes as $QuizID => $QuizTitle) {
      echo "<a href=TakeQuiz.php?QuizID=$QuizID>$QuizTitle</a><br>";
  }

  ?></h1>
<a href=Logout.php>Logout</a>
<a href=RegisterUser.php>Register user</a>
<a href=AddQuiz.php>AddQuiz</a>

</body>
