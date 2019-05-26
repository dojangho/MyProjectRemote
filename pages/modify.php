<?php require_once(__DIR__.'/templates/header.php'); ?>

<?php 

try{
    
    require_once('../config.php');
    require_once('../common.php');
    
    $no = $_GET['id'];
    
    $connection = new PDO($dsn, $username, $password, $options);
    
    $sql = "SELECT * FROM board WHERE id=:no";
    $statment = $connection -> prepare($sql);
    $statment -> bindParam(':no', $no, PDO::PARAM_INT);
    $statment -> execute();
    $result   = $statment -> fetch(PDO::FETCH_ASSOC);
    
}catch(PDOException $error){
    
    print $error -> getMessage();
    
}

?>

<?php require_once(__DIR__.'/templates/header.php'); ?>

<form name="tx_editor_form" id="tx_editor_form" action="modify_process.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">

<div id="write_box">  
    
    <input type="hidden" name="id" value="<?=escape($no);?>">
    
    <div id="in_title">
       <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required><?php print escape($result['title']); ?></textarea>
    </div>
    
    <div class="wi_line"></div>
                    
    <div id="in_name">
       <textarea name="name" id="uname" rows="1" cols="55" placeholder="글쓴이" maxlength="100" required><?php print escape($result['name']); ?></textarea>
    </div>
    
    <div class="wi_line"></div>

</div>   

<div style="height:10px;"></div>

<div style="width:750px;">

<?php require_once ('editor_modify.php');  ?>

<div id="in_pw">
    
    <input type="password" name="password" id="upw"  placeholder="비밀번호" required />  
</div>

<div id="write_btn">
   
   <input type="button" value="글 작성" onClick="saveContent();">
 
</div>

</div>

</form>

<?php require_once(__DIR__.'/templates/footer.php'); ?>
