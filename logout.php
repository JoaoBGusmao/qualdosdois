<?php
	require_once("./inc/config.php");
	session_start();
	session_destroy();
	header("Location: ".WEB_PATH."question/logout");