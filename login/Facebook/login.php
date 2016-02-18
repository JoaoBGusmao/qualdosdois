<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '521118841399375',
  'app_secret' => 'e8578b089f94e41aa498aac79eb56971',
  'default_graph_version' => 'v2.5',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional
$loginUrl = $helper->getLoginUrl('http://localhost/qualdosdois/login/Facebook/login-callback.php?redirect='.$_GET["redirect"]);

if($loginUrl) header("Location: ".$loginUrl);