<?php

session_start();

if(isset($_POST['change_password'])){
    
    try{
        
        require_once('../config.php');
        
        $connection = new PDO($dsn, $username, $password, $options);
        
        $password = array(
            
            'current_password' => $_POST['current_password'],
            'new_password'     => $_POST['new_password'],
            're_password'      => $_POST['re_new_password']
            
        );
        
        # 저장 되어 있는 비밀번호 확인하기 위해 호출 
        
        $sql = 'SELECT * FROM users WHERE username=:username';
        
        $statment = $connection -> prepare($sql);
        $statment -> bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
        $statment -> execute();
        $result   = $statment -> fetch();
        
        # 입력한 비밀 번호와 저장되어 있는 비밀번호가 일치하는지 확인
        
        $validPassword = password_verify($password['current_password'], $result['password']);
        
        if($validPassword){
            
            # 변경할 비밀 번호가 서로 같다면 UPDATE 그렇지 않다면 경고창 출력
            if($password['new_password'] = $password['re_password']){
                
                $update_sql = 'UPDATE users SET password=:password WHERE username=:username';
                $update_statment  = $connection -> prepare($update_sql);
                $password_hash    = password_hash($password['new_password'], PASSWORD_BCRYPT, array("cost" => 12));
                $update_statment -> bindParam(':password', $password_hash);
                $update_statment -> bindParam(':username', $_SESSION['username']);
                $update_statment -> execute();
            
            ?>
            <script>alert('Successfully'); history.go(-2); </script>
            <?php 
                
            }else{
                
            ?>
            <script>alert("new password and re password do not match!"); history.back();</script>
            <?php
                
            }
            
        }else{
            
            ?>
            <!-- 비밀 번호가 일치하지 않다면 경고창 출력-->
            <script>alert("password combination !"); history.back(); </script>
            <?php
            
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