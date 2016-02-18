<?php
	require_once("class.connection.php");
	
	class question {
		private $title;
		private $title_a;
		private $votes_a;
		private $image_a;
		private $title_b;
		private $votes_b;
		private $image_b;
		private $url;
		private $clean_url;
		
		public function loadQuestion($url) {
			$b = connection::getInstance()->prepare("SELECT * FROM questions WHERE url=:url");
			$b->bindParam(":url",$url);
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null) {
				throw new Exception('NOT_FOUND');
			}
			
			$this->title = $resColumn[0]["title"];
			$this->title_a = $resColumn[0]["title_a"];
			$this->votes_a = $resColumn[0]["votes_a"];
			$this->image_a = $resColumn[0]["image_a"];
			$this->title_b = $resColumn[0]["title_b"];
			$this->votes_b = $resColumn[0]["votes_b"];
			$this->image_b = $resColumn[0]["image_b"];
			$this->url = $resColumn[0]["url"];
		}
		
		public function getTitle() {
			return $this->title;
		}
		public function getTitleA() {
			return $this->title_a;
		}
		public function getVotesA() {
			return $this->votes_a;
		}
		public function getImageA() {
			return $this->image_a;
		}
		
		public function getTitleB() {
			return $this->title_b;
		}
		public function getVotesB() {
			return $this->votes_b;
		}
		public function getImageB() {
			return $this->image_b;
		}
		
		public function getUrl() {
			return $this->url;
		}
		
		public function setTitle($title) {
			$this->title = $title;
		}
		public function setTitleA($titleA) {
			$this->title_a = $titleA;
		}
		public function setVotesA($votesA) {
			$this->votes_a = $votesA;
		}
		public function setImageA($imageA) {
			$this->image_a = $imageA;
		}
		public function setTitleB($titleB) {
			$this->title_b = $titleB;
		}
		public function setVotesB($votesA) {
			$this->votes_b = $votesB;
		}
		public function setImageB($imageB) {
			$this->image_b = $imageB;
		}
		
		public function increaseVote($vote,$userId,$name,$email) {
			$b = connection::getInstance()->prepare("SELECT count(*) as qtd FROM votes WHERE url=:url and user=:user");
			$b->bindValue(":url",$this->url);
			$b->bindValue(":user",$userId);
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null || $resColumn[0]["qtd"] != "0") return json_encode(array("ERROR"=>"true","ERROR_CODE"=>"INVALID_VOTE","ERROR_TEXT"=>"Você já escolheu uma resposta nesta pergunta!"));
			if($vote == "a") {
				$newVote = "UPDATE questions SET votes_a = votes_a +1 WHERE url=:url";
			} else if($vote == "b") {
				$newVote = "UPDATE questions SET votes_b = votes_b +1 WHERE url=:url";
			} else {
				return json_encode(array("ERROR"=>"true","ERROR_CODE"=>"INVALID_VOTE","ERROR_TEXT"=>"Voto inválido"));
			}
			$b = connection::getInstance()->prepare($newVote);
			$b->bindParam(":url",$this->url);
			$b->execute();
			
			$insert = "INSERT INTO votes (url,user,vote,name,email) VALUES (:url,:user,:vote,:name,:email)";
			$c = connection::getInstance()->prepare($insert);
			$c->bindParam(":url",$this->url);
			$c->bindParam(":user",$userId);
			$c->bindParam(":vote",$vote);
			$c->bindParam(":name",$name);
			$c->bindParam(":email",$email);
			$c->execute();
			
			$this->loadQuestion($this->url);
			return json_encode( array("SUCCESS"=>"true","votes_a"=>$this->votes_a,"votes_b"=>$this->votes_b) );
		}
		
		public function decreaseVote($vote,$userId) {
			$b = connection::getInstance()->prepare("SELECT count(*) as qtd FROM votes WHERE url=:url and user=:user");
			$b->bindValue(":url",$this->url);
			$b->bindValue(":user",$userId);
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null || $resColumn[0]["qtd"] == "0") return json_encode(array("ERROR"=>"true","ERROR_CODE"=>"INVALID_VOTE","ERROR_TEXT"=>"Voto não encontrado"));
			if($vote == "a") {
				$newVote = "UPDATE questions SET votes_a = votes_a -1 WHERE url=:url";
			} else if($vote == "b") {
				$newVote = "UPDATE questions SET votes_b = votes_b -1 WHERE url=:url";
			} else {
				return json_encode(array("ERROR"=>"true","ERROR_CODE"=>"INVALID_VOTE","ERROR_TEXT"=>"Voto inválido"));
			}
			$b = connection::getInstance()->prepare($newVote);
			$b->bindParam(":url",$this->url);
			$b->execute();
			
			$insert = "DELETE FROM votes WHERE url=:url and user=:user";
			$c = connection::getInstance()->prepare($insert);
			$c->bindParam(":url",$this->url);
			$c->bindParam(":user",$userId);
			$c->execute();
			
			$this->loadQuestion($this->url);
			return json_encode( array("SUCCESS"=>"true","votes_a"=>$this->votes_a,"votes_b"=>$this->votes_b) );
		}
		
		public function hasVoted($userId,$vote) {
			$userId = $_SESSION["login_provider"]."_".$_SESSION["id"];
			$b = connection::getInstance()->prepare("SELECT count(*) as qtd FROM votes WHERE url=:url and user=:user and vote=:vote");
			$b->bindValue(":url",$this->url);
			$b->bindValue(":user",$userId);
			$b->bindValue(":vote",$vote);
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null || $resColumn[0]["qtd"] != "0") return true;
			return false;
		}
		
		public function saveQuestion() {
			$author = $_SESSION["login_provider"]."_".$_SESSION["id"];
			$this->url = $this->generateUrl(false);
			$this->clean_url = $this->generateUrl(true);
			if(!isset($this->image_a)) $this->image_a = "default_image";
			if(!isset($this->image_b)) $this->image_b = "default_image";
			$b = connection::getInstance()->prepare("INSERT INTO questions (title,title_a,image_a,title_b,image_b,author,url,clean_url) VALUES (:title,:title_a,:image_a,:title_b,:image_b,:author,:url,:clean_url)");
			$b->bindParam(":title",$this->title);
			$b->bindParam(":title_a",$this->title_a);
			$b->bindParam(":image_a",$this->image_a);
			$b->bindParam(":title_b",$this->title_b);
			$b->bindParam(":image_b",$this->image_b);
			$b->bindParam(":author",$author);
			$b->bindParam(":url",$this->url);
			$b->bindParam(":clean_url",$this->clean_url);
			$success = $b->execute();
			if($success) return json_encode( array("SUCCESS"=>"true","URL"=>$this->url) );
			else return json_encode( array("ERROR"=>"true") );
		}
		
		public function generateUrl($clean) {
			$string2 = $this->title;
			$string = strtolower($string2);
			$string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
			$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
			$string = str_replace('--', '-', $string); // Replaces all spaces with hyphens.

			$string = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string ) );
			$finalUrl = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
			if($clean) return $finalUrl;
			$b = connection::getInstance()->prepare("SELECT count(*) as qtd FROM questions WHERE clean_url=:url");
			$b->bindValue(":url",$finalUrl);
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null) {
				return $finalUrl;
			} else {
				if($resColumn[0]["qtd"] != "0") return $finalUrl."-".(intval($resColumn[0]["qtd"]+1));
				else return $finalUrl;
			}
		}
		
		public function getQuestionsByUser($userId) {
			$author = $_SESSION["login_provider"]."_".$userId;
			$b = connection::getInstance()->prepare("SELECT title,(votes_a+votes_b) as votes,url FROM questions WHERE author=:user order by date desc");
			$b->bindParam(":user",$author);
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null) {
				return null;
			}
			return $resColumn;
		}
		
		public function getLatest() {
			$b = connection::getInstance()->prepare("SELECT title,(votes_a+votes_b) as votes,url FROM questions order by date desc LIMIT 5");
			$b->bindParam(":user",$author);
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null) {
				return null;
			}
			return $resColumn;
		}
		
		public function getTopQuestions() {
			$b = connection::getInstance()->prepare("SELECT title,(votes_a+votes_b) as votes,url FROM questions order by votes desc LIMIT 5");
			$b->bindParam(":user",$author);
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null) {
				return null;
			}
			return $resColumn;
		}
		
		public function getAmount($type) {
			$b = connection::getInstance()->prepare("SELECT count(*) as count FROM $type");
			$b->execute();
			$resColumn = $b->fetchAll();
			
			if($resColumn == null) {
				return null;
			}
			return $resColumn[0]["count"];
		}
	}