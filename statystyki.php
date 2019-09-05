<?php
	session_start();
	if(!isset($_SESSION['zalogowany'])){ header('Location: index.php');
	exit();
	}
		////////////////////////////////////
		######AKTUALIZACJA CAL######		
		////////////////////////////////////
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
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); 
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
	}
		else{		
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

			####Zapytania####
			####ID_dzieci####
			$zapytanieXI="SELECT ID_dziecko from Dziecko d join uzytkownicy u on d.ID_user=u.ID_user where Nick='$nick'"; 
			$rezultatXI = @$polaczenie->query($zapytanieXI);
				for($i=1;$i<=$iledzieci;$i++){
				$wierszXI = $rezultatXI->fetch_assoc();
				$id_dziecka[$i] = $wierszXI['ID_dziecko']; 
	}
			####Ilość dzieci usera####
			$zapytanieIII="SELECT Liczba_dzieci FROM uzytkownicy WHERE Nick='$nick'";
			$rezultatIII = @$polaczenie->query($zapytanieIII);
			$wierszIII = $rezultatIII->fetch_assoc();
			$_SESSION['iloscbach'] = $wierszIII['Liczba_dzieci'];  		
			$iloscbach = $_SESSION['iloscbach']+1;
			
			$ID_user=$_SESSION['ID_user'];
				####Główne czary aktualizacji####
				if($polaczenie->query("UPDATE uzytkownicy SET ID_woj='$idwojew' WHERE Nick='$nick'")) {
					if($iledzieci<=$_SESSION['iloscbach']){
						for($i=1; $i<=$iledzieci; $i++){
							($polaczenie->query("UPDATE szkola SET  szkola='$szkola[$i]' WHERE ID_dziecko='$id_dziecka[$i]'"))&& 
							($polaczenie->query("UPDATE kwota SET kwota='$kwota[$i]' WHERE ID_dziecko='$id_dziecka[$i]'"));
	}							echo'<script> alert("Aktualizacja udała się")</script>';
	}				else echo'<script> alert("Nie masz aż tylu dzieci, proszę skorzystać z funkcji dodawania dzieci!")</script>';
					
			####Jaka kwote user zaproponował na dziecko####
			$zapytanieII="SELECT kwota FROM kwota k INNER JOIN dziecko d ON d.ID_dziecko=k.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
			$rezultatII = @$polaczenie->query($zapytanieII);
				for($i=0;$i<=$iledzieci;$i++){
				$wierszII = $rezultatII->fetch_assoc();
				$_SESSION['kwota'.$i] = $wierszII['kwota'];  
	}
			####Wyswietlanie szkoly dla dziecka####
			$zapytanieXI="SELECT szkola FROM szkola s INNER JOIN dziecko d ON d.ID_dziecko=s.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
			$rezultatXI = @$polaczenie->query($zapytanieXI);
				for($i=0;$i<=$iledzieci;$i++){
				$wierszXI = $rezultatXI->fetch_assoc();
				$_SESSION['szkola'.$i] = $wierszXI['szkola'];  
	}
			////DO "ODŚWIEZANIA" DANYCH//// 
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
			####Aktualne województwo####
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
						$_SESSION['Iledzieci'] = $wierszIII['Liczba_dzieci'];  			 	#!!!!!!!!!! 
						$_SESSION['jakiewoj'] = $wierszX['Nazwa_Woj'];					#!!!!!!!!!! 
						$_SESSION['AVG(kwota)'] = $wierszIV['AVG(kwota)'];   	 	#!!!!!!!!! SR z woj
						$_SESSION['AVG(kwota)2'] = $wierszV['AVG(kwota)'];   	#!!!!!!!!! SR sama ilosc dzieci
						$_SESSION['AVG(kwota)3'] = $wierszVI['AVG(kwota)'];   	#!!!!!!!!!  SR gim
						$_SESSION['AVG(kwota)4'] = $wierszVII['AVG(kwota)'];     #!!!!!!!!! SR podst
						$_SESSION['AVG(kwota)5'] = $wierszVIII['AVG(kwota)'];    #!!!!!!!!! Sr lic/tech
						$_SESSION['AVG(kwota)6'] = $wierszIX['AVG(kwota)'];      #!!!!!!!!! Sr szkola wyzsza
		  /////////////////////////////////////////////////////////////////////////////////////////////////////
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
		
		////////////////////////////////////
		######   DODAJ DZIECKO   ######		
		////////////////////////////////////
		if(isset($_POST['szkola'])){
		$wszystko_OK=true;
		$nick=$_SESSION['Nick'];
			
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); 
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
	}
			else{
					
	if($wszystko_OK==true){
		$kwota=$_POST['kwota']; 
		$szkola=$_POST['szkola'];		
		#####Ilość dzieci usera#####
		$zapytanieIII="SELECT Liczba_dzieci FROM uzytkownicy WHERE Nick='$nick'";
		$rezultatIII = @$polaczenie->query($zapytanieIII);
		$wierszIII = $rezultatIII->fetch_assoc();
		$_SESSION['iloscbach'] = $wierszIII['Liczba_dzieci'];  		
		$iloscbach = $_SESSION['iloscbach'];
		$iloscbach2= $_SESSION['iloscbach']+1;
		
		$ID_user=$_SESSION['ID_user'];
			####Magia dodawania dzieciaka####
			if($polaczenie->query("UPDATE uzytkownicy SET Liczba_dzieci='$iloscbach' WHERE Nick='$nick'")){
				$kwota=$_POST['kwota']; 
				$szkola=$_POST['szkola'];
			if($polaczenie->query("INSERT INTO dziecko (ID_dziecko,ID_user)  VALUES (NULL,'$ID_user')")){
				$zapytanieXI="SELECT ID_dziecko from Dziecko d join uzytkownicy u on d.ID_user=u.ID_user where Nick='$nick' ORDER BY ID_dziecko DESC"; 
				$rezultatXI = @$polaczenie->query($zapytanieXI);
				$wierszXI = $rezultatXI->fetch_assoc();
				$id_dziecka = $wierszXI['ID_dziecko']; 
	}
				$polaczenie->query("INSERT INTO szkola (ID_szkola,ID_dziecko, Szkola) VALUES (NULL, '$id_dziecka', '$szkola')"); 
				$polaczenie->query("INSERT INTO kwota  (ID_kwota, kwota, ID_dziecko) VALUES (NULL, '$kwota', '$id_dziecka')");
				$polaczenie->query("UPDATE uzytkownicy SET Liczba_dzieci='$iloscbach2' WHERE Nick='$nick'");
				$_SESSION['iloscbach']=$_SESSION['iloscbach']+1;
				echo'<script> alert("Aktualizacja udała się")</script>';
			
				####Wyswietlanie kwoty dla dziecka####			
				$zapytanieII="SELECT kwota FROM kwota k INNER JOIN dziecko d ON d.ID_dziecko=k.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
				$rezultatII = @$polaczenie->query($zapytanieII);
					for($i=0;$i<=$iloscbach2;$i++){
					$wierszII = $rezultatII->fetch_assoc();
					$_SESSION['kwota'.$i] = $wierszII['kwota'];  
	}
				####Wyswietlanie szkoly dla dziecka####
				$zapytanieXI="SELECT szkola FROM szkola s INNER JOIN dziecko d ON d.ID_dziecko=s.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
				$rezultatXI = @$polaczenie->query($zapytanieXI);
					for($i=0;$i<=$iloscbach2;$i++){
					$wierszXI = $rezultatXI->fetch_assoc();
					$_SESSION['szkola'.$i] = $wierszXI['szkola'];  
	}
			////DO "ODŚWIEZANIA" DANYCH//// 
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
						$_SESSION['AVG(kwota)'] = $wierszIV['AVG(kwota)'];   	 	#!!!!!!!!! SR z woj
						$_SESSION['AVG(kwota)2'] = $wierszV['AVG(kwota)'];   	#!!!!!!!!! SR sama ilosc dzieci
						$_SESSION['AVG(kwota)3'] = $wierszVI['AVG(kwota)'];   	#!!!!!!!!!  SR gim
						$_SESSION['AVG(kwota)4'] = $wierszVII['AVG(kwota)'];     #!!!!!!!!! SR podst
						$_SESSION['AVG(kwota)5'] = $wierszVIII['AVG(kwota)'];    #!!!!!!!!! Sr lic/tech
						$_SESSION['AVG(kwota)6'] = $wierszIX['AVG(kwota)'];      #!!!!!!!!! Sr szkola wyzsza
			////////////////////////////////////////////////////////////////////////////////
	}
			else{
				throw new Exception($polaczenie->error);
	}			
	}
			$polaczenie->close();
	}}
		catch(Exception $wyjatek){
			echo '<script>alert("Problem z serwerem, spróbuj później.")</script>';
			echo '<br />Info dev: '.$wyjatek;
	}}
	
	
		////////////////////////////////////
		######    USUN DZIECKO     ######		
		////////////////////////////////////
		if((isset($_POST['dziecko_0']))OR(isset($_POST['dziecko_1']))OR(isset($_POST['dziecko_2']))OR(isset($_POST['dziecko_3']))OR(isset($_POST['dziecko_4']))OR(isset($_POST['dziecko_5']))OR(isset($_POST['dziecko_4']))OR(isset($_POST['dziecko_6']))OR(isset($_POST['dziecko_7']))OR(isset($_POST['dziecko_8']))){
		$wszystko_OK=true;
		$nick=$_SESSION['Nick'];

		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name); 
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
	}
			else{
					
	if($wszystko_OK==true){
		#####Ilość dzieci usera#####
		$zapytanieIII="SELECT Liczba_dzieci FROM uzytkownicy WHERE Nick='$nick'";
		$rezultatIII = @$polaczenie->query($zapytanieIII);
		$wierszIII = $rezultatIII->fetch_assoc();
		$_SESSION['iloscbach'] = $wierszIII['Liczba_dzieci'];  		
		$iloscbach = $_SESSION['iloscbach'];
		$iloscbach2= $_SESSION['iloscbach']+1;
		$iloscbach3= $_SESSION['iloscbach']-1;

		####ID dziecka####
		$zapytanieXI="SELECT ID_dziecko from Dziecko d join uzytkownicy u on d.ID_user=u.ID_user where Nick='$nick'"; 
		$rezultatXI = @$polaczenie->query($zapytanieXI);
		
		
		$ID_user=$_SESSION['ID_user'];
		 //	<input type="checkbox" name="dziecko_0" value="dziecko1">Dziecko 1 
		//<input type="checkbox" name="dziecko_1" value="dziecko2">Dziecko 2 
		//<input type="checkbox" name="dziecko_2" value="dziecko3">Dziecko 3
			####Magia dodawania dzieciaka#### ////SKAD WZIAC ID KTOREGO DZIECIAKA USUNAC?
			if($polaczenie->query("UPDATE uzytkownicy SET Liczba_dzieci='$iloscbach' WHERE Nick='$nick'")){
				for($i=0;$i<=$iloscbach;$i++){  ///SPRAWDZANIE CZY CHECKED
				$wierszXI = $rezultatXI->fetch_assoc();
				if(isset($_POST['dziecko_'.$i])){
					$id_dziecka[$i] = $wierszXI['ID_dziecko']; 
				/////USUWA 1 TYLKO!
				$zapytanieXIII="SELECT ID_szkola FROM szkola s join dziecko d ON s.ID_dziecko=d.ID_dziecko join uzytkownicy u on d.ID_user=u.ID_user  WHERE Nick='$nick' AND d.ID_dziecko='$id_dziecka[$i]';";
				$rezultatXIII = @$polaczenie->query($zapytanieXIII);
				$wierszXIII = $rezultatXIII->fetch_assoc();
				$id_szkola = $wierszXIII['ID_szkola']; 
				$polaczenie->query("DELETE FROM szkola WHERE ID_szkola='$id_szkola'");
				$polaczenie->query("DELETE FROM kwota WHERE ID_kwota='$id_szkola'"); //Bo te same id tak czy siak
				$polaczenie->query("DELETE FROM dziecko WHERE ID_dziecko='$id_dziecka[$i]'");
				$polaczenie->query("UPDATE uzytkownicy SET Liczba_dzieci='$iloscbach3' WHERE Nick='$nick'");
				}
				}
					$_SESSION['iloscbach']=$_SESSION['iloscbach']-1;
				echo'<script> alert("Aktualizacja udała się")</script>';
			
				####Wyswietlanie kwoty dla dziecka####			
				$zapytanieII="SELECT kwota FROM kwota k INNER JOIN dziecko d ON d.ID_dziecko=k.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
				$rezultatII = @$polaczenie->query($zapytanieII);
					for($i=0;$i<=$iloscbach2;$i++){
					$wierszII = $rezultatII->fetch_assoc();
					$_SESSION['kwota'.$i] = $wierszII['kwota'];  
	}
				####Wyswietlanie szkoly dla dziecka####
				$zapytanieXI="SELECT szkola FROM szkola s INNER JOIN dziecko d ON d.ID_dziecko=s.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
				$rezultatXI = @$polaczenie->query($zapytanieXI);
					for($i=0;$i<=$iloscbach2;$i++){
					$wierszXI = $rezultatXI->fetch_assoc();
					$_SESSION['szkola'.$i] = $wierszXI['szkola'];  
	}
			////DO "ODŚWIEZANIA" DANYCH//// 
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
						$_SESSION['AVG(kwota)'] = $wierszIV['AVG(kwota)'];   	 	#!!!!!!!!! SR z woj
						$_SESSION['AVG(kwota)2'] = $wierszV['AVG(kwota)'];   	#!!!!!!!!! SR sama ilosc dzieci
						$_SESSION['AVG(kwota)3'] = $wierszVI['AVG(kwota)'];   	#!!!!!!!!!  SR gim
						$_SESSION['AVG(kwota)4'] = $wierszVII['AVG(kwota)'];     #!!!!!!!!! SR podst
						$_SESSION['AVG(kwota)5'] = $wierszVIII['AVG(kwota)'];    #!!!!!!!!! Sr lic/tech
						$_SESSION['AVG(kwota)6'] = $wierszIX['AVG(kwota)'];      #!!!!!!!!! Sr szkola wyzsza
			////////////////////////////////////////////////////////////////////////////////
	}
			else{
				throw new Exception($polaczenie->error);
	}			
	}
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
			<li><a href="#">O nas</a></li>
			<li><a href="wyloguj.php" class="linknav">Wyloguj</a></li>
		</ul>
	</nav>
    </header>
<div class="container">
<main>
	<section>
		<div class="singlecon">
                <?php
					echo"<b>DANE STATYSTYCZNE:</b><br>";
					echo"<b>Proponowana średnia kwota kieszonkowego ze względu na samą liczebność 				państwa potomków (".$_SESSION['Iledzieci'].") tj:</b> <i style='color:red;'>";				echo round($_SESSION['AVG(kwota)2'],  2)."zł</i>. <br>";
					echo"<b>Średnia ze względu tylko na twoje województwo</b>: <i style='color:red;				'>";echo round($_SESSION['AVG(kwota)'],  2)."zł.</i><br>";
					echo"<b>Średnia ze względu na twoje podstawowke i ilość twoich pociech</b>: <i 				style='color:red;'>";echo round($_SESSION['AVG(kwota)4'],  2)."zł.</i><br>";
					echo"<b>Średnia ze względu na twoje Gimnazjum i ilość twoich pociech</b>: <i 				style='color:red;'>";echo round($_SESSION['AVG(kwota)3'],  2)."zł.</i><br>";
					echo"<b>Średnia ze względu na twoje liceum/technikum i ilość twoich pociech</b>: 				<i style='color:red;'>";echo round($_SESSION['AVG(kwota)5'],  2)."zł.</i><br>";
					echo"<b>Średnia ze względu na twoje szkole wyzsza i ilość twoich pociech</b>: <i 				style='color:red;'>";echo round($_SESSION['AVG(kwota)6'],  2)."zł.</i><br>";

				?>
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

