<?php

	// create_new_user.php
	require_once("functions.php");

	if(isset($_SESSION['logged_in_user_id'])){
        header("Location: data.php");
    }
	
	

	//login error
	$email_error = "";
	$password_error = "";

	
	//create errorid
	$new_username_error = "";
	$new_email_error = "";
	$new_password_error = "";
	
	//muutujad väärtustega
	$new_username = "";
	$new_email = "";
	$new_password = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {
	
		if(isset($_POST["create"])) {
			//emaili kontroll
			if(empty($_POST["new_email"])) {
				$new_email_error = "ei saa olla tühi";
			} else {
				$new_email = test_input($_POST["new_email"]);
			}
						
			//parooli kontroll
			if(empty($_POST["new_password"])) {
				$new_password_error = "sisesta parool";
			} else {
				$new_password = test_input($_POST["new_password"]);
			
				//parooli pikkuse kontroll
				if(strlen($_POST["new_password"]) < 8 ){
				
					$new_password_error = "Peab olema vähemalt 8 sümbolit pikk";
				}
			}	
		
			if(	$new_email_error == "" && $new_password_error == ""){
				echo hash("sha512", $new_password);
				echo "Võib kasutajat luua! Kasutajanimi on ".$new_email." ja parool on ".$new_password;
                
		$hash = hash("sha512", $new_password);
                
				//nime kontroll
				if (empty($_POST["new_username"])) {
					$new_username_error = "Palun sisesta kasutajanimi";
					} else {
				$new_username = test_input($_POST["new_username"]);
				}
				
		createUser($new_email, $hash, $new_username);
				
			
			}
		}
	}
		//üleliigse eemaldamine tekstist
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}















?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
	<h2> LAHE </h2>
Tere, <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1">Logi välja</a>
</body>
</html>
