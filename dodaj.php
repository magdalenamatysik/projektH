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
					// logowanie/wyk rejestracja, panel urzytkownika,
					$name=$_POST['tytul'];
					$depiction=$_POST['opis'];
					$date =$_POST['data'];
					$time =$_POST['czas'];
					$id= $_SESSION['id'];
					
					if ($polaczenie->query("INSERT INTO zadania VALUES ( NULL,'$id','$name','$depiction', '$time', '$date')"))
					{
						$_SESSION['udanarejestracja']=true;
						
					header('Location: harmonogram.php');
					
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
			}
				
			$polaczenie->close();
			
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}

	
	
?>