<?php
	session_start();
	if(!isset($_SESSION['zalogowany'])){ header('Location: index.php');
	exit();
	}
	if(isset($_POST['liczba'])){
		//udana walidacja
			$wszystko_OK=true;
			$iledzieci=$_POST['liczba'];
			$woj=$_POST['woj'];
			$nick=$_SESSION['Nick'];
			
		if(!is_numeric($iledzieci)){
			$wszystko_OK=false;
			$_SESSION['e_ldzieci']="Podaj liczbe dzieci wpisując odpowiedni numer!";	
			}
			
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
				$j=$i-1;
				$kwota[$i]=$_POST['kwota'.$j]; 
				$szkola[$i]=$_POST["szkola".$j];
				}
				//ZROBIĆ IF CZY DZIECI MNIEJ/WIECEJ CZY TYLE SAMO
				if($polaczenie->query("UPDATE uzytkownicy SET Liczba_dzieci='$iledzieci', ID_woj='$idwojew' WHERE Nick='$nick'")){
					for($i=1; $i<=$iledzieci; $i++){
					($polaczenie->query("UPDATE szkola SET  szkola='$szkola[$i]' WHERE ID_dziecko=85"))&&   //NA SZTYWNO ID TRZA POMYSLEC 
					($polaczenie->query("UPDATE kwota SET kwota='$kwota[$i]' WHERE ID_dziecko=85"));
				}
						echo'<script> alert("Aktualizacja udała się")</script>';
						$zapytanieII="SELECT kwota FROM kwota k INNER JOIN dziecko d ON d.ID_dziecko=k.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
						$rezultatII = @$polaczenie->query($zapytanieII);
						$wierszII = $rezultatII->fetch_assoc();
						$_SESSION['kwota'] = $wierszII['kwota'];  //Wyświetla się gówno, tzn ostatni rekord z tablicy z selecta, trza pomyśleć
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
<!--<body onload="chrum ();">-->
<a href="wyloguj.php"><input type="button" value="Wyloguj"></a></br>
<?php  
	
	echo"<b>Witaj: </b>".$_SESSION['Nick']."<br>";
	echo"<b>Twoja propozycja kwoty</b>: ".$_SESSION['kwota']."<br>";
	//echo"<b>Ile dzieci</b>: ".$_SESSION['Iledzieci']."<br>";
	echo"<b>Proponowana średnia kwota kieszonkowego ze względu na samą liczebność państwa potomków (".$_SESSION['Iledzieci'].") tj <i style='color:red;'>";echo round($_SESSION['AVG(kwota)2'],  2)."zł</i>. <br>";
	echo"<b>Średnia ze względu tylko na twoje województwo</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)'],  2)."zł</i><br>";
	echo"<b>Średnia ze względu na twoje podstawowke i ilość twoich pociech</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)4'],  2)."zł</i><br>";
	echo"<b>Średnia ze względu na twoje Gimnazjum i ilość twoich pociech</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)3'],  2)."zł</i><br>";
	echo"<b>Średnia ze względu na twoje liceum/technikum i ilość twoich pociech</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)5'],  2)."zł</i><br>";
	echo"<b>Średnia ze względu na twoje szkole wyzsza i ilość twoich pociech</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)6'],  2)."zł</i><br>";

	
?>

<br><br><input type="button" value="zaktualizuj dane" id="klawisz" onClick="document.getElementById('ukryty').style.display='block';">
<div id="dane"></div>
<div style="display: none" id="ukryty">
<form method="post">
<table id="tabela">
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
		<td>
		<?php
							if (isset($_SESSION['e_ldzieci']))
							{
								echo '<div class="error">'.$_SESSION['e_ldzieci'].'</div>';
								unset($_SESSION['e_ldzieci']);
							}
						?></td>
		</td>
		</td>
</tr>
<tr>
	<td>Województwo:</td><td>
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
<td><input type="submit" value="Potwierdz"></td>
<td><input type="button" value="anuluj" id="klawisz" onClick="document.getElementById('ukryty').style.display='none';"></td>
</tr>
</table>
</form>
</div>
</body>
</html>

