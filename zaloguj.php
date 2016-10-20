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
		$password =$_POST['password'];
		
	
		$sql = "SELECT*FROM uzytkownicy WHERE login='$login' AND password='$password'";
		if($result = @$conect->query($sql)){
			$user =$result->num_rows;
			if($user>0){
				$wiersz =$result->fetch_assoc();
				
				$_SESSION['login'] =$wiersz['login'];
				$_SESSION['zalogowany']=true;
				$_SESSION['id']=$wiersz['ID'];
				
				unset($_SESSION['blad']);
				
				$result->free_result();
				
				header('Location: harmonogram.php');
	
			}else{
				$_SESSION['blad'] = '<span style ="color:white" >Nieprawidłowy login lub hasło! </span>';
				header('Location: index.php');
			}
		}
		
		$conect->close();
	}

	
	

?>
