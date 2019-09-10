<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany'])){ header('Location: index.php');
	exit();
	}

		////////////////////////////////////
		######AKTUALIZACJA CAL######		
		////////////////////////////////////
	if(isset($_POST['woj'])){



		//udana walidacja
			$wszystko_OK=true;
			$woj=$_POST['woj'];
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
				####Zapytania####
				
					####Ilość dzieci usera####
			$zapytanieIII="SELECT Liczba_dzieci FROM uzytkownicy WHERE Nick='$nick'";
			$rezultatIII = @$polaczenie->query($zapytanieIII);
			$wierszIII = $rezultatIII->fetch_assoc();
			$_SESSION['iloscbach'] = $wierszIII['Liczba_dzieci'];  		
			$iloscbach = $_SESSION['iloscbach']+1;
			
			####ID_dzieci####
			$zapytanieXI="SELECT ID_dziecko from Dziecko d join uzytkownicy u on d.ID_user=u.ID_user where Nick='$nick'"; 
			$rezultatXI = @$polaczenie->query($zapytanieXI);
				for($i=1;$i<=$iloscbach;$i++){
				$wierszXI = $rezultatXI->fetch_assoc();
				$id_dziecka[$i] = $wierszXI['ID_dziecko']; 
	}
		
				
				for($i=1;$i<=$iloscbach;$i++){
					$j=$i-1;
					$kwota[$i]=$_POST['kwota'.$j]; 
					$szkola[$i]=$_POST["szkola".$j];
	}

			
			
			$ID_user=$_SESSION['ID_user'];
				####Główne czary aktualizacji####
				if($polaczenie->query("UPDATE uzytkownicy SET ID_woj='$idwojew' WHERE Nick='$nick'")) {
						for($i=1; $i<=$iloscbach; $i++){
							($polaczenie->query("UPDATE szkola SET  szkola='$szkola[$i]' WHERE ID_dziecko='$id_dziecka[$i]'"))&& 
							($polaczenie->query("UPDATE kwota SET kwota='$kwota[$i]' WHERE ID_dziecko='$id_dziecka[$i]'"));
	}							echo'<script> alert("Aktualizacja udała się")</script>';

					
			####Jaka kwote user zaproponował na dziecko####
			$zapytanieII="SELECT kwota FROM kwota k INNER JOIN dziecko d ON d.ID_dziecko=k.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
			$rezultatII = @$polaczenie->query($zapytanieII);
				for($i=0;$i<=$iloscbach;$i++){
				$wierszII = $rezultatII->fetch_assoc();
				$_SESSION['kwota'.$i] = $wierszII['kwota'];  
	}
			####Wyswietlanie szkoly dla dziecka####
			$zapytanieXI="SELECT szkola FROM szkola s INNER JOIN dziecko d ON d.ID_dziecko=s.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$nick'";
			$rezultatXI = @$polaczenie->query($zapytanieXI);
				for($i=0;$i<=$iloscbach;$i++){
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
						header('Location: konto.php');
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
						header('Location: konto.php');
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
				header('Location: konto.php');
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
			<li><a href="wyloguj.php">Wyloguj</a></li>
		</ul>
	</nav>
	</header>
<div class="container">
<main>
	<section>
		<div class="singlecon">
			<div class="title">
				Dane o użytkowniku:
			</div>
			<div class="line">
				Witaj: <span style="font-size: 1.05em; font-weight: 700;"><?php echo$_SESSION['Nick']?></span>!
			</div>
			<div class="line">
				Liczba dzieci: <span style="font-size: 1.05em; font-weight: 700;"><?php echo$_SESSION['iloscbach']?></span>
			</div>
			<div class="line">
				Twoje wojewodztwo: <span id="regionText" style="font-size: 1.05em; font-weight: 700;"><?php echo$_SESSION['jakiewoj']?></span>
				<a id="btnEdit" onClick="showRegionEditor();"></a>
			</div>
			
				<div id="dane"></div>
				
					<form method="post" id="formEdit--hide">
						<div class="row">
						

						<select id="region" class="custom-select2" name="woj">
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
						
						</div>
						<div class="row">
							<input type="submit" value="Potwierdź" class="btnSmall">
							<input type="button" value="Anuluj" id="btnDeclineEdit" class="btnSmall" onClick="hideRegionEditor();">
						</div>
					</form>
				

			<div class="tabela" id="tabela1">
				<table>
			<!--
			///////////////////////////////////////////////////////////////////////////
			///Tutaj tabelka danych z dzieciami, kwotą, szkołą i krzyżykiem usuwania///
			///////////////////////////////////////////////////////////////////////////
			 -->
			 </table>
			</div>
			<div class="tabela" id="tabela2">
				<table>
			<!--
			/////////////////////////////////
			///Tutaj tabelka edycji danych///
			/////////////////////////////////
			-->
				</table>
			</div>
			<?php 
					echo'<form method="post">';
					for($i=0;$i<$_SESSION['iloscbach'];$i++){
						echo"<b>Kwota przeznaczona na dziecko ".($i+1).": </b> <i style='color:red;'>".$_SESSION['kwota'.$i]."zł</i><b>, oraz jego placówka edukacyjna:</b> <i style='color:red;'> ".$_SESSION['szkola'.$i]."</i>  -> Usuń dziecko. <input type='checkbox' name='dziecko_".$i. "'	value='dziecko".($i+1)."'><br>";
					}
					echo'<br><input type="submit" value="Sajonara"><br></form>';
				?>	
				
				<br><br><input type="button" value="Edytuj" id="klawisz" onClick="document.getElementById('ukryty').style.display='block';">
				<div id="dane"></div>
				<div style="display: none" id="ukryty">


			<?php
				
						
						echo'<form method="post">';
						echo"<div class='row'>
						<label for='region'>Województwo:</label>
						<select id='region' class='custom-select' name='woj' >
							<option>dolnośląskie</option>
							<option>kujawsko-pomorskie</option>
							<option>lubelskie</option>
							<option selected>lubuskie</option>
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
						</div>";
							for($i=0;$i<$_SESSION['iloscbach'];$i++){
								echo'Dziecko '.($i+1).'. Szkoła: <select class="custom-select" name="szkola'.$i.'">
								<option>Podstawowka</option>
								<option>Gimnazjum</option>
								<option>Liceum lub Technikum</option>
								<option>Szkola wyzsza</option>
								</select> 
								Kwota: <select class="custom-select" name="kwota'.$i.'" >
								<option>10</option>
								<option>20</option>
								<option>40</option>
								<option>60</option>
								<option>80</option>
								<option>100</option>
								</select><br>';	
					}
					echo'<input type="submit"  value="Zatwierdz zmiane"></form>';				
				?>
				
			
				<input type="button" value="anuluj" id="klawisz" onClick="document.getElementById('ukryty').style.display='none';" >
				</div>	
					
			
			
			
		
				
							
				<input type="button" value="Dodaj dziecko" id="dodajdziecko" onClick="document.getElementById('schowane').style.display='block';">
				<div id="dane"></div>
				<div style="display: none" id="schowane">


				<form method="post">
					<div id="listaDodawaniaDzieci"></div>
							<div class="row">	
								<div class="dziecko">
									<label for="szkola" class="secondLabel" style="left:20%">Szkoła: </label>
                    				<select id="szkola" class="custom-select" name="szkola">
                     			  	<option>Podstawowka</option>
                     			  	<option>Gimnazjum</option>
                     			  	<option>Liceum lub Technikum</option>
                    			   	<option>Szkola wyzsza</option>

                    				</select>
                    				<label for="kwota" class="secondLabel" style="left:20%">Kwota kieszonkowego: </label>
                    				<input type="number" min="10" max="5000" placeholder="[10-5000] zł" step="10" id="kwota" name="kwota">
								</div>
							</div>
						<div class="row">
						<input type="submit" value="Potwierdz">
						<input type="button" value="anuluj" id="klawisz" onClick="document.getElementById('schowane').style.display='none';">
					</div>
				</form>
				</div>
							
			<!--<input type="button" value="Usun dziecko" id="usundziecko" onClick="document.getElementById('przyczajone').style.display='block';">
				<div id="dane"></div>
				<div style="display: none" id="przyczajone">


					<form method="post">
					
					
					<div class="row">				
							Wybierz dziecko, którego już nie potrzebujesz <img 	src="img\ryj.jpg" alt="Tekst alternatywny"><br>
									
									
							<input type="checkbox" name="dziecko_0" 	value="dziecko1">Dziecko 1  |
							<input type="checkbox" name="dziecko_1" 	value="dziecko2">Dziecko 2  |
							<input type="checkbox" name="dziecko_2" 	value="dziecko3">Dziecko 3  |
							<input type="checkbox" name="dziecko_3" 	value="dziecko4">Dziecko 4  |
							<input type="checkbox" name="dziecko_4" 	value="dziecko5">Dziecko 5  |
							<input type="checkbox" name="dziecko_5" 	value="dziecko6">Dziecko 6  |
							<input type="checkbox" name="dziecko_6" 	value="dziecko7">Dziecko 7  |
							<input type="checkbox" name="dziecko_7" 	value="dziecko8">Dziecko 8  |
							<input type="checkbox" name="dziecko_8" 	value="dziecko9">Dziecko 9  
					</div>

					<div class="row">
						<br><input type="submit" value="Potwierdz"><br>
						<br><input type="button" value="anuluj" id="klawisz" onClick="document.getElementById('przyczajone').style.display='none';"><br>
						</div>
					
					</form>
							
				</div>-->
		</div>
	</section>
</main>
</div>
<footer>
	Wszelkie prawa zastrzeżone &copy 2019
</footer>


<script src="src/dodajdzieci.js"></script>
<script src="src/defaultRegion.js"></script>
<script>
	var woj = "<?php echo$_SESSION['jakiewoj'] ?>";
	document.getElementById("btnEdit").addEventListener("click",()=>whichOption(woj));
</script>

</body>
</html>

