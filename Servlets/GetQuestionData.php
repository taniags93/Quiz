<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
  $QuizDao = new QuizDAO;
	$QuestionID = $_GET['Index'];
	$TestID = $_GET['TestID'];
	$QuestionTitle = $QuizDao->ReadOneQuestion($QuestionID);
	if(isset($QuestionTitle)){
		$options = $QuizDao->ReadAllOption($QuestionID, $TestID);

		$final_result = array('success' => true, 'Title' => $QuestionTitle, 'Options'=>$options);
		echo json_encode($final_result);
	}else{
		echo json_encode(array('success' => false));
	}
?>
