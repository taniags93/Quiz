<?php

class QuizDAO {

  private $db;

  public function __construct() {
    require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Db/config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Model/Quiz.class.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Model/Option.class.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Model/Question.class.php';
    $this->db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  }

  public function Add($Queries) {
    foreach ($Queries as $Query) {
      $this->db->query($Query);
    }
  }

  public function ReadOneQuiz($QuizID) {
    $Quiz = new Quiz;
    $Question = new Question;
    $sql = "SELECT Title, Duration, MaximumScore FROM Quiz where QuizID=$QuizID;";
    $records = mysqli_query($this->db, $sql);
    while ( $row = mysqli_fetch_assoc($records) ) {
      $Quiz->Duration = $row['Duration'];
      $Quiz->Title = $row['Title'];
      $Quiz->MaximumScore = $row['MaximumScore'];
      $Quiz->Questions = $this->ReadAllQuestion($QuizID);
    }
    return $Quiz;
  }

  public function ReadAllQuiz() {
    $Results = array();
    $sql = "SELECT QuizID, Title FROM Quiz;";
    $records = mysqli_query($this->db, $sql);
    while ( $row = mysqli_fetch_assoc($records) ) {
      $Results[$row['QuizID']] = $row['Title'];
    }
    return $Results;
  }

  public function ReadAllQuestion($QuizID) {
    $Results = array();
    $sql = "SELECT QuestionID, Title FROM Question where QuizID=$QuizID;";
    $records = mysqli_query($this->db, $sql);
    while ( $row = mysqli_fetch_assoc($records) ) {
      $Question = new Question;
      $QuestionID = $row['QuestionID'];
      $Question->setQuestion($row['Title']);
      $Question->Options = $this->ReadAllOption($QuestionID);
      array_push($Results, $Question);
    }
    return $Results;
  }

  public function ReadAllOption($QuestionID) {
    $Results = array();
    $sql = "SELECT Score, Title, OptionID FROM Options Where QuestionID=$QuestionID;";
    $records = mysqli_query($this->db, $sql);
    while ( $row = mysqli_fetch_assoc($records) ) {
      $Option = new Option;
      $Option->setTitle($row['Title']);
      $Option->setScore($row['Score']);
      $Option->setID($row['OptionID']);
      array_push($Results, $Option);
    }
    return $Results;
  }

  public function ReadOptionScore($OptionID) {
    $score = 0;
    $sql = "SELECT Score FROM Options Where OptionID=$OptionID;";
    $records = mysqli_query($this->db, $sql);
    $row = mysqli_fetch_assoc($records);
    $score = $row['Score'];
    return $score;
  }

  public function AddFromFile($title, $duration, $filename) {
    $success = FALSE;
    $hasParentQuestion = FALSE;
    $quiz = new Quiz($title, $duration);
    if (($handle = fopen($filename, "r")) !== FALSE) {
      while (($line = fgetcsv($handle, 0)) !== FALSE) {
        if ($this->checkFormat($line, $hasParentQuestion)) {
          switch($line[0]) {
            case 'Q':
              $question = new Question;
              $hasParentQuestion = TRUE;
              $question->setQuestion($line[1]);
              array_push($quiz->Questions, $question);
              break;
            case 'O':
              $question->addOption($line[1]);
              break;
            case 'A':
              $question->addAnswer($line[1]);
              break;
            }
          $success = TRUE;
        } else {
          $success = FALSE;
          break;
        }
      }
    }
    if ($success == TRUE) {
      $this->Add($quiz->toSQL());
    }
    return $success;
  }

  private function checkFormat($line, $hasParentQuestion) {
    $success = FALSE;
    if (sizeof($line) != 2)
      return FALSE;
    elseif ($line[0] == 'Q')
      return TRUE;
    elseif ($hasParentQuestion == TRUE && ($line[0] == 'O' || $line[0] == 'A'))
      return TRUE;
    return FALSE;
  }

  public function saveQuizResultToTranscript($StudentID, $QuizID, $Score) {
    $sql = "INSERT INTO Transcript(StudentID, QuizID, Score) values ($StudentID, $QuizID, $Score);";
    $this->db->query($sql);
  }

  public function getTranscriptByStudentIDAndQuizID($StudentID, $QuizID) {
    $Results = array();
    $sql = "SELECT Score FROM Transcript Where StudentID=$StudentID and QuizID=$QuizID;";
    $records = mysqli_query($this->db, $sql);
    $i = 1;
    while ( $row = mysqli_fetch_assoc($records) )
      $Results[$i ++] = $row['Score'];
    return $Results;
  }
}
?>
