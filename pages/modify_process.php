<?php

try{
        
    require_once('../config.php');
        
    $connection = new PDO($dsn, $username, $password, $options);
        
    $new_modify = array(
            
        'title'    => $_POST['title'],
        'name'     => $_POST['name'],
        'content'  => $_POST['content'],
        'password' => $_POST['password'],
        'id'       => $_POST['id']
            
    );
        
    $sql = "UPDATE board SET name=:name, pwd=:password, title=:title, content=:content WHERE id=:id";
        
    $statment = $connection -> prepare($sql);
    $statment -> bindParam(':name', $new_modify['name'], PDO::PARAM_STR);
    $statment -> bindParam(':password', $new_modify['password'], PDO::PARAM_STR);
    $statment -> bindParam(':title', $new_modify['title'], PDO::PARAM_STR);
    $statment -> bindParam(':content', $new_modify['content'], PDO::PARAM_STR);
    $statment -> bindParam(':id', $new_modify['id'], PDO::PARAM_STR);
        
    $statment -> execute();
        
    ?>
        
    <script>alert('Successfully'); history.go(-2); </script>
        
    <?php
        
}catch(PDOException $error){
        
    print $error -> getMessage();
    exit;
        
}

?>