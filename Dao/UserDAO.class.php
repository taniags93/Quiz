<?php

class userDAO {
  private $db;

  public function __construct(){
    require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Db/config.php';
    $this->db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  }

  public function Login($username , $password) {
    $success = FALSE;
    $count = 0;
    $username=mysqli_real_escape_string($this->db, $username);
    $mypassword=mysqli_real_escape_string($this->db, $password);

    $sql = "SELECT StudentID FROM Student WHERE username='$username' and passcode='$password'";
    $records = mysqli_query($this->db, $sql);
    if ($records != null)
      $count = mysqli_num_rows($records);
    if ($count == 1)
      $success = $records->fetch_object()->StudentID;
    return $success;
  }

  public function Add($username, $password) {
    $success = FALSE;
    $username=mysqli_real_escape_string($this->db, $username);
    $mypassword=mysqli_real_escape_string($this->db, $password);
    $sql = "insert into Student (username, passcode) values ('$username','$password')";
    if ($this->db->query ($sql))
      $success = TRUE;
    return $success;
  }

}

?>
