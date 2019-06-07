<?php
	session_start();
	
	if(isset($_POST['liczba']))
	{
		//udana walidacja
		$wszystko_OK=true;
		//poparawniosc loginu
				$nick = $_POST['nick'];
			
		//sprawdzenie dlugosci nicka
		if ((strlen($nick)<3) || (strlen($nick)>20)){
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 15 znaków!";	
		}
			//znaki
		if (ctype_alnum($nick)==false){
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter (bez polskich znaków) i cyfr!";			
		}
			//haslo 
			$haslo=$_POST['haslo'];
				
		if (strlen($haslo)<7){
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło za krótkie!";	
		}	
			$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
		
		//Ilosc dzieci
			$iledzieci=$_POST['liczba'];
		if(!is_numeric($iledzieci)){
			$wszystko_OK=false;
			$_SESSION['e_ldzieci']="Podaj liczbe dzieci wpisując odpowiedni numer";	
			}
			
			if($iledzieci==0){
			$wszystko_OK=false;
			$_SESSION['e_ldzieci']="Strona przeznaczona, dla opiekunów z dziecmi!";	
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
				$zapytanieII="SELECT * FROM uzytkownicy WHERE Nick='$nick'";
					
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
			$woj=$_POST['woj'];
			//wsio ok	
			if($wszystko_OK==true){
			
			
			/*////Petla za duzego switcha ale cos nie dziala///
				for($i=1;$i<=$iledzieci;$i++){
				$kwota[$i]=$_POST["kwota.'$i'"]; // <- problem 
				$szkola[$i]=$_POST["szkola.'$i'"];
				}*/
					
					$IDusera=$polaczenie->query("SELECT ID_user FROM uzytkownicy ORDER BY ID_user DESC");
					$wiersze = $IDusera->fetch_assoc();
					$ostatnieid=$wiersze['ID_user']+1;
					
					$IDdziecka=$polaczenie->query("SELECT ID_dziecko FROM dziecko ORDER BY ID_dziecko DESC");
					$wierszedziecka=$IDdziecka->fetch_assoc();
					
				switch($woj){
				case "dolnoślaskie":
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
				
					
				for($i=1;$i<=$iledzieci;$i++){
				$ostatnieiddziecka[$i]=$wierszedziecka['ID_dziecko']+$i;
				}
				
				
				switch($iledzieci){
				case 1:
				$kwota[1]=$_POST['kwota0'];        
				$szkola[1]=$_POST['szkola0'];
				break;
				case 2:
				$kwota[1]=$_POST['kwota0'];
				$szkola[1]=$_POST['szkola0'];
				$kwota[2]=$_POST['kwota1'];
				$szkola[2]=$_POST['szkola1'];
				break;
				case 3:
				$kwota[1]=$_POST['kwota0'];
				$szkola[1]=$_POST['szkola0'];
				$kwota[2]=$_POST['kwota1'];
				$szkola[2]=$_POST['szkola1'];
				$kwota[3]=$_POST['kwota2'];
				$szkola[3]=$_POST['szkola2'];
				break;
				case 4:
				$kwota[1]=$_POST['kwota0'];
				$szkola[1]=$_POST['szkola0'];
				$kwota[2]=$_POST['kwota1'];
				$szkola[2]=$_POST['szkola1'];
				$kwota[3]=$_POST['kwota2'];
				$szkola[3]=$_POST['szkola2'];
				$kwota[4]=$_POST['kwota3'];
				$szkola[4]=$_POST['szkola3'];
				break;
				case 5:
				$kwota[1]=$_POST['kwota0'];
				$szkola[1]=$_POST['szkola0'];
				$kwota[2]=$_POST['kwota1'];
				$szkola[2]=$_POST['szkola1'];
				$kwota[3]=$_POST['kwota2'];
				$szkola[3]=$_POST['szkola2'];
				$kwota[4]=$_POST['kwota3'];
				$szkola[4]=$_POST['szkola3'];
				$kwota[5]=$_POST['kwota4'];
				$szkola[5]=$_POST['szkola4'];
				break;
				case 6:
				$kwota[1]=$_POST['kwota0'];
				$szkola[1]=$_POST['szkola0'];
				$kwota[2]=$_POST['kwota1'];
				$szkola[2]=$_POST['szkola1'];
				$kwota[3]=$_POST['kwota2'];
				$szkola[3]=$_POST['szkola2'];
				$kwota[4]=$_POST['kwota3'];
				$szkola[4]=$_POST['szkola3'];
				$kwota[5]=$_POST['kwota4'];
				$szkola[5]=$_POST['szkola4'];
				$kwota[6]=$_POST['kwota5'];
				$szkola[6]=$_POST['szkola5'];
				break;
				case 7:
				$kwota[1]=$_POST['kwota0'];
				$szkola[1]=$_POST['szkola0'];
				$kwota[2]=$_POST['kwota1'];
				$szkola[2]=$_POST['szkola1'];
				$kwota[3]=$_POST['kwota2'];
				$szkola[3]=$_POST['szkola2'];
				$kwota[4]=$_POST['kwota3'];
				$szkola[4]=$_POST['szkola3'];
				$kwota[5]=$_POST['kwota4'];
				$szkola[5]=$_POST['szkola4'];
				$kwota[6]=$_POST['kwota5'];
				$szkola[6]=$_POST['szkola5'];
				$kwota[7]=$_POST['kwota6'];
				$szkola[7]=$_POST['szkola6'];
				break;
				case 8:
				$kwota[1]=$_POST['kwota0'];
				$szkola[1]=$_POST['szkola0'];
				$kwota[2]=$_POST['kwota1'];
				$szkola[2]=$_POST['szkola1'];
				$kwota[3]=$_POST['kwota2'];
				$szkola[3]=$_POST['szkola2'];
				$kwota[4]=$_POST['kwota3'];
				$szkola[4]=$_POST['szkola3'];
				$kwota[5]=$_POST['kwota4'];
				$szkola[5]=$_POST['szkola4'];
				$kwota[6]=$_POST['kwota5'];
				$szkola[6]=$_POST['szkola5'];
				$kwota[7]=$_POST['kwota6'];
				$szkola[7]=$_POST['szkola6'];
				$kwota[8]=$_POST['kwota7'];
				$szkola[8]=$_POST['szkola7'];
				break;
				case 9:
				$kwota[1]=$_POST['kwota0'];
				$szkola[1]=$_POST['szkola0'];
				$kwota[2]=$_POST['kwota1'];
				$szkola[2]=$_POST['szkola1'];
				$kwota[3]=$_POST['kwota2'];
				$szkola[3]=$_POST['szkola2'];
				$kwota[4]=$_POST['kwota3'];
				$szkola[4]=$_POST['szkola3'];
				$kwota[5]=$_POST['kwota4'];
				$szkola[5]=$_POST['szkola4'];
				$kwota[6]=$_POST['kwota5'];
				$szkola[6]=$_POST['szkola5'];
				$kwota[7]=$_POST['kwota6'];
				$szkola[7]=$_POST['szkola6'];
				$kwota[8]=$_POST['kwota7'];
				$szkola[8]=$_POST['szkola7'];
				$kwota[9]=$_POST['kwota8'];
				$szkola[9]=$_POST['szkola8'];
				break;
			}
				if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,  '$nick', '$haslo_hash', '$iledzieci', '$idwojew')")){
				for($i=1; $i<=$iledzieci; $i++){
					($polaczenie->query("INSERT INTO dziecko VALUES(NULL, '$ostatnieid')"))&&
					($polaczenie->query("INSERT INTO szkola VALUES(NULL, '$ostatnieiddziecka[$i]','$szkola[$i]')"))&&
					($polaczenie->query("INSERT INTO kwota VALUES(NULL, '$kwota[$i]', '$ostatnieiddziecka[$i]')"));
				}
				$rezultat->free_result();
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
	<meta name="keywords" content="kieszonkowe, dziecko, średnia, region, jakie, ile dzieci, ile dać dziecku, szkoła podstawowa, liceum, technikum, studia, szkoła zawodowa, przedszkole" />

	<link href="style.css" rel="stylesheet" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Baloo&amp;subset=latin-ext" rel="stylesheet">
	<style>
	.error{
		color:red;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	</style>
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
	</header>
	
	<nav><br/></nav>
<div class="container">
<main>
	<section>
		<div class="rejestracja">
			<form method="post">
				<table>
				
				<tr>
					<td>Login:</td>
					<td><input type="text" name="nick" > </td>
					<td>
					<?php
							if (isset($_SESSION['e_nick']))
							{
								echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
								unset($_SESSION['e_nick']);
							}
					?>
					</td>

				</tr>
				<tr>
					<td>Hasło:</td><td><input type="password" name="haslo"></td>
						<td>
						<?php
							if (isset($_SESSION['e_haslo']))
							{
								echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
								unset($_SESSION['e_haslo']);
							}
						?>
						</td>
						
				</tr>
				<tr>
				<td>Województwo:</td>
					<td>
						<select class="custom-select" name="woj">
						<option>dolnoślaskie</option>
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
					</td>
				</tr>
				<tr>
					<td>Ile dzieci:</td>
					<td>
						<select class="custom-select" name="liczba" id="ld"  onchange="ilebachorow2()">
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
						<option>Za dużo</option>
						</select>
					</td>
				</tr>
				<tr>
			
					<td><div id="wynik2"></div></td>
					
				</tr>
				
				<script type="text/javascript">
				function ilebachorow2(){
				var liczba = document.getElementById("ld").value;
				var tekst="";
					if(liczba>0){
						for(i=0;i<liczba;i++){
						tekst+='Dziecko '+(i+1)+'. Szkoła: <select class="custom-select" name="szkola'+i+'"><option>Podstawówka</option><option>Gimnazjum</option><option>Liceum lub Technikum</option><option>Szkoła wyższa</option></td><td></select>Kwota: <select class="custom-select" name="kwota'+i+'" ><option>10</option><option>20</option><option>40</option><option>60</option><option>80</option><option>100</option></select><br>';
						}
							document.getElementById("wynik2").innerHTML=tekst;
						
					}
					else document.getElementById("wynik2").innerHTML="Nie masz dzieci!";
				}
				</script>

				
				<tr>
					<td colspan="2">
						<input type="checkbox" name="regulamin">
						 Akceptuję regulamin<br/>
						<input type="submit" value="Stwórz konto">
					</td>
					<td>
					<?php
							if (isset($_SESSION['e_regulamin']))
							{
								echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
								unset($_SESSION['e_regulamin']);
							}
					?>
					</td>
				</tr>
			</table>	
		</form>
	</div>
	</section>

</main>
</div>
<footer>
	Wszelkie prawa zastrzeżone &copy 2019
</footer>


</body>
</html>