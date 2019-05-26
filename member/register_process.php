<?php

session_start();

if(isset($_POST['register_user'])){
    
    try{
        
        require_once('../config.php');
        
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            'username' => $_POST['username'],
            'email'    => $_POST['email'],
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password']
        );
        
        $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
        
        $statment = $connection -> prepare($sql);
        $statment -> bindParam(':username', $new_user['username'], PDO::PARAM_STR);
        $statment -> bindParam(':email', $new_user['email'], PDO::PARAM_STR);
        $statment -> execute();
        $result    = $statment -> fetch(PDO::FETCH_ASSOC);
        
        if($result){
            
            if($result['username'] === $new_user['username']){
            
            ?>
              
              <script>alert("That username already exists!"); history.back(); </script>
              
            <?php
                
            }
            
            if($result['email'] === $new_user['email']){
            
            ?>
            
               <script>alert("That email already exists!"); history.back(); </script>
               
            <?php
                
            }
            
            }else{
        
            if($new_user['password'] != $new_user['confirm_password']){
            
            ?>    
            
                <script>alert("Confirm password and password do not match!"); history.back();</script>
            
            <?php
            
            }else{
                
            $sql = "INSERT INTO users(username, email, password) VALUES(:username, :email, :password)";
            
            $statment = $connection -> prepare($sql);
            $statment -> bindParam(':username', $new_user['username'], PDO::PARAM_STR);
            $statment -> bindParam(':email', $new_user['email'], PDO::PARAM_STR);
            $passwordHash = password_hash($new_user['password'], PASSWORD_BCRYPT, array("cost" => 12));
            $statment -> bindParam(':password', $passwordHash);
            $result = $statment -> execute();
            
            ?>  
            
            <script>alert("Successfully"); location.href = "login.php"; </script>
         
            <?php    
                
            }
            
            }
    
    }catch(PDOException $error){
        
        print $error -> getMessage();
    
    }
} else {
?>
<script>alert('The unauthorized access'); history.back(); </script>
<?php    
}
?>