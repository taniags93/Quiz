<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Dao/QuizDAO.class.php';
	$QuizID = $_GET['QuizID'];
	$QuizDao = new QuizDAO;
	$result = $QuizDao->getMinimumQuestionID($QuizID);

	if(isset($result['MinNumber']) && isset($result['Quantity']) && $result['Quantity'] > 0) {
		echo json_encode(array('success' => true, 'MinNumber' => $result['MinNumber'],'Quantity' => $result['Quantity']));
	} else {
		echo json_encode(array('success' => false));
	}
?>
