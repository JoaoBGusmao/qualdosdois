<?php 
session_start();
require_once("./inc/config.php"); 
require_once("./inc/classes/class.question.php");
?>
<html>
	<head>
		<title>Minha Página | Qual dos dois?</title>
		<?php require_once("./inc/header_includes.php"); ?>
	</head>
	<body>
	<?php require_once("./inc/header.php"); ?>
		<div class="ui container">
			<?php
				if(isset($_SESSION["login_provider"])) {
			?>
			<h1 style="text-align: center">Minhas Perguntas</h1>
			<div class="author-box">
				<img class="ui tiny circular image" src="<?php if($_SESSION["login_provider"] == "G") echo $_SESSION["picture"]; else if($_SESSION["login_provider"] == "FB") echo "https://graph.facebook.com/".$_SESSION['id']."/picture?type=large" ?>"><h2><?php echo $_SESSION["name"]; ?></h2>
			</div>
			<table class="ui celled table">
				<thead>
					<tr>
						<th style="width: 90%;">Pergunta</th>
						<th>Votos</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
							$question = new question();
							$questions = $question->getQuestionsByUser($_SESSION["id"]);
						?>
						<?php
							if($questions == null) {
						?>
							<tr><td colspan="2" style="text-align: center">Você ainda não fez nenhuma pergunta! :(</td></tr>
						<?php } else { ?>
							<?php foreach($questions as $single) { ?>
								<tr>
								<td><a href="<?php echo WEB_PATH; ?>question/<?php echo $single["url"] ?>"><?php echo $single["title"] ?></a></td>
								<td><?php echo $single["votes"] ?></td>
								</tr>
							<?php } ?>
						<?php
							}
						?>
					</tr>
			  </tbody>
			</table>
			
			
			<?php } ?>
		</div>
	</body>
</html>
