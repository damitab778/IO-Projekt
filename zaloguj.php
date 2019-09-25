<?php
	session_start();
		if((!isset($_POST['login'])) || (!isset($_POST['haslo']))){
		header('Location: index.php');
		exit();
	}
	require_once "connect.php";	
	$polaczenie = @new mysqli($host, $db_user,$db_password, $db_name); //@ operator kontroli bledow
	if($polaczenie->connect_errno!=0){
		echo "Error: ".$polaczenie->connect_errno;
	}
	else{
			
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			$login = htmlentities($login, ENT_QUOTES, "UTF-8"); 
			
			#####Kwota jaką dano na dzieciaka, narazie wyswietla tylko kwote przypisana do ostatniego bajtla#####
			$zapytanieII="SELECT kwota FROM kwota k INNER JOIN dziecko d ON d.ID_dziecko=k.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$login'";
			####Wyswietlanie szkoly dla dziecka####
			$zapytanieXI="SELECT szkola FROM szkola s INNER JOIN dziecko d ON d.ID_dziecko=s.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$login'";
			#####Ilość dzieci usera#####
			$zapytanieIII="SELECT Liczba_dzieci FROM uzytkownicy WHERE Nick='$login'";
			####Średnie w województwach####
			$zapytanieIV="SELECT AVG(kwota) FROM kwota k join dziecko d ON d.ID_dziecko=k.ID_dziecko 
			JOIN uzytkownicy u on u.ID_user=d.ID_user 
			WHERE (ID_woj) in (SELECT ID_woj from  kwota k join dziecko d ON d.ID_dziecko=k.ID_dziecko JOIN uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$login');";
			####Średnia ze względu na ilosc dzieci####
			$zapytanieV="SELECT AVG(kwota) FROM kwota k join dziecko d ON d.ID_dziecko=k.ID_dziecko 
			JOIN uzytkownicy u on u.ID_user=d.ID_user 
			WHERE (Liczba_dzieci) in (SELECT Liczba_dzieci from  uzytkownicy WHERE Nick = '$login');";
			####Średnia ze względu na gimnazjum i ilość dzieci#####
			$zapytanieVI="SELECT AVG(kwota) FROM kwota k join szkola s ON k.ID_dziecko=s.ID_dziecko JOIN dziecko d on d.ID_dziecko=k.ID_dziecko join  uzytkownicy u on d.ID_user=u.ID_user 
			WHERE (Liczba_dzieci, Szkola) in (SELECT Liczba_dzieci, Szkola from  szkola s join dziecko d on d.ID_dziecko=s.ID_dziecko join uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$login' AND Szkola='Gimnazjum');";
			####Średnia ze względu na podstawowke i ilość dzieci#####
			$zapytanieVII="SELECT AVG(kwota) FROM kwota k join szkola s ON k.ID_dziecko=s.ID_dziecko JOIN dziecko d on d.ID_dziecko=k.ID_dziecko join  uzytkownicy u on d.ID_user=u.ID_user 
			WHERE (Liczba_dzieci, Szkola) in (SELECT Liczba_dzieci, Szkola from  szkola s join dziecko d on d.ID_dziecko=s.ID_dziecko join uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$login' AND Szkola='Podstawowka');";
			####Średnia ze względu na liceum/technikum i ilość dzieci#####
			$zapytanieVIII="SELECT AVG(kwota) FROM kwota k join szkola s ON k.ID_dziecko=s.ID_dziecko JOIN dziecko d on d.ID_dziecko=k.ID_dziecko join  uzytkownicy u on d.ID_user=u.ID_user 
			WHERE (Liczba_dzieci, Szkola) in (SELECT Liczba_dzieci, Szkola from  szkola s join dziecko d on d.ID_dziecko=s.ID_dziecko join uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$login' AND Szkola='Liceum lub Technikum');";
			####Średnia ze względu na szkole wyzsza i ilość dzieci#####
			$zapytanieIX="SELECT AVG(kwota) FROM kwota k join szkola s ON k.ID_dziecko=s.ID_dziecko JOIN dziecko d on d.ID_dziecko=k.ID_dziecko join  uzytkownicy u on d.ID_user=u.ID_user 
			WHERE (Liczba_dzieci, Szkola) in (SELECT Liczba_dzieci, Szkola from  szkola s join dziecko d on d.ID_dziecko=s.ID_dziecko join uzytkownicy u on u.ID_user=d.ID_user WHERE Nick = '$login' AND Szkola='Szkola wyzsza');";
			####Wyswietlanie wojewodztwa####
			$zapytanieX="SELECT Nazwa_Woj FROM wojewodztwa w JOIN uzytkownicy u ON u.ID_woj=w.ID_woj WHERE Nick='$login'";
			$zapytanieXII="SELECT ID_user FROM uzytkownicy where Nick='$login'";
			
		if	($rezultat = @$polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE Nick='%s'",
		mysqli_real_escape_string($polaczenie, $login)))){
			$ilu_userow = $rezultat->num_rows; 						//ile uzytkownikow  o podanym log i hasl ilosc wierszy
					if($ilu_userow>0){
					$wiersz = $rezultat->fetch_assoc();
					if(password_verify($haslo, $wiersz['Haslo'])){
						
					$rezultatIII = @$polaczenie->query($zapytanieIII);
					$wierszIII = $rezultatIII->fetch_assoc();
					$rezultatXI = @$polaczenie->query($zapytanieXI);
					$rezultatII = @$polaczenie->query($zapytanieII);
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
					$rezultatXII = @$polaczenie->query($zapytanieXII);
					$wierszXII = $rezultatXII->fetch_assoc();
						$_SESSION['Nick']=$wiersz['Nick']; 		  					#!!!!!!!!!
						$_SESSION['Iledzieci'] = $wierszIII['Liczba_dzieci'];   #!!!!!!!!!! 
						$_SESSION['iloscbach'] = $wierszIII['Liczba_dzieci'];  	
						$_SESSION['jakiewoj'] = $wierszX['Nazwa_Woj'];   #!!!!!!!!!! 

						for($i=0;$i<=$_SESSION['Iledzieci'];$i++){
						$wierszII = $rezultatII->fetch_assoc();
						$_SESSION['kwota'.$i] = $wierszII['kwota'];   				#!!!!!!!!!Jaka kwota na jakiego bachora
						}
						for($i=0;$i<=$_SESSION['Iledzieci'];$i++){
						$wierszXI = $rezultatXI->fetch_assoc();
						$_SESSION['szkola'.$i] = $wierszXI['szkola'];  
						}
						$_SESSION['AVG(kwota)'] = $wierszIV['AVG(kwota)'];   #!!!!!!!!! SR z woj
						$_SESSION['AVG(kwota)2'] = $wierszV['AVG(kwota)'];   #!!!!!!!!! SR sama ilosc dzieci
						$_SESSION['AVG(kwota)3'] = $wierszVI['AVG(kwota)'];   #!!!!!!!!!  SR gim
						$_SESSION['AVG(kwota)4'] = $wierszVII['AVG(kwota)'];   #!!!!!!!!! SR podst
						$_SESSION['AVG(kwota)5'] = $wierszVIII['AVG(kwota)'];   #!!!!!!!!! Sr lic/tech
						$_SESSION['AVG(kwota)6'] = $wierszIX['AVG(kwota)'];   #!!!!!!!!! Sr szkola wyzsza
						$_SESSION['ID_user'] = $wierszXII['ID_user'];  	
			
		
			
		
					$rezultat->free_result();     //ZWALNIANIE PAMIECI
					$rezultatII->free_result();
					$rezultatIII->free_result();
					$rezultatIV->free_result();
					$rezultatV->free_result();
					$rezultatVI->free_result();
					$rezultatVII->free_result();
					$rezultatVIII->free_result();
					$rezultatIX->free_result();
					$rezultatX->free_result();
					$rezultatXI->free_result();
						
						$_SESSION['zalogowany']=true;
						unset($_SESSION['blad']);
						$rezultat->free_result();
						header('Location: konto.php');
					}
					else{
					$_SESSION['blad']='<script>alert("Złe hasło!")</script>';
					header('Location: index.php');
					}}
			else{
				$_SESSION['blad']='<script>alert("Wpisz dane do zalogowania")</script>';
				header('Location: index.php');
			}
		}//Wykonany gdy literowka w zapytaniu
		$polaczenie->close();
	}
?>