<?php
	session_start();
	
	if(isset($_POST['liczba']))
	{
		//udana walidacja
				$wszystko_OK=true;
				$nick = $_POST['nick'];
				$woj=$_POST['woj'];
				$haslo=$_POST['haslo'];
				$iledzieci=$_POST['liczba'];

		if ((strlen($nick)<3) || (strlen($nick)>20)){
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 15 znaków!";	
		}
		if (ctype_alnum($nick)==false){
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter (bez polskich znaków) i cyfr!";			
		}
		if (strlen($haslo)<7){
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło za krótkie!";	
		}	
			$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
			
		if(!is_numeric($iledzieci)){
			$wszystko_OK=false;
			$_SESSION['e_ldzieci']="Wybierz liczbe dzieci!";	
			}
		//Checkxbox
		if(!isset($_POST['regulamin'])){
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdz regulamin!";	
			}

		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try{
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); 	
				if($polaczenie->connect_errno!=0){
					throw new Exception(mysqli_connect_errno());
				}
				else{
					//czy login juz istnieje
					$rezultat=$polaczenie->query("SELECT ID_user FROM uzytkownicy WHERE Nick='$nick'");
					if(!$rezultat) throw new Exception($polaczenie->error);
					$ile_loginow = $rezultat->num_rows;
					if($ile_loginow>0){
							$wszystko_OK=false;
							$_SESSION['e_nick']="Podany login juz istnieje! Podaj inny!";	
					}
			
			//wsio ok	
			if($wszystko_OK==true){

				switch($woj){
				case "dolnośląskie":
				$idwojew=1;
				break;
				case "kujawsko-pomorskie":
				$idwojew=2;
				break;
				case "małopolskie":
				$idwojew=3;
				break;
				case "łódzkie":
				$idwojew=4;
				break;
				case "wielkopolskie":
				$idwojew=5;
				break;
				case "lubelskie":
				$idwojew=6;
				break;
				case "lubuskie":
				$idwojew=7;
				break;
				case "mazowieckie":
				$idwojew=8;
				break;
				case "opolskie":
				$idwojew=9;
				break;
				case "podlaskie":
				$idwojew=10;
				break;
				case "pomorskie":
				$idwojew=11;
				break;
				case "śląskie":
				$idwojew=12;
				break;
				case "podkarpackie":
				$idwojew=13;
				break;
				case "świętokrzyskie":
				$idwojew=14;
				break;
				case "warmińsko-mazurskie":
				$idwojew=15;
				break;
				case "zachodniopomorskie":
				$idwojew=16;
				break;
				}
				
				///Tworzenie ID dla uzytkownika///
				$IDusera=$polaczenie->query("SELECT ID_user FROM uzytkownicy ORDER BY ID_user DESC");
				$wiersze = $IDusera->fetch_assoc();
				$ostatnieid=$wiersze['ID_user']+1;
					
				 ///Tworzenie ID dla dziecka///
				$IDdziecka=$polaczenie->query("SELECT ID_dziecko FROM dziecko ORDER BY ID_dziecko DESC");
				$wierszedziecka=$IDdziecka->fetch_assoc();
				
				
				///Petla do sprawdzania ostatniego ID dziecka///
				for($i=1;$i<=$iledzieci;$i++){
				$ostatnieiddziecka[$i]=$wierszedziecka['ID_dziecko']+$i;
				}
				
				////Petla za duzego switcha///
				for($i=1;$i<=$iledzieci;$i++){
				$j=$i-1;
				$kwota[$i]=$_POST['kwota'.$j]; 
				$szkola[$i]=$_POST["szkola".$j];
				}
				
				
				$ilosc="SELECT Liczba_dzieci FROM uzytkownicy WHERE Nick='$nick'";
				if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,  '$nick', '$haslo_hash', '$iledzieci', '$idwojew')")){
				for($i=1; $i<=$iledzieci; $i++){
					($polaczenie->query("INSERT INTO dziecko VALUES(NULL, '$ostatnieid')"))&&
					($polaczenie->query("INSERT INTO szkola VALUES(NULL, '$ostatnieiddziecka[$i]','$szkola[$i]')"))&&
					($polaczenie->query("INSERT INTO kwota VALUES(NULL, '$kwota[$i]', '$ostatnieiddziecka[$i]')"));
				}
				///Ile dzieci po rejestracji///
				$wyniczek= @$polaczenie->query($ilosc);
				$wierszyk=$wyniczek->fetch_assoc();
				$_SESSION['Iledzieci']=$wierszyk['Liczba_dzieci'];

					$wyniczek->free_result();
					$rezultat->free_result();
					$IDusera->free_result();
					$IDdziecka->free_result();
					$_SESSION['udalosie']=true;
				

				header('Location: udanarejestracaja.php');
				}
			else{
				throw new Exception($polaczenie->error);
			}}
					$polaczenie->close();
				}}
		catch(Exception $wyjatek){
			echo '<script>alert("Problem z serwerem, spróbuj później.")</script>';
			echo '<br />Info dev: '.$wyjatek;
		}}
	

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>jakiekieszonkowe.pl - Rejestracja</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<meta name="description" content="Serwis pokazujący średnie kieszonkowe dla dziecka pod względem regioniu albo poziomu szkoły, do której uczęszcza. Nie wiesz czy twoje dziecko dostaje dobre kieszonkowe? Sprawdź szybko u nas jaka jest średnia!" />
	<meta name="keywords" content="kieszonkowe, dziecko, średnia, region, jakie, ile dzieci, ile dać dziecku, szkoła podstawowa, liceum, technikum, studia, szkoła zawodowa, przedszkole siema jestem michal" />

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
		<div class="singlecon">
			<form method="post">
				
				<div class="row">
					<label for="nick">Login:</label>
					<input id="nick" type="text" name="nick" >
					<?php
							if (isset($_SESSION['e_nick']))
							{
								echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
								unset($_SESSION['e_nick']);
							}
					?>
				</div>
				<div class="row">
					<label for="password">Hasło:</label>
					<input id="password" type="password" name="haslo">
					<?php
						if (isset($_SESSION['e_haslo']))
						{
							echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
								unset($_SESSION['e_haslo']);
						}
					?>
						
				</div>
				<div class="row">
				<label for="region">Województwo:</label>
				<select id="region" class="custom-select" name="woj">
					<option>dolnośląskie</option>
					<option>kujawsko-pomorskie</option>
					<option>lubelskie</option>
					<option>lubuskie</option>
					<option>łódzkie</option>
					<option>małopolskie</option>
					<option>mazowieckie</option>
					<option>opolskie</option>
					<option>podkarpackie</option>
					<option>podlaskie</option>
					<option>pomorskie</option>
					<option>śląskie</option>
					<option>świętokrzyskie</option>
					<option>warmińsko-mazurskie</option>
					<option>wielkopolskie</option>
					<option>zachodniopomorskie</option>
				</select>

				</div>
				<div class="row">
					<label for="ld">Ile dzieci:</label>
					<select class="custom-select" name="liczba" id="ld"  onchange="ilebachorow()">
						<option>Wybierz</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
					</select>
					<?php
							if (isset($_SESSION['e_ldzieci']))
							{
								echo '<div class="error">'.$_SESSION['e_ldzieci'].'</div>';
								unset($_SESSION['e_ldzieci']);
							}
					?>
				</div>
			
				<div id="listaDodawaniaDzieci"></div>
				
				
				<div class="row">
					
						<input type="checkbox" name="regulamin">
						 <div id="regulamin">Akceptuję regulamin</div><br/>
						<input type="submit" value="Stwórz konto">
					<?php
							if (isset($_SESSION['e_regulamin']))
							{
								echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
								unset($_SESSION['e_regulamin']);
							}
					?>
				</div>
		</form>
	</div>
	</section>
</main>
</div>
<footer>
	Wszelkie prawa zastrzeżone &copy 2019
</footer>


<script src="src/dodajdzieci.js"></script>

</body>
</html>