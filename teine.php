<?php
	require_once("functions.php");
	
	if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: home.php");
    }

	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: home.php");
    }

    // muutujad v‰‰rtustega
    $new_post = $m = "";
    $new_post_error = "";
	$post_array = getPostData();
    //echo $_SESSION['logged_in_user_id'];
    
    // valideerida v‰lja ja k‰ivita fn
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["send_post"])){
            
            if ( empty($_POST["new_post"]) ) {
                $new_post_error = "ei saa olla t¸hi";
            }else{
                $new_post = cleanInput($_POST["new_post"]);
            }
            
            //erroreid ei olnud k‰ivitan funktsiooni,
            //mis sisestab andmebaasi
            if($new_post_error == ""){
                // m on message mille saadame functions.php
                $m = createNewPost($new_post);
                
                if($m != ""){
                    // teeme vormi t¸hjaks
                    $new_post = "";
                    
                }
            }
         //header( "Refresh:3; url=table.php", true, 303);
		 
        }
		header( "Refresh:1; url=teine.php", true, 303);
    }
    
    
	$keyword = "";
    if(isset($_GET["keyword"])){
        $keyword = $_GET["keyword"];
    
    $post_array = getPostData($keyword);
	
	}else{
		$post_array = getPostData();
		
	}


	
	
    // kirjuta fn 
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    
    // k¸sime tabeli kujul andmed
    getPostData();

	
	
	
	

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
	.tcAlert { color: orange; }
	.tcWarn { color: red; }
</style>
<script src="jquery-1.4.3.min.js" type="text/javascript"></script>
<script src="jquery.textCounter.js" type="text/javascript"></script>
<script>
	$(function(){
		$('#theCounter').textCounter({
			target: '#myTextarea', // required: string
			count: 70, // optional: integer [defaults 140]
			alertAt: 20, // optional: integer [defaults 20]
			warnAt: 10, // optional: integer [defaults 0]
			stopAtLimit: false // optional: defaults to false
		});
	});
</script>
	
	
  </head>

 
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-3 sidebar">
			 
				
					<div class="col-sm-12 col-md-12" style="background-color:white">
					<br>
						<div class="col-sm-3 col-md-pull-1 col-md-3 col-md-pull-1">
							<img src="./pics/pilt.png" alt="Responsive image" class="img-circle" style="width:100px; height:100px; background-image: url(<?=$profile_image_url;?>); background-size: cover; background-position-x: center; background-position-y: center;">
						</div>
						
						
						<div class="col-sm-9 col-sm-push-1 col-md-9 col-md-push-1" >
						<ul class="nav ">
							<?=$_SESSION['logged_in_user_username'];?>
							<li><a href="#">Profiil</a></li>
							<li><a href="?logout=1">Logi v√§lja</a></li>
							<br>
						</ul>	
						</div>
					</div>	
					
				
							
				
				
			 <br><br><br><br><br><br><br><br>
			 <div class="col-sm-12 col-md-12" style="background-color:white">
				  <ul class="nav nav-sidebar">
					<li><a href="">M√§rks√µnad</a></li>
					<li><a href="">M√§rks√µna1</a></li>
					<li><a href="">M√§rks√µna2</a></li>
					<li><a href="">M√§rks√µna3</a></li>
					<li><a href="">M√§rks√µna4</a></li>
				  </ul>
          </div>
        </div>
		
		
        <div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
		
		
		<div class="col-sm-12 col-md-12 " style="background-color:white">
          
		  <h1 class="page-header">Postitused</h1>

          

			 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		  		<div class="form-group">
				  <label for="post">Lisa uus postitus:</label>
				  <textarea class="form-control" rows="4" name="new_post" id="new_post" type="text" value="<?=$new_post;?>" <?=$new_post_error;?>></textarea>
				</div>
		

			  	 <button type="submit" name="send_post" class="btn btn-default">Postita</button>

			  </form>
			
		</div>
		
		
		  
		
			<div class="col-sm-12 col-md-12" style="background-color:white">
<br>
			  <div class="table-responsive">
            <table class="table table-striped">
			<head>
			   <style>
			   table {border-collapse:collapse; table-layout:fixed; width:310px;}
			   table td {width:100px; word-wrap:break-word;}
			   </style>
			</head>
              <tbody>
                <?php 

					for($i = 0; $i < count($post_array); $i++){

						echo "<tr>";
						echo "<td>".$post_array[$i]->username."</td>";
						echo "<td>".$post_array[$i]->added_date."</td>";
						echo "<td>".$post_array[$i]->post."</td>";
						echo "</tr>";


					}
					
					
				?>
                
              </tbody>
            </table>
          </div>
			</div>
	</div>	
	  
	  <div class="col-sm-3 col-sm-offset-9 col-md-3 col-sm-offset-9 sidebar">
		<div class="col-sm-12 col-md-12">
		
          <div id="imaginary_container"> 
		  <form action="teine.php" method="get">
                <div class="input-group stylish-input-group">
				
                    <input type="search" name="keyword" class="form-control" value="<?=$keyword?>"  placeholder="Search" >
					<span class="input-group-addon">
						<button type="submit" name="search" value="otsi">
							<span class="glyphicon glyphicon-search"></span>
						</button>  
					</span>
					
                </div>
			<form>
            </div>
		
         </div>
		 
        </div>
    
	
	


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
