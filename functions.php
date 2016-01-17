<?php

	/*  
    // config_global.php
    $servername = "";
    $server_username = "";
    $server_password = "";
    */
	
	//db ühendus
	require_once("../config_global.php");
	$database = "if15_kelllep";

	session_start();
	
	function logInUser($login_username, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, username, password FROM users_db WHERE username=? AND password=?");
        $stmt->bind_param("ss", $login_username, $hash);
        $stmt->bind_result($id_from_db, $email_from_db, $username_from_db, $password_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Kasutaja logis sisse id=".$id_from_db;
			
			// sessioon, salvestatakse serveris
            $_SESSION['logged_in_user_id'] = $id_from_db;
            $_SESSION['logged_in_user_email'] = $email_from_db;
			$_SESSION['logged_in_user_username'] = $username_from_db;

            
			//suuname kasutaja teisele lehel
            header("Location: teine.php");
			
                }else{
                    echo "Vale e-mail või parool!";
                }
                
                $stmt->close();
				//echo $stmt->error;
                //echo $mysqli->error;
		
	}
	
	function createUser($new_email, $hash, $new_username){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO users_db (email, password, username) VALUES (?,?,?)");
		$stmt->bind_param("sss", $new_email, $hash, $new_username);
		$stmt->execute();
		$stmt->close();
                
        $mysqli->close();
            
		
	}
	
	function createNewPost($new_post) {
        
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO posts (users_username, users_id, post, added) VALUES (?,?,?,NOW())");
       
        $stmt->bind_param("sis", $_SESSION['logged_in_user_username'], $_SESSION['logged_in_user_id'], $new_post);
        
        $message = "";
        
        
        if($stmt->execute()){
            $message = "Edukalt andmebaasi salvestatud!";
        }
        
        $stmt->close();
        $mysqli->close();
        
        return $message;
        
    }

	function getPostData($keyword=""){
        
			if($keyword == ""){
				$search = "%%";
			}else{
				$search = "%".$keyword."%";
			}
		
        $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("SELECT id, users_username, added, post FROM posts WHERE deleted IS NULL AND users_username LIKE ? OR deleted IS NULL AND post LIKE ? GROUP BY id DESC");
		$stmt->bind_param("ss", $search, $search);
        $stmt->bind_result($id_from_db, $username_from_db, $added_date_from_db, $post_from_db);
        $stmt->execute();
        

		$array = array();
		
        while($stmt->fetch()){
			$post = new StdClass();
			
			$post->username = $username_from_db;
			$post->added_date = $added_date_from_db;
			$post->post = $post_from_db; 

			array_push($array, $post);
			
		}

		return $array;
		
		       
        $stmt->close();
        $mysqli->close();
    }
    
	

?>