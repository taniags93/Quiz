<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/Quiz/Db/ControllerDB.php';
	$Database = new ControlledDB();

	$QuizID = $_GET['QuizID'];

	$what = "*";
	$from = "quiz";
	$where = "QuizID = {$QuizID}";

	$query = "SELECT {$what} FROM {$from} WHERE {$where}";

	if($Database->checkIfNotEmpty($query)){

		$what = "MIN(QuestionID) as MinNumber, COUNT(QUestionID) as Quantity";
		$from = "question";
		$where = "QuizID = {$QuizID}";
		$result = mysqli_fetch_assoc($Database->select($what,$from,$where));
		echo json_encode(array('success' => true, 'MinNumber' => $result['MinNumber'],'Quantity' => $result['Quantity']));
	}else{
		echo json_encode(array('success' => false));
	}
