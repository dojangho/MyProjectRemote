<?php require_once(__DIR__.'/templates/header.php'); ?>

<?php

try{
    
    # DB 정보 불러오기
    
    require_once('../config.php');
    require_once('../common.php');
    
    # 글 번호 값 받아오기
    
    $no = $_GET['id'];
    
    # DB 연결
    
    $connection = new PDO($dsn, $username, $password, $options);
    
    # 글 불러오기
    
    $sql = "SELECT * FROM board WHERE id=:no";
    $statment = $connection -> prepare($sql);
    $statment -> bindParam(':no', $no);
    $statment -> execute();
    $result = $statment -> fetch(PDO::FETCH_ASSOC);
    
    # 조회수 중복 증가 방지
    
    if(!empty($no) && empty($_COOKIE['board_view_'.$no])){
        
        $sql = 'UPDATE board SET view=view + 1 WHERE id=:no';
        $statment = $connection -> prepare($sql);
        $statment -> bindParam(':no', $no);
        $statment -> execute();
        
        # 값이 있는지 확인 후 값이 없다면 쿠키 생성
        
        if(empty($statment)){
            ?>
            
            <script>alert('The unauthorized access') history.back();</script>
            
            <?php
            
            }else{
            
            setcookie('board_view_'.$no, TRUE, time() + (60 * 60 * 24), '/');
            
        }
    }
    
}catch(PDOException $error){
    
    print $error -> getMessage();
    
}

?>

<!-- 글 불러오기 -->

<div id="board_read">
    
    <h2><?php print escape($result['title']); ?></h2>
    
    <div id="user_info">
        
        <?php print escape($result['name']); ?> 
        <?php print escape($result['date']);?> 
        
        조회수 : <?php print escape($result['view']);?>
        
        <div id="bo_content">
            <?php print nl2br($result['content']); ?>
        </div>
        
        <div id="bo_ser">
            
            <!-- 목록 수정 삭제 -->
            
            <ul>
                <li><a href="../index.php">[목록으로]</a></li>
                <li><a href="modify.php?id=<?php print escape($no); ?>">[수정]</a></li>
                <li><a href="delete.php?id=<?php print escape($no); ?>">[삭제]</a></li>
            </ul>
            
        </div>
        
    </div>
</div>

<?php require_once(__DIR__.'/templates/header.php'); ?>