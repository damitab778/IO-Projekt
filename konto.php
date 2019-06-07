<?php
	session_start();
	if(!isset($_SESSION['zalogowany'])){ header('Location: index.php');
	exit();
	}
	if(isset($_POST['liczba'])){
		//udana walidacja
		$wszystko_OK=true;
		
		//Ilosc dzieci
			$iledzieci=$_POST['liczba'];
		if(!is_numeric($iledzieci)){
			$wszystko_OK=false;
			$_SESSION['e_ldzieci']="Podaj liczbe dzieci wpisując odpowiedni numer!";	
			}
			
			if($iledzieci==0){
			$wszystko_OK=false;
			$_SESSION['e_ldzieci']="Strona przeznaczona, dla opiekunów z dziecmi!";	
			}
			
			$kwota=$_POST['kwota'];
			$szkola=$_POST['szkola'];
			$woj=$_POST['woj'];
			$nick=$_SESSION['login'];
			
			if(!isset($_POST['regulamin'])){
			$wszystko=false;
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
			
			//wsio ok			
			if($wszystko_OK==true){
				
				if($polaczenie->query("UPDATE uzytkownicy SET ilosc_dzieci='$iledzieci', woj='$woj', szkola='$szkola', kwota='$kwota' WHERE login='$nick'")){										/////DO ZROBIENIA
					echo'<script> alert("Aktualizacja udała się")</script>';
						$rezultatII = @$polaczenie->query($zapytanieII);
							$wierszII = $rezultatII->fetch_assoc();
								$_SESSION['kwota'] = $wierszII['kwota'];
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
	<meta charset="utf-8">
	
	<!--<script type="text/javascript">
    function chrum () { document.getElementById('play').play(); }
	</script>
	<audio id="play" src="swinka.mp3"></audio>
	-->
</head>
<body onload="chrum ();">
<a href="wyloguj.php"><input type="button" value="Wyloguj"></a></br>
<?php  
	
	echo"<b>Witaj: </b>".$_SESSION['Nick']."<br>";
	echo"<b>Twoja propozycja kwoty</b>: ".$_SESSION['kwota']."<br>";

?>

<br><br><input type="button" value="zaktualizuj dane" id="klawisz" onClick="document.getElementById('ukryty').style.display='block';">
<div id="dane"></div>
<div style="display: none" id="ukryty">
<form method="post">
<table id="tabela">
<tr>
	<td>Ile dzieci:</td><td>
		<select name="liczba">
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
	<td>Województwo:</td><td>
		<select name="woj" style="width:173px">
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
	<td>Szkoła dziecka:</td><td>
		<select name="szkola" style="width:173px">
		<option>Podstawówka</option>
		<option>Gimnazjum</option>
		<option>Liceum lub Technikum</option>
		<option>Szkoła wyższa</option></select>
		</td>
</tr>
<tr>
	<td>Kwota:</td><td>
		<select name="kwota" style="width:173px">
	<option>0</option>
	<option>10</option>
	<option>20</option>
	<option>40</option>
	<option>60</option>
	<option>80</option>
	<option>100</option>
	<option>110</option></select>
</td><td><?php
			if (isset($_SESSION['e_kwota']))
			{
					echo '<script>alert("Nie ucinaj dzieciakowi kieszonkowego plz // psst: i tak nie pozwole")</script>';
				unset($_SESSION['e_kwota']);
			}
		?></td>
</tr>
<tr>
<td><input type="submit" value="Potwierdz"></td>
<td><input type="button" value="anuluj" id="klawisz" onClick="document.getElementById('ukryty').style.display='none';"></td>
</tr>
</table>
</form>
</div>
</body>
</html>

