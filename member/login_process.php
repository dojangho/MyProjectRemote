<?php

# 세션 시작
session_start();

# 로그인 버튼 클릭이 있다면 코드 실행
if(isset($_POST['login_user'])){
    
    try{
        
        require_once('../config.php');    
        
        $connection = new PDO($dsn, $username, $password, $options);
        
        $login_user = array(
            'username' => $_POST['username'],
            'password' => $_POST['password']
        );
        
        
        $sql = "SELECT * FROM users WHERE username=:username";
        
        $statment = $connection -> prepare($sql);
        $statment -> bindParam(':username', $login_user['username'], PDO::PARAM_STR);
        $statment -> execute();
        $result = $statment -> fetch();
        
        if($result === false){
        ?>
            
            <script>alert("Incorrect username / password combination !"); history.back(); </script>
            
        <?php  
            
        }else{
            
            $validPassword = password_verify($login_user['password'], $result['password']);
            
            
            if($validPassword){
                
                $_SESSION['username']    =  $result['username'];
                $_SESSION['email']       =  $result['email'];
                
                header("Location: ../index.php"); 
                
            }else{
            
            ?>    
            
            <script>alert("Incorrect username / password combination !"); history.back(); </script>
            
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