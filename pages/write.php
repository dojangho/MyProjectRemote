<?php require_once(__DIR__.'/templates/header.php'); ?>

<form name="tx_editor_form" id="tx_editor_form" action="write_process.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">

<div id="write_box">  
    
    <div id="in_title">
       <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required></textarea>
    </div>
    
    <div class="wi_line"></div>
                    
    <div id="in_name">
       <textarea name="name" id="uname" rows="1" cols="55" placeholder="글쓴이" maxlength="100" required></textarea>
    </div>
    
    <div class="wi_line"></div>

</div>   

<div id="write_empty"></div>

<div id="write_body">

<?php require_once ('editor.php');  ?>

<div id="in_pw">
    
    <input type="password" name="password" id="upw"  placeholder="비밀번호" required />
    <input type="hidden" name="write">  

</div>

<div id="write_btn">
   
   <input type="button" value="글 작성" onClick="saveContent();">
 
</div>

</div>

</form>

<?php require_once(__DIR__.'/templates/footer.php'); ?>

