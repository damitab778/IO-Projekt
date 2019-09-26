<?php
	session_start();
	if(!isset($_SESSION['zalogowany'])){ header('Location: index.php');
	exit();
	}
		
				
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>jakiekieszonkowe.pl - Rejestracja</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<meta name="description" content="Serwis pokazujący średnie kieszonkowe dla dziecka pod względem regioniu albo poziomu szkoły, do której uczęszcza. Nie wiesz czy twoje dziecko dostaje dobre kieszonkowe? Sprawdź szybko u nas jaka jest średnia!" />
	<meta name="keywords" content="kieszonkowe, dziecko, średnia, region, jakie, ile dzieci, ile dać dziecku, szkoła podstawowa, liceum, technikum, studia, szkoła zawodowa, przedszkole" />

	<link href="style.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Baloo&amp;subset=latin-ext" rel="stylesheet">

</head>
<body>
	<div class="status">
		<div class="zalogowanyjako"><?php echo$_SESSION['Nick'];?></div>
	</div>
	<header>
		<div class="logo">
		<a href="index.php">
			<img src="img/pig.jpg" style="float: left;"/>
			<div class="logotext"><span style="color: #00aa96">jakie</span>kieszonkowe.pl</div>
			<div style="clear:both;"></div>
		</a>
		</div>
	
	
        <nav>
		<ul>
			<li><a href="konto.php">Moje konto</a></li>
			<li><a href="statystyki.php">Statystyki</a></li>
			<li><a href="wyloguj.php" class="linknav">Wyloguj</a></li>
		</ul>
	</nav>
    </header>
<div class="container">
<main>
	<section>
		<div class="singlecon">
			<div class="title">
				Statystyki - Średnie arytmetyczne dla:
			</div>
			<div class="features-wrapper">
				<div class="feature-item">
					<div class="image">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24.001px" viewBox="0 0 24 24.001" enable-background="new 0 0 24 24.001" xml:space="preserve">
						<g id="Frames-24px">
						<rect fill="none" width="24" height="24.001"/>
						<rect fill="none" width="24" height="24.001"/>
						</g>
						<g id="Outline">
						<g>
						<g>
						<path fill="#757575" d="M12.001,6.002c-1.654,0-3-1.346-3-3s1.346-3,3-3s3,1.346,3,3S13.655,6.002,12.001,6.002z M12.001,2.002c-0.551,0-1,0.449-1,1c0,0.552,0.449,1,1,1s1-0.448,1-1C13.001,2.451,12.552,2.002,12.001,2.002z"/>
						</g>
						<g>
						<path fill="#757575" d="M14.001,20.002h-4c-0.552,0-1-0.448-1-1v-4h-1c-0.552,0-1-0.448-1-1v-2c0-2.757,2.243-5,5-5s5,2.243,5,5v2c0,0.552-0.448,1-1,1h-1v4C15.001,19.555,14.553,20.002,14.001,20.002z M11.001,18.002h2v-4c0-0.552,0.448-1,1-1h1v-1c0-1.654-1.346-3-3-3s-3,1.346-3,3v1h1c0.552,0,1,0.448,1,1V18.002z"/>
						</g>
						<g>
						<path fill="#757575" d="M12.001,24.002c-4.816,0-10-1.251-10-4c0-0.969,0.667-2.317,3.841-3.232l0.555,1.922c-1.979,0.571-2.396,1.208-2.396,1.31c0,0.515,2.75,2,8,2s8-1.485,8-2c0-0.096-0.389-0.704-2.239-1.264l0.58-1.914c3.024,0.915,3.659,2.233,3.659,3.177C22.001,22.751,16.817,24.002,12.001,24.002z"/>
						</g>
						</g>
						</g>
						</svg>
					</div>
					<div class="title">
						Ilość dzieci (<?php echo $_SESSION['iloscbach'] ?>)
					</div>
					<div class="value">
						<?php echo round($_SESSION['AVG(kwota)2'],  2)?> zł
					</div>
				</div>
				<div class="feature-item">
					<div class="image">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
	 height="24.001px" viewBox="0 0 24 24.001" enable-background="new 0 0 24 24.001" xml:space="preserve">
<g id="Frames-24px">
	<rect fill="none" width="24" height="24.001"/>
	<rect fill="none" width="24" height="24.001"/>
