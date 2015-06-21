<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Db/ControllerDB.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
	$Database = new ControlledDB();
  	$QuizDao = new QuizDAO;


	$QuestionID = $_GET['Index'];

	$what = "*";
	$from = "question";
	$where = "QuestionID = {$QuestionID}";
	$query = "SELECT {$what} FROM {$from} WHERE {$where}";

	if($Database->checkIfNotEmpty($query)){
		$result = mysqli_fetch_assoc($Database->select($what,$from,$where));
		$options = $QuizDao->ReadAllOption($QuestionID);
		$final_result = array('success' => true, 'Title' => $result['Title'], 'Options'=>$options);
		echo json_encode($final_result);
	}else{
		echo json_encode(array('success' => false));
	}
?>