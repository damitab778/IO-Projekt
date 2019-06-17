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
				case "dolnoslaskie":
				$idwojew=1;
				break;
				case "kujawsko-pomorskie":
				$idwojew=2;
				break;
				case "malopolskie":
				$idwojew=3;
				break;
				case "lodzkie":
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
				case "slaskie":
				$idwojew=12;
				break;
				case "podkarpackie":
				$idwojew=13;
				break;
				case "swietokrzyskie":
				$idwojew=14;
				break;
				case "warminsko-mazurskie":
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
				
				$zmienna=60;//gowniany sposob!
				
				//ZROBIĆ IF CZY DZIECI MNIEJ/WIECEJ CZY TYLE SAMO
				if($polaczenie->query("UPDATE uzytkownicy SET Liczba_dzieci='$iledzieci', ID_woj='$idwojew' WHERE Nick='$nick'")){
					for($i=1; $i<=$iledzieci; $i++){
					($polaczenie->query("UPDATE szkola SET  szkola='$szkola[$i]' WHERE ID_dziecko='$zmienna'+'$i'-1"))&&   //NA SZTYWNO ID TRZA POMYSLEC 
					($polaczenie->query("UPDATE kwota SET kwota='$kwota[$i]' WHERE ID_dziecko='$zmienna'+'$i'-1"));
				}
				
			echo'<script> alert("Aktualizacja udała się")</script>';
						
			####Wyświatlanie jaką kwote user zaproponował na dziecko####
			$zapytanieII="SELECT kwota FROM kwota k INNER JOIN dziecko d ON d.ID_dziecko=k.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
			$rezultatII = @$polaczenie->query($zapytanieII);
			for($i=0;$i<=$iledzieci;$i++){
			$wierszII = $rezultatII->fetch_assoc();
			$_SESSION['kwota'.$i] = $wierszII['kwota'];  }
			####Wyswietlanie szkoly dla dziecka####
			$zapytanieXI="SELECT szkola FROM szkola s INNER JOIN dziecko d ON d.ID_dziecko=s.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
			$rezultatXI = @$polaczenie->query($zapytanieXI);
			for($i=0;$i<=$iledzieci;$i++){
			$wierszXI = $rezultatXI->fetch_assoc();
			$_SESSION['szkola'.$i] = $wierszXI['szkola'];  }
			#####Ilość dzieci usera#####
			$zapytanieIII="SELECT Liczba_dzieci FROM uzytkownicy WHERE Nick='$nick'";
			####Średnie w województwach####
			$zapytanieIV="SELECT AVG(kwota) FROM kwota k join dziecko d ON d.ID_dziecko=k.ID_dziecko 
			JOIN uzytkownicy u on u.ID_user=d.ID_user 
			WHERE (ID_woj) in (SELECT ID_woj from  kwota k join dziecko d ON d.ID_dziecko=k.ID_dziecko JOIN uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$nick');";
			####Średnia ze względu na ilosc dzieci####
			$zapytanieV="SELECT AVG(kwota) FROM kwota k join dziecko d ON d.ID_dziecko=k.ID_dziecko 
			JOIN uzytkownicy u on u.ID_user=d.ID_user 
			WHERE (Liczba_dzieci) in (SELECT Liczba_dzieci from  uzytkownicy WHERE Nick = '$nick');";
			####Średnia ze względu na gimnazjum i ilość dzieci#####
			$zapytanieVI="SELECT AVG(kwota) FROM kwota k join szkola s ON k.ID_dziecko=s.ID_dziecko JOIN dziecko d on d.ID_dziecko=k.ID_dziecko join  uzytkownicy u on d.ID_user=u.ID_user 
			WHERE (Liczba_dzieci, Szkola) in (SELECT Liczba_dzieci, Szkola from  szkola s join dziecko d on d.ID_dziecko=s.ID_dziecko join uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$nick' AND Szkola='Gimnazjum');";
			####Średnia ze względu na podstawowke i ilość dzieci#####
			$zapytanieVII="SELECT AVG(kwota) FROM kwota k join szkola s ON k.ID_dziecko=s.ID_dziecko JOIN dziecko d on d.ID_dziecko=k.ID_dziecko join  uzytkownicy u on d.ID_user=u.ID_user 
			WHERE (Liczba_dzieci, Szkola) in (SELECT Liczba_dzieci, Szkola from  szkola s join dziecko d on d.ID_dziecko=s.ID_dziecko join uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$nick' AND Szkola='Podstawowka');";
			####Średnia ze względu na liceum/technikum i ilość dzieci#####
			$zapytanieVIII="SELECT AVG(kwota) FROM kwota k join szkola s ON k.ID_dziecko=s.ID_dziecko JOIN dziecko d on d.ID_dziecko=k.ID_dziecko join  uzytkownicy u on d.ID_user=u.ID_user 
			WHERE (Liczba_dzieci, Szkola) in (SELECT Liczba_dzieci, Szkola from  szkola s join dziecko d on d.ID_dziecko=s.ID_dziecko join uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$nick' AND Szkola='Liceum lub Technikum');";
			####Średnia ze względu na szkole wyzsza i ilość dzieci#####
			$zapytanieIX="SELECT AVG(kwota) FROM kwota k join szkola s ON k.ID_dziecko=s.ID_dziecko JOIN dziecko d on d.ID_dziecko=k.ID_dziecko join  uzytkownicy u on d.ID_user=u.ID_user 
			WHERE (Liczba_dzieci, Szkola) in (SELECT Liczba_dzieci, Szkola from  szkola s join dziecko d on d.ID_dziecko=s.ID_dziecko join uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$nick' AND Szkola='Szkola wyzsza');";
			$zapytanieX="SELECT Nazwa_Woj FROM wojewodztwa w JOIN uzytkownicy u ON u.ID_woj=w.ID_woj WHERE Nick='$nick'";
					$rezultatIII = @$polaczenie->query($zapytanieIII);
					$wierszIII = $rezultatIII->fetch_assoc();
					$rezultatIV = @$polaczenie->query($zapytanieIV);
					$wierszIV = $rezultatIV->fetch_assoc();
					$rezultatV = @$polaczenie->query($zapytanieV);
					$wierszV = $rezultatV->fetch_assoc();
					$rezultatVI = @$polaczenie->query($zapytanieVI);
					$wierszVI = $rezultatVI->fetch_assoc();
					$rezultatVII = @$polaczenie->query($zapytanieVII);
					$wierszVII = $rezultatVII->fetch_assoc();
					$rezultatVIII = @$polaczenie->query($zapytanieVIII);
					$wierszVIII = $rezultatVIII->fetch_assoc();
					$rezultatIX = @$polaczenie->query($zapytanieIX);
					$wierszIX = $rezultatIX->fetch_assoc();		
					$rezultatX = @$polaczenie->query($zapytanieX);
					$wierszX = $rezultatX->fetch_assoc();
						$_SESSION['Iledzieci'] = $wierszIII['Liczba_dzieci'];  			 #!!!!!!!!!! 
						$_SESSION['jakiewoj'] = $wierszX['Nazwa_Woj'];   #!!!!!!!!!! 
						$_SESSION['AVG(kwota)'] = $wierszIV['AVG(kwota)'];   	 #!!!!!!!!! SR z woj
						$_SESSION['AVG(kwota)2'] = $wierszV['AVG(kwota)'];   	 #!!!!!!!!! SR sama ilosc dzieci
						$_SESSION['AVG(kwota)3'] = $wierszVI['AVG(kwota)'];   	 #!!!!!!!!!  SR gim
						$_SESSION['AVG(kwota)4'] = $wierszVII['AVG(kwota)'];    #!!!!!!!!! SR podst
						$_SESSION['AVG(kwota)5'] = $wierszVIII['AVG(kwota)'];   #!!!!!!!!! Sr lic/tech
						$_SESSION['AVG(kwota)6'] = $wierszIX['AVG(kwota)'];   #!!!!!!!!! Sr szkola wyzsza
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
<body>
<a href="wyloguj.php"><input type="button" value="Wyloguj"></a></br>
<?php  
	echo"<b><br>DANE O UZYTKOWNKIU:</b><br>";
	echo"<b>------------------------------------------------------</b><br>";
	echo"<b>Witaj: </b><u>".$_SESSION['Nick']."!</u><br>";
	echo"<b>Twoje wojewodztwo: </b>".$_SESSION['jakiewoj'].".<br>";
	echo"<b>Ile dzieci</b>: ".$_SESSION['Iledzieci'].".<br>";
	for($i=0;$i<$_SESSION['Iledzieci'];$i++){
		echo"<b>Kwota przeznaczona na dziecko ".($i+1).": </b> <i style='color:red;'>".$_SESSION['kwota'.$i]."zł</i><b>, oraz jego placówka edukacyjna:</b> <i style='color:red;'> ".$_SESSION['szkola'.$i]."</i>.<br>";
	}
	echo"<b>------------------------------------------------------</b><br>";
	echo"<b>DANE STATYSTYCZNE:</b><br>";
	echo"<b>Proponowana średnia kwota kieszonkowego ze względu na samą liczebność państwa potomków (".$_SESSION['Iledzieci'].") tj:</b> <i style='color:red;'>";echo round($_SESSION['AVG(kwota)2'],  2)."zł</i>. <br>";
	echo"<b>Średnia ze względu tylko na twoje województwo</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)'],  2)."zł.</i><br>";
	echo"<b>Średnia ze względu na twoje podstawowke i ilość twoich pociech</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)4'],  2)."zł.</i><br>";
	echo"<b>Średnia ze względu na twoje Gimnazjum i ilość twoich pociech</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)3'],  2)."zł.</i><br>";
	echo"<b>Średnia ze względu na twoje liceum/technikum i ilość twoich pociech</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)5'],  2)."zł.</i><br>";
	echo"<b>Średnia ze względu na twoje szkole wyzsza i ilość twoich pociech</b>: <i style='color:red;'>";echo round($_SESSION['AVG(kwota)6'],  2)."zł.</i><br>";

	
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
		<option>dolnoslaskie</option>
		<option>kujawsko-pomorskie</option>
		<option>lubelskie</option>
		<option>lubuskie</option>
		<option>lodzkie</option>
		<option>malopolskie</option>
		<option>mazowieckie</option>
		<option>opolskie</option>
		<option>podkarpackie</option>
		<option>podlaskie</option>
		<option>pomorskie</option>
		<option>slaskie</option>
		<option>swietokrzyskie</option>
		<option>warminsko-mazurskie</option>
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
						tekst+='Dziecko '+(i+1)+'. Szkoła: <select class="custom-select" name="szkola'+i+'"><option>Podstawowka</option><option>Gimnazjum</option><option>Liceum lub Technikum</option><option>Szkola wyzsza</option></td><td></select>Kwota: <select class="custom-select" name="kwota'+i+'" ><option>10</option><option>20</option><option>40</option><option>60</option><option>80</option><option>100</option></select><br>';
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

