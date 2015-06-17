<?php
class Option {
  public $Title;
  public $Score;
  public $OptionID;

  public function __construct() {
    $this->Score = 0;
  }

  public function setTitle($t) {
    $this->Title = $t;
  }

  public function setScore($s) {
    $this->Score = $s;
  }

  public function setID($i) {
    $this->OptionID = $i;
  }

}
?>
