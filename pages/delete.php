<?php
try{
    
    require_once('../config.php');
    
    $no = $_GET['id'];
    
    $connection = new PDO($dsn, $username, $password, $options);
    
    $sql = "DELETE FROM board WHERE id=:no";
    
    $statment = $connection -> prepare($sql);
    $statment -> bindParam(':no', $no, PDO::PARAM_INT);
    
    $statment -> execute();
    
    ?>

    <script> alert('Successfully'); history.go(-2);</script>

    <?php
    
}catch(PDOException $error){
    
    print $error -> getMessage();
    exit;
    
}
?>