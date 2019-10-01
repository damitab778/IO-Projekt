<?php
	session_start();
	if(!isset($_SESSION['udalosie'])){
		header('Location=index.php');
		exit();
	}
	else{
		unset($_SESSION['udalosie']);
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	
	
	<link href="style.css" rel="stylesheet" type="text/css"/>
	<link href="timer.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Baloo&amp;subset=latin-ext" rel="stylesheet">
	
</head>

<body>
	<audio src="swinka.wav" id="sound"></audio>
	<div class="container">
		<div class="textcon">
			<h2>Udało się!</h2>
			<h3>Dziękujemy za rejestrację</h3>

			<div class=""><a href="index.php">[Zaloguj się na swoje nowe konto klikając tu]</a><br>lub zostaniesz automatycznie przeniesiony za:</div>
		</div>
			<div class="countdown" id="countdown">	
				<div class="countdown__fill" id="ticker">
				</div>
					
				<div class="countdown__digit" id="seconds">0</div>
				
			</div>
		</div>
</body>
<script src="src/hammer.min.js"></script>
<script src="src/timer.js"></script>
<script src="src/redirect.js"></script>

</html>

