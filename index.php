<?php
	session_start();
	if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true)){
		header('Location: harmonogram.php');
		exit();
	}


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Harmonogram</title>
	<meta name="description" content="Strona tworzaca harmonogram zajec" />
	<meta name="keywords" content="harmonogram plan" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="styl.css" type="text/css" />
	
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	
	<link href='http://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	
	
	
	
</head>

<body>



	
	
		<div id ="logframe">
			
			<form action="zaloguj.php" method="post">
				<div class ="tekst3">Zaloguj się</div>
				
				<div class="polel" > login: </div> 
				<div class="poler" >  <input name="login" /> </div>
				<div class="polel" > hasło: </div> 
				<div class="poler" >  <input type="password" name="password" /> </div>

				<input type ="submit" class="button" value ="Zaloguj" />
				
				
			</form>
		
			
			<div class ="tekst4" >Nie masz konta? </div>
			<a href="rejestracja.php" > <Button  class="button" /> Zarejestruj się </Button> </a>
			
			
		</div>
		<?php 
			if(isset ($_SESSION['blad']))echo $_SESSION['blad'];
		?> 

			



	


</body>
</html>


