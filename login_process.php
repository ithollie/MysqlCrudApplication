<?php  session_start(); ?>

<?php  #require_once( 'Application.php'); ?>

<?php

	
    #$data  = new Application();
    
    // if  the   email  and   password is  post
	
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        
        //http sessions
		
        $_SESSION['email'] = $_POST["email"];
        $_SESSION['password'] =  $_POST["password"];
        
        $email    =  $_POST["email"];
       
	    $_databaseName = "MysqlCrudApplication";
		
        $conn =  new mysqli("localhost", "root", "",$_databaseName);
       
        $sql = "SELECT *  FROM `register` WHERE email='".$email."'";  
            
        $result = $conn->query($sql) or die($conn->error);
        
        if(mysqli_num_rows($result) > 0){
             
             $sql1 = "SELECT *  FROM `register` WHERE email='".$email."'";  
             
             $result1 = $conn->query($sql1) or die($conn->error);
             
             $row = $result1->fetch_assoc();
             
             saveUserId($row['id']);
              
            if (password_verify($_POST["password"], $row['password'])) {
                
				$_SESSION["email"] = $_POST["email"];
				
                header("Location:home.php?id=".$row['id']);
            
            }elseif(password_verify($_POST["password"], $row['password']) &&  $row['admin'] === "true") {

           
                header("Location:admin.php?id=".$row['id']." &admin=".$row['email']."");  
                

            }else{
                
                echo " That is  not  a valiable  user";
            }
            
                    
        }else{
            
            header("Location:loginFailed.php?message='error'");  
          
        }
        
    }else{
        
        header("Location:login.php");  
		
		echo "Login process   error";
    }
   
    function  saveUserId($id){
        
        $_SESSION['USER_ID'] = $id;
    }
    
    function  getUserId($id){
        
        return  $_SESSION['USER_ID'];
    
    }
?>