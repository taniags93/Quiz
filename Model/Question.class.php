<?php
class Question {
  public $Title;
  public $Options;
  public $Answers;
  public $nAnswers;

  public function __construct() {
    $this->Options = array();
    $this->Answers = array();
    $this->nAnswers = 0;
    $this->Score = 0;
  }

  public function setQuestion($q) {
    $this->Title = $q;
  }

  public function addOption($o) {
    array_push($this->Options, $o);
  }

  public function addAnswer($a) {
    $this->nAnswers ++;
    array_push($this->Answers, $a);
    array_push($this->Options, $a);
  }

  public function toSQL() {
    $Queries = array();
    $Query = "INSERT INTO Question (QuestionID, QuizID, Title) values (NULL, @QUIZID, '$this->Title');";
    $ScorePerCorrect = 1 / $this->nAnswers;
    $NegativeMarking = $this->nAnswers > 1 ? -$ScorePerCorrect : -1 / count($this->Options);
    array_push($Queries, $Query);
    array_push($Queries, "SELECT @QUESTIONID:=LAST_INSERT_ID();");
    foreach ($this->Options as $Option) {
      if (in_array($Option, $this->Answers))
        $Query = "INSERT INTO Options (QuestionID, Title, Score) values (@QUESTIONID, '".$Option."', $ScorePerCorrect);";
      else
        $Query = "INSERT INTO Options (QuestionID, Title, Score) values (@QUESTIONID, '".$Option."', $NegativeMarking);";
      array_push($Queries, $Query);
    }
    return $Queries;
  }
}
?>
