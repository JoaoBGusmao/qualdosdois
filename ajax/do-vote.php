<?php
	session_start();
	include("../inc/config.php");
	include("../inc/classes/class.question.php");
	if(!isset($_POST["action"]) && ($_POST["action"] != "vote" && $_POST["action"] != "unvote")) echo json_encode( array("ERROR"=>"true","ERROR_CODE"=>"ACTION_NOT_FOUND","ERROR_TEXT"=>"Ação não encontrada") );
	if(!isset($_POST["url"])) echo json_encode( array("ERROR"=>"true","ERROR_CODE"=>"QUESTION_NOT_FOUND","ERROR_TEXT"=>"Pergunta não encontrada") );
	else {
		$question = new question();
		try {
			$question->loadQuestion($_POST["url"]);
		} catch(exception $e) {
			echo json_encode( array("ERROR"=>"true","ERROR_CODE"=>"QUESTION_NOT_FOUND","ERROR_TEXT"=>"Pergunta não encontrada") );
		}
		if (!isset($_SESSION['login_provider'])) {
			echo json_encode( array("ERROR"=>"true","ERROR_CODE"=>"NOT_LOGGEDIN","ERROR_TEXT"=>"Conecte-se para realizar esta ação") );
			exit;
		}
		$question->loadQuestion($_POST["url"]);
		
		$userId = $_SESSION["login_provider"]."_".$_SESSION["id"];
		$name = $_SESSION["name"];
		$email = $_SESSION["email"];
		if(!isset($name)) $name = "";
		if(!isset($email)) $email = "";
		if($_POST["action"] == "vote") $result = $question->increaseVote($_POST["vote"],$userId,$name,$email);
		else if($_POST["action"] == "unvote") $result = $question->decreaseVote($_POST["vote"],$userId);
		echo $result;
	}
?>