</g>
<g id="Outline">
	<g>
		<g>
			<path fill="#757575" d="M12.001,18.002c-0.392,0-0.748-0.229-0.91-0.586c-0.683-1.5-4.09-9.104-4.09-11.414c0-2.757,2.243-5,5-5
				s5,2.243,5,5c0,2.31-3.406,9.914-4.09,11.414C12.75,17.774,12.394,18.002,12.001,18.002z M12.001,3.002c-1.654,0-3,1.346-3,3
				c0,1.183,1.593,5.261,3,8.527c1.408-3.267,3-7.345,3-8.527C15.001,4.348,13.656,3.002,12.001,3.002z"/>
		</g>
		<g>
			<circle class="green" fill="#757575" cx="12.001" cy="6.002" r="1.5"/>
		</g>
		<g>
			<path fill="#757575" d="M19.485,21.002H4.518c-0.673,0-1.296-0.335-1.669-0.898c-0.373-0.566-0.435-1.272-0.168-1.891
				l2.142-4.998c0.314-0.736,1.036-1.212,1.838-1.212h0.824v2H6.661l-2.143,5h14.967l-2.143-5h-0.857v-2h0.857
				c0.802,0,1.523,0.476,1.838,1.213l2.142,4.999c0.266,0.617,0.204,1.323-0.168,1.888C20.782,20.667,20.158,21.002,19.485,21.002z"
				/>
		</g>
	</g>
</g>
</svg>
					</div>
					<div class="title">
						Województwo
					</div>
					<div class="value">
						<?php echo round($_SESSION['AVG(kwota)'],  2)?> zł
					</div>
				</div>
				<div class="feature-item">
					<div class="image">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
	 height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
<g id="Frames-24px">
	<rect fill="none" width="24" height="24"/>
</g>
<g id="Solid">
	<g>
		<path fill="#757575" d="M6,4C4.346,4,3,5.346,3,7v11.303l3,4.5l3-4.5V7C9,5.346,7.654,4,6,4z M7,17.697l-1,1.5l-1-1.5V10h2V17.697
			z M5,8V7c0-0.552,0.449-1,1-1s1,0.448,1,1v1H5z"/>
		<path fill="#757575" d="M19,1h-6c-1.103,0-2,0.898-2,2v18c0,1.103,0.897,2,2,2h6c1.103,0,2-0.897,2-2V3C21,1.898,20.103,1,19,1z
			 M13,21v-3h3v-2h-3v-3h3v-2h-3V8h3V6h-3V3h6l0.001,18H13z"/>
	</g>
</g>
</svg>

					</div>
					<div class="title">
						Podstawówka
					</div>
					<div class="value">
						<?php echo round($_SESSION['AVG(kwota)4'],  2)?> zł
					</div>
				</div>
				<div class="feature-item">
					<div class="image">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
	 height="24.001px" viewBox="0 0 24 24.001" enable-background="new 0 0 24 24.001" xml:space="preserve">
<g id="Frames-24px">
	<rect y="0" fill="none" width="24" height="24.001"/>
</g>
<g id="Outline">
	<g>
		
		<path fill="#757575" d="M20.999,12h-3V4c0-0.552-0.448-1-1-1h-2V2c0-0.552-0.448-1-1-1h-4c-0.552,0-1,0.448-1,1v1h-2
			c-0.552,0-1,0.448-1,1v8h-3c-0.552,0-1,0.448-1,1v8c0,0.552,0.448,1,1,1h18c0.552,0,1-0.448,1-1v-8
			C21.999,12.448,21.551,12,20.999,12z M19.999,20h-6v-2h-4v2h-6v-6h3c0.552,0,1-0.448,1-1V5h2c0.552,0,1-0.448,1-1V3h2v1
			c0,0.552,0.448,1,1,1h2v8c0,0.552,0.448,1,1,1h3V20z"/>
		<rect class="green" x="8.999" y="7" fill="#757575" width="2" height="2"/>
		<rect class="green" x="12.999" y="7" fill="#757575" width="2" height="2"/>
		<rect class="green" x="8.999" y="11" fill="#757575" width="2" height="2"/>
		<rect class="green" x="12.999" y="11" fill="#757575" width="2" height="2"/>
		<rect class="green" x="4.999" y="15" fill="#757575" width="2" height="2"/>
		<rect class="green" x="8.999" y="15" fill="#757575" width="2" height="2"/>
		<rect class="green" x="12.999" y="15" fill="#757575" width="2" height="2"/>
		<rect class="green" x="16.999" y="15" fill="#757575" width="2" height="2"/>
	</g>
