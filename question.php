<?php 
session_start();
require_once("./inc/config.php"); 
require_once("./inc/classes/class.question.php");
if(!isset($_GET["url"])) header("Location: ".WEB_PATH."question/not-found"); 
else {
	$question = new question();
	try {
		$question->loadQuestion($_GET["url"]);
	} catch(exception $e) {
		header("Location: ".WEB_PATH."question/not-found"); 
	}
}
?>
<html>
	<head>
		<title><?php echo $question->getTitleA(); ?> ou <?php echo $question->getTitleB(); ?>? | Qual dos dois?</title>
		<?php require_once("./inc/header_includes.php"); ?>
		<meta property="og:url"           content="<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" />
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="<?php echo $question->getTitleA(); ?> ou <?php echo $question->getTitleB(); ?>? | Qual dos dois?" />
		<meta property="og:description"   content="Vote por <?php echo $question->getTitleA(); ?> ou <?php echo $question->getTitleB(); ?>, dê sua opinião e ajude na campanha pela sua opção" />
	</head>
	<body>
	<?php require_once("./inc/header.php"); ?>
		<div class="ui container">
			<h1 class="question-title" style="margin-bottom: 10px;"><?php echo $question->getTitle(); ?></h1><div class="fb-share-button" data-href="<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" data-layout="button_count" style="float:right"></div>
			<div class="ui stackable equal width grid">
				<div class="column" style="margin: 0 !important;">
					<div class="ui card">
						<div class="image dimmable specialcards">
							<div class="box-img">
								<?php if($question->getImageA() == "default_image") { ?>
									<img class="image-a" src="<?php echo WEB_PATH; ?>assets/img/default_image.png">
								<?php } else { ?>
									<img class="image-a" src="<?php echo WEB_PATH; ?>upload/<?php echo $question->getImageA(); ?>">
								<?php } ?>
							</div>
							<div class="votes_box">
								<?php
									$votesA = $question->getVotesA();
									$votesB = $question->getVotesB();
									$total = $votesA+$votesB;
									if($total != 0) $percentA = round($votesA/$total*100);
									else $percentA = 0;
								?>
								<span class="percent-a"><?php echo $percentA; ?></span>%
								<div class="votes_right"><span class="votes-a-count"><?php echo $votesA; ?></span> <?php if($votesA==1) echo "Voto"; else echo "Votos"; ?></div>
							</div>
						</div>
						<div class="content">
							<div class="header"><?php echo $question->getTitleA(); ?></div>
						</div>
						<div class="extra content center">
							<?php $votedA = ""; if( (isset($_SESSION["login_provider"])) && $question->hasVoted($_SESSION["id"],"a") ) $votedA = "true"; ?>
							<button class="ui basic button vote <?php if($votedA == "true") echo "green"; ?>" <?php if($votedA == "true") echo 'data-voted="true"'; else echo 'data-voted="false"'; ?> data-vote="a" style="width: 100%">
							<i class="like icon"></i>
								<span class="vote-text"><?php if($votedA == "true") echo "ESCOLHIDO"; else echo "ESCOLHER"; ?></span>
							</button>
						</div>
					</div>
				</div>
				<div class="column" style="margin: 0 !important;">
					<p class="lorena">X</p>
				</div>
				<div class="column" style="margin: 0 !important;">
					<div class="ui card">
						
						<div class="image dimmable specialcards">
							<div class="box-img">
								<?php if($question->getImageB() == "default_image") { ?>
									<img class="image-b" src="<?php echo WEB_PATH; ?>assets/img/default_image.png">
								<?php } else { ?>
									<img class="image-b" src="<?php echo WEB_PATH; ?>upload/<?php echo $question->getImageB(); ?>">
								<?php } ?>
							</div>
							<div class="votes_box">
								<?php
									$votesA = $question->getVotesA();
									$votesB = $question->getVotesB();
									$total = $votesA+$votesB;
									if($total != 0) $percentB = round($votesB/$total*100);
									else $percentB = 0;
								?>
								<span class="percent-b"><?php echo $percentB; ?></span>%
								<div class="votes_right"><span class="votes-b-count"><?php echo $votesB; ?></span> <?php if($votesB==1) echo "Voto"; else echo "Votos"; ?></div>
							</div>
						</div>
						<div class="content">
							<div class="header"><?php echo $question->getTitleB(); ?></div>
						</div>
						<div class="extra content center">
							<?php $votedB = ""; if( (isset($_SESSION["login_provider"])) && $question->hasVoted($_SESSION["id"],"b") ) $votedB = "true"; ?>
							<button class="ui basic button vote <?php if($votedB == "true") echo "green"; ?>" <?php if($votedB == "true") echo 'data-voted="true"'; else echo 'data-voted="false"'; ?> data-vote="b" style="width: 100%">
							<i class="like icon"></i>
								<span class="vote-text"><?php if($votedB == "true") echo "ESCOLHIDO"; else echo "ESCOLHER"; ?></span>
							</button>
						</div>
					</div>
				</div>
				
			</div>
			<div class="ui progress">
				<div class="bar bar-a" style="width: <?php echo $percentA; ?>% !important">
					<div class="progress"></div>
				</div>
				<div class="label"><?php echo $question->getTitleA(); ?> <strong class="percent-a"><?php echo $percentA; ?></strong>% / <strong class="percent-b"><?php echo $percentB; ?></strong>% <?php echo $question->getTitleB(); ?></div>
			</div>
			<h2>Argumente:</h2>
			<div class="fb-comments" data-href="<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" data-width="100%" data-numposts="5"></div>
		</div>
		
		<script>
			$(".vote").on("click",function() {
				var bt = $(this);
				var action = "vote";
				if( $(this).attr("data-voted") == "true" ) action = "unvote";
				$.post("<?php echo WEB_PATH; ?>ajax/do-vote.php",{url:"<?php echo $_GET["url"]; ?>",vote:$(this).attr("data-vote"),action:action},function(val) {
					var result = JSON.parse(val);
					if(result["ERROR"]) {
						if(result["ERROR_CODE"] == "NOT_LOGGEDIN") $('.loggin').modal('show');
						else if(result["ERROR_CODE"] == "INVALID_VOTE") {
							$(".modal_error_description").html("Não foi possível registrar sua resposta. Verifique se você já votou nesta pergunta.");
							$(".modal_error").modal("show");
						}
					} else if(result["SUCCESS"]) {
						if(action == "vote") {
							bt.attr("data-voted","true");
							bt.addClass("green");
							bt.find(".vote-text").html("ESCOLHIDO");
							setTimeout(function(){ $(".newquestion").modal("show") },2000);
						} else if(action == "unvote") {
							bt.attr("data-voted","false");
							bt.removeClass("green");
							bt.find(".vote-text").html("ESCOLHER");
						}
						updateVotes(result["votes_a"],result["votes_b"]);
					}
				})
			});
			
			function updateVotes(votes_a,votes_b) {
				votes_a = parseInt(votes_a);
				votes_b = parseInt(votes_b);
				$(".votes-a-count").html(votes_a);
				$(".votes-b-count").html(votes_b);
				total = votes_a+votes_b;
				
				if(total != 0) percentA = Math.round(votes_a/total*100);
				else percentA = 0;
				
				if(total != 0) percentB = Math.round(votes_b/total*100);
				else percentB = 0;
				
				$(".percent-a").html(percentA);
				$(".percent-b").html(percentB);
				$(".bar-a").css({width:""+percentA+"%"});
			}
			$(".new_question").on("click",function() {
				$(".new_question_form").modal("show");
			});
		</script>
		<div class="ui modal newquestion small ">
			<i class="close icon"></i>
			<div class="header">
				Obrigado por votar :)
			</div>
			<div class="content">
				<div class="description" style="text-align:center">
					<div class="ui grid computer only tablet only">
						<div class="six wide column">
							<a href="<?php echo WEB_PATH; ?>new"><img src="<?php echo WEB_PATH; ?>assets/img/create-question.png" style="width: 100%;"></a>
						</div>
						<div class="three wide column">
							<img src="<?php echo WEB_PATH; ?>assets/img/ou.png" style="width: 100%;">
						</div>
						<div class="six wide column">
							<a href="#" onclick="share_fb('<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>');return false;" rel="nofollow" share_url="<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" target="_blank"><img src="<?php echo WEB_PATH; ?>assets/img/fb-share.png" style="width: 100%;" target="_blank"></a>
							<script>
							function share_fb(url) {
							  window.open('https://www.facebook.com/sharer/sharer.php?u='+url,'facebook-share-dialog',"width=626,height=436");
							}
							</script>
						</div>
					</div>
					
					<div class="ui grid mobile only">
						<div class="sixteen wide column">
							<a href="<?php echo WEB_PATH; ?>new"><img src="<?php echo WEB_PATH; ?>assets/img/create-question.png" style="width: 100%;"></a>
						</div>
						<div class="sixteen wide column">
							<a href="http://www.facebook.com/share.php?u=<?php echo"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>&title=<?php echo $question->getTitleA(); ?> ou <?php echo $question->getTitleB(); ?>? | Qual dos dois?"><img src="<?php echo WEB_PATH; ?>assets/img/fb-share.png" style="width: 100%;"></a>
						</div>
					</div>
				</div>
			</div>
			<div class="actions">
				<div class="ui black deny button">
					Cancelar
				</div>
			</div>
		</div>
		<?php if(isset($_GET["new"])) { ?>
		<script type="text/javascript">
			window.history.pushState(0,"Título","<?php echo WEB_PATH?>question/<?php echo $_GET["url"]; ?>");
			setTimeout(function(){ $(".newquestion").modal("show") },1500);
		</script>
		<?php } ?>
		<div class="ui modal loggin small">
			<i class="close icon"></i>
			<div class="header">
				Conecte-se para votar. É super rápido, prometo!
			</div>
			<div class="content">
				<div class="description" style="text-align:center">
					<a href="<?php echo WEB_PATH; ?>login/Facebook/login.php?redirect=<?php echo "$_SERVER[REQUEST_URI]"; ?>"><img src="<?php echo WEB_PATH; ?>assets/img/login_fb.png"></a>
					<div id="gSignInWrapper">
					    <div id="customBtn" class="customGPlusSignIn" data-gapiattached="true">
					    	<span class="g-icon"></span>
					    	<span class="buttonText">Login com Google</span>
					    </div>
			  		</div>
				</div>
				<script type="text/javascript">
					$("#gSignInWrapper").on("click", function() {
						window.location.href = "<?php echo WEB_PATH; ?>login/Google/loginwithgoogle.php?do_login=true&redirect=<?php echo "$_SERVER[REQUEST_URI]"; ?>";
					})
				</script>
			</div>
			<div class="actions">
				<div class="ui black deny button">
					Cancelar
				</div>
			</div>
		</div>
		<div class="ui modal modal_error small">
			<i class="close icon"></i>
			<div class="header">
				Algo de errado por aqui...
			</div>
			<div class="content">
				<div class="description" style="text-align:center">
					<p class="modal_error_description"></p>
				</div>
			</div>
			<div class="actions">
				<div class="ui black deny button">
					Cancelar
				</div>
			</div>
		</div>
	</body>
</html>
