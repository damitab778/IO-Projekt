<?php
	session_start();
	if(!isset($_SESSION['udalosie'])){
		header('Location: index.php');
		exit();
	}
	else{
		unset($_SESSION['udalosie']);
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
</head>
<body>
Dziękujemy za rejestracje!<br /> <br />

<a href="index.php">Zaloguj się na swoje konto</a>

</body>
</html>