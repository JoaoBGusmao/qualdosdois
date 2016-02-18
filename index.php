<?php 
session_start();
require_once("./inc/config.php"); 
require_once("./inc/classes/class.question.php");
$question = new question();
?>
<html>
	<head>
		<title>Qual dos dois?</title>
		<?php require_once("./inc/header_includes.php"); ?>
	</head>
	<body>
	<?php require_once("./inc/header.php"); ?>
		<!--- RIP Houdini, the sapeca cat, meu gato que morreu dia 11/02. Deixei ele na casa da minha ex namorada pois mudei de cidade e não pude mante-lo comigo. Ela é uma bosta, tratava o gato como se fosse objeto. Morreu envenenado o pequeno Houdini. Se quiser ver quem é o tal do gato Houdini, ele é muito fofo: https://www.facebook.com/photo.php?fbid=856439541135315&set=a.223735871072355.47893.100003078321519&type=3&theater
		Houdini, wherever you are, say thanks god because nobody deserves that bitch (meu gato fala inglês) --->
		<div class="ui container">
			<div class="main_index">
				<div class="content">
					<h1 style="font-size: 60px;margin-top: 10px">Qual dos Dois?</h1>
					<h3 style="padding: 0;margin: 9px;">Crie sua pergunta, coloque duas opções, divulgue o link e espere a treta começar *-*</h3>
					<div class="ui stackable equal width grid">
						<div class="column stats">
							<p class="index_votes"><?php echo $question->getAmount("votes"); ?></p>
							<p class="index_votes_text">Votos</p>
						</div>
						<div class="column stats">
							<p class="index_votes"><?php echo $question->getAmount("questions"); ?></p>
							<p class="index_votes_text">Perguntas</p>
						</div>
					</div>
					<div class="create_bt">
						<a class="positive ui button" href="<?php echo WEB_PATH; ?>new">Criar uma pergunta agora</a>
					</div>
				</div>
			</div>
			<div class="ui grid">
				<div class="index_table ten wide column">
					<h2>Top 5 Perguntas</h2>
					<table class="ui celled unstackable table">
						<thead>
							<tr>
								<th>Pergunta</th>
								<th>Votos</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$questions = $question->getTopQuestions();
							?>
							<?php
								if($questions == null) {
							?>
								<tr><td colspan="2" style="text-align: center">Nenhuma pergunta encontrada :(</td></tr>
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
						</tbody>
					</table>
				</div>
				
				<div class="six wide column index_table">
					<h2>Últimas Perguntas</h2>
					<table class="ui celled unstackable table">
						<thead>
							<tr>
								<th>Pergunta</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$questions = $question->getLatest();
							?>
							<?php
								if($questions == null) {
							?>
								<tr><td colspan="2" style="text-align: center">Nenhuma pergunta encontrada :(</td></tr>
							<?php } else { ?>
								<?php foreach($questions as $single) { ?>
									<tr>
									<td><a href="<?php echo WEB_PATH; ?>question/<?php echo $single["url"] ?>"><?php echo $single["title"] ?></a></td>
									</tr>
								<?php } ?>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="ui container moneyTalks" style="text-align: center;margin-top: 50px;margin-bottom: 50px">
				<script type="text/javascript">
					google_ad_client = "ca-pub-3097864491384952";
					google_ad_slot = "5084287220";
					google_ad_width = 728;
					google_ad_height = 90;
				</script>
				<!-- Qual dos Dois -->
				<script type="text/javascript" src="//pagead2.googlesyndication.com/pagead/show_ads.js"></script>
			</div>

		</div>
	</body>
</html>
