<?php
	session_start();
	require_once("../inc/config.php");
	require_once("../inc/classes/class.question.php");
	if(!isset($_POST["action"])) exit;
	$action = $_POST["action"];
	if(!isset($_SESSION["temp_question"])) {
		echo json_encode( array("ERROR"=>"Atualize a página","ERROR_CODE"=>"REFRESH_PAGE") );
		exit;
	}
	if (!isset($_SESSION['login_provider'])) {
		echo json_encode( array("ERROR"=>"Conecte-se para realizar esta ação","ERROR_CODE"=>"NOT_LOGGEDIN") );
		exit;
	}
	$question = unserialize($_SESSION["temp_question"]);
	switch($action) {
		case "set-title":
			if(!isset($_POST["content"]) || $_POST["content"] == "" || $_POST["content"] == "{CLIQUE PARA ADICIONAR UMA PERGUNTA}") {
				echo json_encode( array("ERROR"=>"Insira um título válido","ERROR_CODE"=>"TITLE_BLANK") );
				exit;
			}
			if(strlen($_POST["content"]) > 43) {
				echo json_encode( array("ERROR"=>"O título da pergunta está muito grande! Reduza-o um pouco","ERROR_CODE"=>"TITLE_TOO_BIG") );
				exit;
			}
			$question->setTitle(htmlspecialchars($_POST["content"], ENT_QUOTES, 'UTF-8')); 
			$_SESSION["temp_question"] = serialize($question);
			echo json_encode( array("SUCCESS"=>"true") );
			break;
		case "set-title-a":
			if(!isset($_POST["content"]) || $_POST["content"] == "" || $_POST["content"] == "{Clique para adicionar uma opção}") {
				echo json_encode( array("ERROR"=>"Insira um título válido","ERROR_CODE"=>"TITLE_BLANK") );
				exit;
			}
			if(strlen($_POST["content"]) > 23) {
				echo json_encode( array("ERROR"=>"O título da pergunta está muito grande! Reduza-o um pouco","ERROR_CODE"=>"TITLE_TOO_BIG") );
				exit;
			}
			$question->setTitleA(htmlspecialchars($_POST["content"], ENT_QUOTES, 'UTF-8'));
			$_SESSION["temp_question"] = serialize($question);
			echo json_encode( array("SUCCESS"=>"true") );
			break;
		case "set-title-b":
			if(!isset($_POST["content"]) || $_POST["content"] == "" || $_POST["content"] == "{Clique para adicionar uma opção}") {
				echo json_encode( array("ERROR"=>"Insira um título válido","ERROR_CODE"=>"TITLE_BLANK") );
				exit;
			}
			if(strlen($_POST["content"]) > 23) {
				echo json_encode( array("ERROR"=>"O título da pergunta está muito grande! Reduza-o um pouco","ERROR_CODE"=>"TITLE_TOO_BIG") );
				exit;
			}
			$question->setTitleB(htmlspecialchars($_POST["content"], ENT_QUOTES, 'UTF-8'));
			$_SESSION["temp_question"] = serialize($question);
			echo json_encode( array("SUCCESS"=>"true") );
			break;
		case "save-final":
			if($question->getTitle() == "" || $question->getTitleA() == "" || $question->getTitleB() == "") {
				echo json_encode( array("ERROR"=>"Você não preencheu algumas informações. Volte e verifique","ERROR_CODE"=>"NOT_COMPLETE") );
				exit;
			}
			echo $question->saveQuestion();
			break;
		default:
			echo json_encode( array("ERROR"=>"Açao não encontrada") );
			break;
	}
?>