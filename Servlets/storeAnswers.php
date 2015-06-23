<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Session/Session.class.php';
$session = new Session;

  
	if (isset($_SESSION['userid']))
  	{
 		$TestID = $_POST['TestID'];
  		$QuizDao = new QuizDAO;
 	
 		foreach($_POST['answers'] as $OptionID) {
      	$QuizDao->RecordTestAnswers($TestID, $OptionID);
    }
	}
	else
	{
		//invalid id
	}
  
?>