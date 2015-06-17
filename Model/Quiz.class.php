<?php
class Quiz {
  public $Title;
  public $Duration;
  public $Questions;
  public $MaximumScore;

  public function __construct($title="", $duration="") {
    $this->Title = $title;
    $this->Duration = $duration;
    $this->Questions = array();
  }

  public function toSQL() {
    $Queries = array();
    array_push($Queries, "INSERT INTO Quiz (QuizID, Title, Duration) VALUES (NULL, '$this->Title', '$this->Duration');");
    array_push($Queries, "SELECT @QUIZID:=LAST_INSERT_ID();");
    foreach ($this->Questions as $Question)
      $Queries = array_merge($Queries, $Question->toSQL());
    $this->MaximumScore = count($this->Questions);
    array_push($Queries, "UPDATE Quiz SET MaximumScore=$this->MaximumScore WHERE QuizID=@QUIZID;");
    return $Queries;
  }
}
?>
