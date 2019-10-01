<?php
	session_start();
	if((isset($_SESSION['zalogowany'])) && $_SESSION['zalogowany']==true){
		header('Location: konto.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>jakiekieszonkowe.pl - Strona Główna</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<meta name="description" content="Serwis pokazujący średnie kieszonkowe dla dziecka pod względem regioniu albo poziomu szkoły, do której uczęszcza. Nie wiesz czy twoje dziecko dostaje dobre kieszonkowe? Sprawdź szybko u nas jaka jest średnia!" />
	<meta name="keywords" content="kieszonkowe, dziecko, średnia, region, jakie, ile dzieci, ile dać dziecku, szkoła podstawowa, liceum, technikum, studia, szkoła zawodowa, przedszkole" />

	<link href="style.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Baloo&amp;subset=latin-ext" rel="stylesheet">

</head>
<body>
	<div class="status">
		<div class="zalogowanyjako">Niezalogowany</div>
	</div>
	<header>
		<div class="logo">
		<a href="index.php">
			<img src="img/pig.jpg" style="float: left;"/>
			<div class="logotext"><span style="color: #00aa96">jakie</span>kieszonkowe.pl</div>
			<div style="clear:both;"></div>
		</a>
		</div>
	
	
	<nav><br/></nav>
	</header>
	<div class="container">
<main>
	
	<section>
		<div class="zarejestruj">
			<p>
				Masz problem z określeniem kieszonkowego dla swojej pociechy? <br/><span class="zielony">Zastanawiasz się ile dać podwyżki swojemu dziecku, ale nie masz z czym porównać?</span> <br/>A może twój młody przedstawiciel rodu już studiuję i potrzebuje pieniędzy?
				<br/> <span class="zielony">Tutaj porównasz kieszonkowe swoich smarkaczy z rodzicami innych smarkaczy.</span><br/> Zarejestruj się łatwo i szybko, aby sprawdzić średnią!<br/>
				<a href="rejestracja.php">
					<input type="submit" value="Zarejestruj się">
				</a>
			</p>
		</div>
	</section>

	<section>
	<div class="logowanie">
		<h3>Zaloguj się i sprawdź jakie kieszonkowe dają inni rodzice!</h3>
		<form class="form_logowanie" action="zaloguj.php" method="post">
			Login<br/>
			<input type="text" name="login">
			<br/>
			Hasło<br/>
			<input type="password" name="haslo">
			<br/>
			<input type="submit" value="Zaloguj się">
		</form>
		<a href="rejestracja.php" class="linkprosty">Nie masz konta? Zarejestruj się!</a>
		<?php
		if(isset($_SESSION['blad']))
			echo $_SESSION['blad'];
		?>
		</div>
	</section>

</main>
</div>
<footer>
	Wszelkie prawa zastrzeżone &copy 2019
</footer>
</body>
</html>