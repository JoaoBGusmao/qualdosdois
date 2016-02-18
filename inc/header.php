<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-24355935-13', 'auto');
  ga('send', 'pageview');

</script>
<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=521118841399375";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

		<div class="line"></div>	
		<div class="ui top fixed menu">
			<div class="ui container">
				<div class="item" style="width: 50%;max-width: 270px;">
					<a href="<?php echo WEB_PATH; ?>"><img src="<?php echo WEB_PATH; ?>assets/img/q.png" style="width: 100%;"></a>
				</div>
				<a href="<?php echo WEB_PATH; ?>new" class="item right new_question">Criar uma pergunta</a>
				<?php if(isset($_SESSION["login_provider"])) { ?>
					<div class="ui item right inline dropdown" style="margin-left: 0 !important">
						<div class="text">
							<img class="ui avatar image" src="<?php if($_SESSION["login_provider"] == "G") echo $_SESSION["picture"]; else if($_SESSION["login_provider"] == "FB") echo "https://graph.facebook.com/".$_SESSION['id']."/picture" ?>">
							<?php echo $_SESSION["name"]; ?>
						</div>
						<i class="dropdown icon"></i>
						<div class="menu">
							<a class="item" href="<?php echo WEB_PATH; ?>me">Minhas Perguntas</a>
							<a class="item" href="<?php echo WEB_PATH; ?>logout">Log Out</a>
						</div>
					</div>
					<script>$('.ui.dropdown').dropdown();</script>
				<?php } ?>
			</div>
		</div>