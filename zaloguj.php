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
	}//Wykona się jesli zajdzie blad 
	else{
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			$login = htmlentities($login, ENT_QUOTES, "UTF-8"); 
			
		/*$zapytanieII="SELECT AVG(kwota) FROM uzytkownicy WHERE (ilosc_dzieci, woj, szkola) in (SELECT ilosc_dzieci, woj, szkola FROM uzytkownicy WHERE login='$login')";
		$zapytanieIII="SELECT AVG(kwota) FROM uzytkownicy WHERE (woj, szkola) in (SELECT woj, szkola FROM uzytkownicy WHERE login='$login')";
		$zapytanieIV="SELECT AVG(kwota) FROM uzytkownicy WHERE (woj, ilosc_dzieci) in (SELECT woj, ilosc_dzieci FROM uzytkownicy WHERE login='$login')";*/
			
		if	($rezultat = @$polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE Nick='%s'",
		mysqli_real_escape_string($polaczenie, $login)))){
			$ilu_userow = $rezultat->num_rows; 						//ile uzytkownikow  o podanym log i hasl ilosc wierszy
			$rezultatII = @$polaczenie->query($zapytanieII);
			$rezultatIII = @$polaczenie->query($zapytanieIII);
			$rezultatIV = @$polaczenie->query($zapytanieIV);
			if($ilu_userow>0){
					$wiersz = $rezultat->fetch_assoc();
					
					if(password_verify($haslo, $wiersz['Haslo'])){
						$_SESSION['login']=$wiersz['login']; //NOWE
						$_SESSION['zalogowany']=true;
						
					/*	$wierszII = $rezultatII->fetch_assoc();
						$wierszIII = $rezultatIII->fetch_assoc();
						$wierszIV = $rezultatIV->fetch_assoc();
							$_SESSION['AVG(kwota)'] = $wierszII['AVG(kwota)'];
							$_SESSION['AVG(kwota)2'] = $wierszIII['AVG(kwota)'];
							$_SESSION['AVG(kwota)3'] = $wierszIV['AVG(kwota)'];*/
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