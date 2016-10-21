<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany'])){
		header('Location: index.php');
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



	<div id="container">
		
		
		
		<div id="menu">
		

			<div id ="user_panel">
				<div id="tekstt">
				Hej, <?php echo $_SESSION['login']; ?> </br>
									<?php echo "<a href ='logout.php' style= 'color: white; text-decoration: none'> wyloguj się </a>";
									 ?>
				</div>
		
			</div>
			
			
			<div id= "add_meet">
				<div id="tekst">
				dodaj spotkanie/zadanie
				</div>
			
			</div>
		
		</div>
		
		<div id="list">
			<div class ="task" > aaa </div>
			<div class ="task" > aaa </div>
			<div class ="task" > aaa </div>
			<div class ="task" > aaa </div>
			<div class ="task" > aaa </div>
			<div class ="task" > aaa </div>
			<div class ="task" > aaa </div>
			

		</div>
	
	
		<div id="harm">
			
			<div class="day">
				<div class="tekst2"> Poniedziałek </div>
			</div>
			<div class="day">
				<div class="tekst2"> Wtorek </div>
			</div>
			<div class="day">
				<div class="tekst2"> Środa </div>
			</div>
			<div class="day">
				<div class="tekst2"> Czwartek </div>
			</div>
			<div class="day">
				<div class="tekst2"> Piątek </div>
			</div>
			<div class="day">
				<div class="tekst2"> Sobota </div>
			</div>
			<div class="day">
				<div class="tekst2"> Niedziela </div>
			</div>
			
   
		</div>
	
	 
	
	</div>
	
	


				
				<!-- The Modal meet -->
				<div id="add_task_model" class="modal">

					<!-- Modal content -->
					<div class="modal-content">
					<span class="close">x</span>
						
						<form action="dodaj.php" method="post">
							<div class ="tekst5">Dodaj spotkanie</div>
							
							<div class="polel" > tytuł: </div> 
							<div class="poler" > <input type="text" name="tytul" />
							</div>
							<div class="polel" > opis: </div> 
							<div class="poler" > <input name="opis" />
							</div>
							<div class="polel" > deadline: </div> 
							<div class="poler" > <input style="width:160px" type="date" name="data" />
							</div>
							<div class="polel" > czas: </div> 
								<div class="poler" > <input name="czas" />
							</div>
						
							
						
						<input type="submit" class="button" style="margin-top: 5px" value="dodaj" />
		
						</form>
					</div>

				</div>
<script >
// Get the modal
var modal = document.getElementById('add_task_model');

// Get the button that opens the modal
var btn = document.getElementById("add_meet");
// Get the modal

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}







</script>	
	
	
</body>
</html>