</g>
</svg>
					</div>
					<div class="title">
						Gimnazjum
					</div>
					<div class="value">
						<?php echo round($_SESSION['AVG(kwota)3'],  2)?> zł
					</div>
				</div>
				<div class="feature-item">
					<div class="image">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
	 height="24.001px" viewBox="0 0 24 24.001" enable-background="new 0 0 24 24.001" xml:space="preserve">
<g id="Frames-24px">
	<rect y="0" fill="none" width="24" height="24.001"/>
</g>
<g id="Outline">
	<path fill="#757575" d="M21.949,19.685l-1-3c-0.136-0.408-0.518-0.684-0.949-0.684h-1v-7h1c0.552,0,1-0.448,1-1v-2
		c0-0.417-0.259-0.79-0.649-0.937l-8-3c-0.227-0.085-0.476-0.085-0.702,0l-8,3C3.259,5.211,3,5.585,3,6.001v2c0,0.552,0.448,1,1,1h1
		v7H4c-0.431,0-0.813,0.276-0.949,0.684l-1,3c-0.102,0.305-0.05,0.641,0.138,0.902S2.679,21.001,3,21.001h18
		c0.321,0,0.623-0.154,0.811-0.415S22.051,19.99,21.949,19.685z M17,16.001h-2v-7h2V16.001z M13,9.001v7h-2v-7H13z M5,6.695l7-2.625
		l7,2.625v0.306H5V6.695z M7,9.001h2v7H7V9.001z M4.388,19.001l0.333-1H19.28l0.333,1H4.388z"/>
</g>
</svg>
					</div>
					<div class="title">
						Szkoła średnia
					</div>
					<div class="value">
						<?php echo round($_SESSION['AVG(kwota)5'],  2)?> zł
					</div>
				</div>
				<div class="feature-item">
					<div class="image">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px"
	 height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
<g id="Frames-24px">
	<rect fill="none" width="24" height="24"/>
</g>
<g id="Solid">
	<g>
		<path fill="#757575" d="M22.447,7.105l-10-5c-0.281-0.141-0.613-0.141-0.895,0l-10,5c-0.201,0.1-0.354,0.273-0.445,0.463
			C1.047,7.69,1,7.898,1,8v5.765c0,0.551,0.448,1,1,1s1-0.449,1-1V9.478l2,0.8v4.903c0,0.379,0.214,0.725,0.553,0.895
			c1.719,0.859,3.486,1.919,6.447,1.919s4.729-1.061,6.447-1.919C18.786,15.905,19,15.56,19,15.181v-4.903l3.372-1.349
			c0.365-0.146,0.611-0.493,0.627-0.887C23.016,7.648,22.799,7.283,22.447,7.105z M17,14.563l-0.975,0.487
			c-2.521,1.261-5.53,1.261-8.05,0L7,14.563v-3.485l4.628,1.852C11.748,12.978,11.874,13,12,13s0.252-0.022,0.372-0.071L17,11.077
			V14.563z M12,10.923L4.439,7.898L12,4.119l7.561,3.779L12,10.923z"/>
		<path fill="#757575" d="M2,16c-0.552,0-1,0.448-1,1v2c0,0.553,0.448,1,1,1s1-0.447,1-1v-2C3,16.448,2.552,16,2,16z"/>
	</g>
</g>
</svg>
					</div>
					<div class="title">
						Szkoła wyższa
					</div>
					<div class="value">
						<?php echo round($_SESSION['AVG(kwota)6'],  2)?> zł
					</div>
				</div>
			</div>
			<div class="stat-info">Statystyki dla różnych szkół liczone są z rodzicami mającymi tyle samo dzieci.</div>

			<div id="mapa">
				<img src="img/poland-map.png">
			</div>
		</div>
	</section>
</main>
</div>
<footer>
	Wszelkie prawa zastrzeżone &copy 2019
</footer>

</body>
</html>

