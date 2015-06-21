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
  public function GetAllSubjects() {
    $Subject = array();
    $sql = "SELECT SubjectID, Title FROM Subject;";
    $records = mysqli_query($this->db, $sql);
    while ( $row = mysqli_fetch_assoc($records) ) {
      $sub = $row['Title'];
      $subid = $row['SubjectID'];
      $Subject[$subid] = $sub;
    }
    return $Subject;
  }

  public function ReadOneQuiz($QuizID) {
    $Quiz = new Quiz;
    $Question = new Question;
    $sql = "SELECT Title, Duration FROM Quiz where QuizID=$QuizID;";
    $records = mysqli_query($this->db, $sql);
    while ( $row = mysqli_fetch_assoc($records) ) {
      $Quiz->Duration = $row['Duration'];
      $Quiz->Title = $row['Title'];
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

  public function StartTakingQuiz($StudentID, $QuizID) {
    $sql = "INSERT into Test(StudentID, QuizID) values($StudentID, $QuizID);";
    $this->db->query($sql);
    $sql = "SELECT LAST_INSERT_ID() as TestID;";
    $records = mysqli_query($this->db, $sql);
    $row = mysqli_fetch_assoc($records);
    $TestID = $row['TestID'];
    return $TestID;
  }

  public function RecordTestAnswers($TestID, $OptionID) {
    $sql = "INSERT INTO Answer(TestID, OptionID) values('$TestID','$OptionID');";
    $this->db->query($sql);
  }

  public function ReadOptionScore($OptionID) {
    $score = 0;
    $sql = "SELECT Score FROM Options Where OptionID=$OptionID;";
    $records = mysqli_query($this->db, $sql);
    $row = mysqli_fetch_assoc($records);
    $score = $row['Score'];
    return $score;
  }

  public function AddFromFile($title, $duration, $subjectid, $filename) {
    $success = FALSE;
    $hasParentQuestion = FALSE;
    $quiz = new Quiz($title, $duration, $subjectid);
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

  public function GetTestResult($TestID) {
    $sql = "SELECT SUM(Score) AS Score FROM Options WHERE OptionID IN (SELECT OptionID FROM Answer WHERE TestID=$TestID);";
    $records = mysqli_query($this->db, $sql);
    $row = mysqli_fetch_assoc($records);
    $Score = $row['Score'];
    $sql = "SELECT count(QuestionID) AS MaximumScore FROM Question WHERE QuizID IN (SELECT QuizID FROM Test WHERE TestID=$TestID);";
    $records = mysqli_query($this->db, $sql);
    $row = mysqli_fetch_assoc($records);
    $MaxScore = $row['MaximumScore'];
    if(!isset($Score))
      $Score = 0;
    $Percentile = $Score / $MaxScore * 100;
    return $Percentile;
  }

  public function GetTranscriptByStudentIDAndQuizID($StudentID, $QuizID) {
    $Results = array();
    $sql = "SELECT Title, QuizID FROM Quiz where SubjectID IN (Select SubjectID from Quiz WHERE QuizID=$QuizID);";
    $records = mysqli_query($this->db, $sql);
    $i = 1;
    while ( $row = mysqli_fetch_assoc($records) ) {
      $QuizID = $row['QuizID'];
      $sql = "SELECT TestID FROM Test where QuizID=$QuizID AND StudentID=$StudentID;";
      $testrecords = mysqli_query($this->db, $sql);
      while ( $testrow = mysqli_fetch_assoc($testrecords) ) {
        $Score = $this->GetTestResult($testrow['TestID']);
        $Title = $row['Title'];
        $Results[$i.".".$Title] = $Score;
        $i ++;
      }
    }
    return $Results;
  }
}
?>
