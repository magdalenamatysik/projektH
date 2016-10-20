<?php
	session_start();

	require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		
	
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
					
					if ($result = $polaczenie->query("SELECT*FROM zadania WHERE ID_uzytkownika='$_SESSION('id') "))
					{
						echo $result;
						
						header('Location: harmonogram.php');
	
					}else{
						$_SESSION['blad'] = '<span style ="color:white" >Nieprawidłowy login lub hasło! </span>';
						header('Location: index.php');
						}
	
			}	
			$polaczenie->close();
			
			
		}catch(Exception $e)
		 {
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}

		
?>