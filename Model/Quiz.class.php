<?php
class Quiz {
  public $Title;
  public $Duration;
  public $Questions;
  public $SubjectID;

  public function __construct($title="", $duration="", $subjectid="") {
    $this->Title = $title;
    $this->Duration = $duration;
    $this->SubjectID = $subjectid;
    $this->Questions = array();

  }

  public function toSQL() {
    $Queries = array();
    array_push($Queries, "INSERT INTO Quiz (QuizID, Title, Duration, SubjectID) VALUES (NULL, '$this->Title', '$this->Duration', '$this->SubjectID');");
    array_push($Queries, "SELECT @QUIZID:=LAST_INSERT_ID();");
    foreach ($this->Questions as $Question)
      $Queries = array_merge($Queries, $Question->toSQL());
    return $Queries;
  }
}
?>
