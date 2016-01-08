<?php
	// create_new_user.php
	require_once("functions.php");

	if(isset($_SESSION['logged_in_user_id'])){
        header("Location: data.php");
    }
	
	$domain = "";


	
	//login error
	$login_email_error = "";
	$login_password_error = "";
	
	//muutujad väärtustega
	$login_email = "";
	$login_username ="";
	$login_password = "";

	
	//create errorid
	$new_username_error = "";
	$new_email_error = "";
	$new_password_error = "";
	
	//muutujad väärtustega
	$new_username = "";
	$new_email = "";
	$new_password = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// kontrollin kas muutuja $_POST ["login"], ehk login nupp
		if(isset($_POST["login"])) {
			
			
			//Kontrollime kasutaja e-posti, et see ei ole tühi
			if(empty($_POST["login_email"])) {
				$login_email_error = "ei saa olla tühi";
			} else {
				//annan väärtuse
				$login_email = test_input($_POST["login_email"]);
			}	
		
			//Kontrolli parooli
			if(empty($_POST["login_password"])) {
				$login_password_error = "sisesta parool";
			} else {
				$login_password = test_input($_POST["login_password"]);
			}

			if($login_password_error == "" && $login_email_error == ""){
				//erroreid ei olnud
				echo "Kontrollin ".$login_email." ".$login_password;
		
		 $hash = hash("sha512", $login_password);
		 
		 loginUser($login_email, $login_username, $hash);
		 
			}
                	
		}
	}	

		
		//kasutaja vajutab create nuppu
		if(isset($_POST["create"])) {
			//emaili kontroll
						
			if(empty($_POST["new_email"])) {
				$new_email_error = "ei saa olla tühi";
			} if(stristr($_POST["new_email"], "tlu.ee") == false) {
				$new_email_error = "peab olema tlu mail";
				} else{
					$new_email = test_input($_POST["new_email"]);
					$new_username = array_shift(explode("@", $new_email));

				}
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
		
				
				
		createUser($new_email, $hash, $new_username);
				
			
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

<!--LOGIN--
	<nav class="navbar navbar-default navbar-fixed-top">
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">
						<img alt="Brand" src="./pics/logo_1899910_web.jpg">
					</a>
				</div>
			</div>
		</nav>
	</nav>
<!--LOGIN-->
<br><br><br><br>

<div class="container-fluid">
<br>

	<div class="jumbotron">
		<div class="row">
			<div class="col-sm-8">
				<h1>My First Bootstrap Page</h1>
				<p>Resize this responsive page to see the effect!</p> 
			</div>
			
			
			<!--LOGIN-->
			<!--LOGIN-->
			<!--LOGIN-->
			
			<div class="col-sm-4"" style="background-color:white">
				<br>
				
				
				<div class="col-sm-12">
				<br>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group">
				<input type="email" class="form-control" name="login_email" placeholder="Email"> <?php echo $login_email_error; ?>
			</div>
				  

			<div class="row">
					
				<div class="col-lg-8">
					<div class="form-group">
						<input type="password" class="form-control" name="login_password" placeholder="Password"> <?php echo $login_password_error; ?>
					</div>
				</div>
						
											
				<div class="col-lg-4 hidden-sm hidden-md">
					<button name="login" type="submit" class="btn btn-info btn-block">Login 1</button>
					
				</div>
						
				<div class="col-lg-4 hidden-lg hidden-xs pull-right">
					<button name="login" type="submit" class="btn btn-info">Login 2</button>
				</div>
										  
			</div>
				   
		</form>
				</div>				  
					
				   
				
				
			</div>
			
			
			
			<!--CREATE-->
			<!--CREATE-->
			<!--CREATE-->
			
				<div class="col-sm-offset-8 col-sm-4" style="background-color:white">
				<h4>Ei ole kasutajat? Loo uus</h4>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			
		
			<div class="form-group">
				<input type="email" class="form-control" name="new_email" placeholder="Email"> <?php echo $new_email_error; ?>
			</div>
				  

			<div class="row">
					
				<div class="col-lg-8">
					<div class="form-group">
						<input type="password" class="form-control" name="new_password" placeholder="Password"> <?php echo $new_password_error; ?>
					</div>
				</div>
						
											
				<div class="col-lg-4 hidden-sm hidden-md">
					<button name="create" type="submit" class="btn btn-info btn-block">Create 1</button>
				</div>
						
				<div class="col-lg-4 hidden-lg hidden-xs pull-right">
					<button name="create" type="submit" class="btn btn-info">Create 2</button>
				</div>
										  
			</div>
				   
		</form>
	</div>
			
		</div>
	</div>
  


  <div class="row">
    <div class="col-sm-4">
      <h3>Column 1</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
    <div class="col-sm-4">
      <h3>Column 2</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
    <div class="col-sm-4">
      <h3>Column 3</h3>        
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
  </div>
</div>

</body>
</html>
