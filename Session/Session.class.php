<?php

  class Session {
    private $userdao;

    public function __construct() {
      session_start();
      if (isset($_SESSION['session']))
        ;
      else {
        require_once ($_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/UserDAO.class.php');
        $this->userdao = new UserDAO;
      }
    }

    public function isValid() {
      $success = FALSE;
      if (isset($_SESSION))
        $success = array_key_exists('user', $_SESSION);
      return $success;
    }

    public function Login($username, $password) {
      $success = $this->userdao->Login($username, $password);
      if ($success > 0) {
        $_SESSION['user'] = $username;
        $_SESSION['userid'] = $success;
      } else
        $success = FALSE;
      return $success;
    }

    public function Logout() {
      if(isValid())
        unset($_SESSION['user']);
      return session_destroy();
    }
  }
?>
