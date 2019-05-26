<?php
if(isset($_POST['write'])){
    # DB 연결문 
    try{
    
    require_once('../config.php');
        
    $connection = new PDO($dsn, $username, $password, $options);
        
    $view = 0;
        
    $new_write  = array(
            
        'title'    => $_POST['title'],
        'name'     => $_POST['name'],
        'content'  => $_POST['content'],
        'password' => $_POST['password']
            
    );
        
    $date = date('Y-m-d');
    
    # DB 데이터 입력    
    
    $sql = "INSERT INTO board(name, pwd, title, content, date, view) VALUES(:name, :pwd, :title, :content, :date, :view)";
        
    $statment = $connection -> prepare($sql);
        
    $statment -> bindParam(':name', $new_write['name'], PDO::PARAM_STR);
    $statment -> bindParam(':pwd', $new_write['password'], PDO::PARAM_STR);
    $statment -> bindParam(':title', $new_write['title'], PDO::PARAM_STR);
    $statment -> bindParam(':content', $new_write['content'], PDO::PARAM_STR);
    $statment -> bindParam(':view', $view, PDO::PARAM_INT);
    $statment -> bindParam(':date', $date);
        
    $statment -> execute();
        
    ?>
        
    <script>alert('Successfully'); history.go(-2); </script>
               
    <?php
        
    }catch(PDOException $error){
        
        print $error -> getMessage();
        exit;
        
    }
}else{

# 허용된 접근이 아닐시 오류 메시지 출력

?>

<script>alert('The unauthorized access'); history.back(); </script>


<?php
    
}    
    
?>