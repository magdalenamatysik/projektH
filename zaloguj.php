<?php
	
	session_start();
	
	if((!isset($_POST['login']))||(!isset($_POST['password']))){
		header('Location: index.php');
		exit();
	}
	
	
	require_once "connect.php";

	$conect = @new mysqli($host,$db_user, $db_password, $db_name);
	
	if($conect->connect_errno!=0){
		echo " Error:".$conect->connect_errno;
	}
	else{ 
		$login =$_POST['login'];
		$haslo1 =$_POST['password'];
			
		$sql = "SELECT*FROM uzytkownicy WHERE login='$login'";
		if($result = @$conect->query($sql)){
			$user =$result->num_rows;
			if($user>0){
				$wiersz =$result->fetch_assoc();
				$hash = $wiersz['password'];
				
				if (password_verify($haslo1,$wiersz['password'])){
					$_SESSION['login'] =$wiersz['login'];
					$_SESSION['zalogowany']=true;
					$_SESSION['id']=$wiersz['ID'];
				
					unset($_SESSION['blad']);
				
					$result->free_result();
					
					header('Location: harmonogram.php');
				}
				
				else{
					header('Location: index.php');
				}
				
	
			}else{
				$_SESSION['blad'] = '<span style ="color:white" >Nieprawidłowy login! </span>';
				
				header('Location: index.php');
			}
		}
		
		$conect->close();
	}

	
	

?>
