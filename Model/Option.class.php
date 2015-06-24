<?php
class Option {
  public $Title;
  public $Score;
  public $OptionID;
  public $Selected;

  public function __construct() {
    $this->Score = 0;
    $this->Selected = false;
  }

  public function setTitle($t) {
    $this->Title = $t;
  }

  public function setScore($s) {
    $this->Score = $s;
  }

  public function setSelected($s) {
    $this->Selected = $s;
  }

  public function setID($i) {
    $this->OptionID = $i;
  }

}
?>
