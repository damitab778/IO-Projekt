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
			$zapytanieII="SELECT kwota FROM kwota k INNER JOIN dziecko d ON d.ID_dziecko=k.ID_dziecko INNER JOIN uzytkownicy u ON d.ID_user=u.ID_user WHERE Nick='$login'";
		if	($rezultat = @$polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE Nick='%s'",
		mysqli_real_escape_string($polaczenie, $login)))){
			$ilu_userow = $rezultat->num_rows; 						//ile uzytkownikow  o podanym log i hasl ilosc wierszy
					if($ilu_userow>0){
					$wiersz = $rezultat->fetch_assoc();
					if(password_verify($haslo, $wiersz['Haslo'])){
						
						$rezultatII = @$polaczenie->query($zapytanieII);
						$wierszII = $rezultatII->fetch_assoc();
						$_SESSION['kwota'] = $wierszII['kwota']; #!!!!!!!!!
						
						$_SESSION['Nick']=$wiersz['Nick']; 		  #!!!!!!!!!
						
						
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