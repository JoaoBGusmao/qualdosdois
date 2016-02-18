<?php 
session_start();
require_once("./inc/config.php");
require_once("./inc/classes/class.question.php");
$block = true;
require_once("./login/Google/loginwithgoogle.php");
if(isset($_SESSION["temp_question"])) unset($_SESSION["temp_question"]);
$question = new question();
$_SESSION["temp_question"] = serialize($question);
?>
<html>
	<head>
		<title>Criar uma nova pergunta | Qual dos dois?</title>
		<?php require_once("./inc/header_includes.php"); ?>
	</head>
	
	<body>
	<?php require_once("./inc/header.php"); ?>
		<div class="ui container">
			<h1 class="question-title" data-edit="false"><span class="question-title-text">{Clique para adicionar uma pergunta}</span><div class="ui icon input title_edit hide"><input type="text" class="question-title-input" value="{CLIQUE PARA ADICIONAR UMA PERGUNTA}"><i class="checkmark icon save_bt" data-save-type="title"></i></div></h1>
			
			<div class="ui stackable equal width grid">
				<div class="column">
					<div class="ui card">
						<div class="image dimmable specialcards">
							<div class="ui blurring inverted dimmer transition hidden">
								<div class="content">
									<div class="center">
										<label class="up_bt">
											<form id="upload-a" action="" method="post" enctype="multipart/form-data">
												<input type="file" style="display:none" name="image-a" class="upload_bt" data-upload="a"/>
												<span class="ui teal button vote">ESCOLHER IMAGEM</span>
												<input type="submit" value="Upload" class="submit" id="botao_up_a" style="display:none" />
											</form>
										</label>
									</div>
								</div>
							</div>
							<div class="box-img">
								<img class="image-a" src="<?php echo WEB_PATH; ?>assets/img/default_image.png">
							</div>
						</div>
						<div class="content">
							<div class="header title-a" data-edit="false"><span class="title-a-text">{Clique para adicionar uma opção}</span> <div class="ui icon input titleA_edit hide"><input type="text" class="title-a-input" value="{Clique para adicionar uma opção}"><i class="checkmark icon save_bt" data-save-type="titleA"></i></div></div>
							<div class="meta">
								<a class="group"></a>
							</div>
							<div class="description"></div>
						</div>
						<div class="extra content">
							<a class="right floated created"><span class="percent-a">0</span>%</a>
							<a class="friends"><span class="votes-a-count">0</span> Votos</a>
						</div>
					</div>
				</div>
				<div class="column">
					<p class="lorena">X</p>
				</div>
				<div class="column">
					<div class="ui card">
						
						<div class="image dimmable specialcards">
							<div class="ui blurring inverted dimmer transition hidden">
								<div class="content">
									<div class="center">
										<label class="up_bt">
											<form id="upload-b" action="" method="post" enctype="multipart/form-data">
												<input type="file" style="display:none" name="image-b" class="upload_bt" data-upload="b"/>
												<span class="ui teal button vote">ESCOLHER IMAGEM</span>
												<input type="submit" value="Upload" class="submit" id="botao_up_b" style="display:none" />
											</form>
										</label>
									</div>
								</div>
							</div>
							<div class="box-img">
								<img class="image-b" src="<?php echo WEB_PATH; ?>assets/img/default_image.png">
							</div>
						</div>
						<div class="content">
							<div class="header title-b" data-edit="false"><span class="title-b-text">{Clique para adicionar uma opção}</span> <div class="ui icon input titleB_edit hide"><input type="text" class="title-b-input" value="{Clique para adicionar uma opção}"><i class="checkmark icon save_bt" data-save-type="titleB"></i></div></div>
							<div class="meta">
								<a class="group"></a>
							</div>
							<div class="description"></div>
						</div>
						<div class="extra content">
							<a class="right floated created"><span class="percent-b">0</span>%</a>
							<a class="friends"><span class="votes-b-count">0</span> Votos</a>
						</div>
					</div>
				</div>
				
			</div>
			
			<div class="ui positive right labeled icon button post_bt">
				Pronto, postar minha pergunta
				<i class="checkmark icon"></i>
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
		<input type="hidden" class="uploading" data-uploading="" />
		
		<?php if (!isset($_SESSION['login_provider'])) { ?>
			<script type="text/javascript">
				setTimeout(function(){ $(".loggin").modal("show") },500);
			</script>
		<?php } ?>
		
		<script>
			$('.specialcards').dimmer({
			  on: 'hover'
			});

			$(".question-title-text").on("click",function() {
				$(".question-title").attr("data-edit","true");
				$(".question-title-text").addClass("hide");
				$(".title_edit").removeClass("hide");
			});
			
			$(".title-a-text").on("click",function() {
				$(".title-a").attr("data-edit","true");
				$(".title-a-text").addClass("hide");
				$(".titleA_edit").removeClass("hide");
			});
			
			$(".title-b-text").on("click",function() {
				$(".title-b").attr("data-edit","true");
				$(".title-b-text").addClass("hide");
				$(".titleB_edit").removeClass("hide");
			});
			
			//Clique Fora
			$(document).mouseup(function (e) {
				var container = $(".question-title");
				if(container.attr("data-edit") == "true" && !$(".modal_error").hasClass("active") && !$(".loggin").hasClass("active")) {
					if (!container.is(e.target)
						&& container.has(e.target).length === 0)
					{
						saveTitle(container);
					}
				}
			});
			$(document).mouseup(function (e) {
				var container = $(".title-a");
				if(container.attr("data-edit") == "true" && !$(".modal_error").hasClass("active") && !$(".loggin").hasClass("active")) {
					if (!container.is(e.target)
						&& container.has(e.target).length === 0)
					{
						saveTitleA(container);
					}
				}
			});
			$(document).mouseup(function (e) {
				var container = $(".title-b");
				if(container.attr("data-edit") == "true" && !$(".modal_error").hasClass("active") && !$(".loggin").hasClass("active")) {
					if (!container.is(e.target)
						&& container.has(e.target).length === 0)
					{
						saveTitleB(container);
					}
				}
			});
			
			//Enter Press
			$(document).on('keyup', '.question-title-input',function (e) {
				if (e.keyCode == 13) {
					var container = $(".question-title");
					saveTitle(container);
				}
			});
			$(document).on('keyup', '.title-a-input',function (e) {
				if (e.keyCode == 13) {
					var container = $(".title-a");
					saveTitleA(container);
				}
			});
			$(document).on('keyup', '.title-b-input',function (e) {
				if (e.keyCode == 13) {
					var container = $(".title-b");
					saveTitleB(container);
				}
			});
			$(".save_bt").on("click", function() {
				var largueiminhaexeelanaoquisvoltardpsagoraesquecija = $(this).attr("data-save-type");
				if(largueiminhaexeelanaoquisvoltardpsagoraesquecija == "title") saveTitle(null);
				else if(largueiminhaexeelanaoquisvoltardpsagoraesquecija == "titleA") saveTitleA(null);
				else if(largueiminhaexeelanaoquisvoltardpsagoraesquecija == "titleB") saveTitleB(null);
			});
			//Save
			function saveTitle(container) {
				$.post("<?php echo WEB_PATH; ?>ajax/save-to-temp.php", {action:"set-title",content:$(".question-title-input").val()}, function(callback) {
					var response = JSON.parse(callback);
					if(response["ERROR"]) {
						if(response["ERROR_CODE"] == "NOT_LOGGEDIN") {
							setTimeout(function(){ $(".loggin").modal("show") },100);
						} else if(response["ERROR_CODE"] == "TITLE_BLANK") {
							$(".modal_error_description").html("A pergunta não deve ficar em branco");
							$(".modal_error").modal("show");
						} else if(response["ERROR_CODE"] == "TITLE_TOO_BIG") {
							$(".modal_error_description").html(response["ERROR"]);
							$(".modal_error").modal("show");
						}
					} else {
						if($(".question-title-input").val() == "") insert = "{CLIQUE PARA ADICIONAR UMA PERGUNTA}";
						else insert = $(".question-title-input").val();
						$(".title_edit").addClass("hide");
						$(".question-title-text").removeClass("hide");
						$(".question-title-text").text(insert);
						$(".question-title").attr("data-edit","false");
					}
				});
			}
			function saveTitleA(container) {
				$.post("<?php echo WEB_PATH; ?>ajax/save-to-temp.php", {action:"set-title-a",content:$(".title-a-input").val()}, function(callback) {
					var response = JSON.parse(callback);
					if(response["ERROR"]) {
						if(response["ERROR_CODE"] == "NOT_LOGGEDIN") {
							setTimeout(function(){ $(".loggin").modal("show") },100);
						} else if(response["ERROR_CODE"] == "TITLE_BLANK") {
							$(".modal_error_description").html("A resposta não deve ficar em branco");
							$(".modal_error").modal("show");
						} else if(response["ERROR_CODE"] == "TITLE_TOO_BIG") {
							$(".modal_error_description").text(response["ERROR"]);
							$(".modal_error").modal("show");
						}
					} else {
						if($(".title-a-input").val() == "") insert = "{Clique para adicionar uma opção}";
						else insert = $(".title-a-input").val();
						$(".titleA_edit").addClass("hide");
						$(".title-a-text").removeClass("hide");
						$(".title-a-text").text(insert);
						$(".title-a").attr("data-edit","false");
					}
				});
			}
			function saveTitleB(container) {
				$.post("<?php echo WEB_PATH; ?>ajax/save-to-temp.php", {action:"set-title-b",content:$(".title-b-input").val()}, function(callback) {
					var response = JSON.parse(callback);
					if(response["ERROR"]) {
						if(response["ERROR_CODE"] == "NOT_LOGGEDIN") {
							setTimeout(function(){ $(".loggin").modal("show") },100);
						} else if(response["ERROR_CODE"] == "TITLE_BLANK") {
							$(".modal_error_description").html("A resposta não deve ficar em branco");
							$(".modal_error").modal("show");
						} else if(response["ERROR_CODE"] == "TITLE_TOO_BIG") {
							$(".modal_error_description").text(response["ERROR"]);
							$(".modal_error").modal("show");
						}
					} else {
						if($(".title-b-input").val() == "") insert = "{Clique para adicionar uma opção}";
						else insert = $(".title-b-input").val();
						$(".titleB_edit").addClass("hide");
						$(".title-b-text").removeClass("hide");
						$(".title-b-text").text(insert);
						$(".title-b").attr("data-edit","false");
					}
				});
			}
			$(".post_bt").on("click", function(callback) {
				$.post("<?php echo WEB_PATH; ?>ajax/save-to-temp.php", {action:"save-final"}, function(callback) {
					var response = JSON.parse(callback);
					if(response["ERROR"]) {
						if(response["ERROR_CODE"] == "NOT_LOGGEDIN") {
							setTimeout(function(){ $(".loggin").modal("show") },100);
						} else if(response["ERROR_CODE"] == "NOT_COMPLETE") {
							$(".modal_error_description").text(response["ERROR"]);
							$(".modal_error").modal("show");
						}
					} else {
						window.location.href = "<?php echo WEB_PATH; ?>question/"+response["URL"]+"/new";
					}
				});
			});
			
			$(document).ready(function (e) {
				$("#upload-a, #upload-b").on('submit',(function(e) {
					e.preventDefault();
					$("#message").empty();
					$('#loading').show();
					$.ajax({
						url: "<?php echo WEB_PATH; ?>ajax/photo_up.php", // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
						contentType: false,       // The content type used when sending data to the server.
						cache: false,             // To unable request pages to be cached
						processData:false,        // To send DOMDocument or non processed data file it is set to false
						success: function(data)   // A function to be called if request succeeds
						{
							var response = JSON.parse(data);
							if(response["ERROR"]) {
								$(".modal_error_description").html(response["ERROR_CODE"]);
								$(".modal_error").modal("show");
							} else {
								$('#loading').hide();
								$("#message").html(data);
							}

						}
					});
				}));
				$(function() {
					$(".upload_bt").change(function() {
						$(".uploading").attr("data-uploading",$(this).attr("data-upload"));
						var file = this.files[0];
						var imagefile = file.type;
						var match= ["image/jpeg","image/png","image/jpg"];
						if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))) {
							$(".modal_error_description").html("Escolha um formato de imagem válido, por favor");
							$(".modal_error").modal("show");
							return false;
						}
						else {
							var reader = new FileReader();
							var toupload="a";
							reader.onload = imageIsLoaded;
							reader.readAsDataURL(this.files[0]);
						}
					});
				});
				function imageIsLoaded(e) {
					if($(".uploading").attr("data-uploading") == "a") {
						$('.image-a').attr("src",e.target.result);
						document.getElementById('botao_up_a').click();
					}
					else if($(".uploading").attr("data-uploading") == "b") {
						$('.image-b').attr("src",e.target.result);
						document.getElementById('botao_up_b').click();
					}
				};
			});
		</script>
		
		<div class="ui modal loggin small">
			<i class="close icon"></i>
			<div class="header">
				Conecte-se para criar uma pergunta. É super rápido, prometo!
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