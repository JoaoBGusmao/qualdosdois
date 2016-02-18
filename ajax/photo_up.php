<?php
session_start();
require_once("../inc/config.php");
require_once  "../inc/classes/bulletproof.php";
require_once("../inc/classes/class.question.php");
$image = new Bulletproof\Image($_FILES);

if(!isset($_SESSION["temp_question"])) {
	echo json_encode( array("ERROR"=>"Atualize a página","ERROR_CODE"=>"REFRESH_PAGE") );
	exit;
}
if (!isset($_SESSION['login_provider'])) {
	echo json_encode( array("ERROR"=>"Conecte-se para realizar esta ação","ERROR_CODE"=>"NOT_LOGGEDIN") );
	exit;
}
$question = unserialize($_SESSION["temp_question"]);
$toUp = "";
if($image["image-a"]) $toUp = "a";
if($image["image-b"]) $toUp = "b";
if($toUp != ""){
	$upload = $image->upload();
    if($upload){
		if($toUp == "a") $question->setImageA($image->getName().".".$image->getMime());
		if($toUp == "b") $question->setImageB($image->getName().".".$image->getMime());
		$_SESSION["temp_question"] = serialize($question);
        echo json_encode( array("SUCCESS"=>"true") );
    } else {
        echo json_encode ( array("ERROR"=>"true", "ERROR_CODE"=>$image["error"]) );
    }
}