<?php 

session_start();

require_once('templates/header.php');

try{
    
    # DB 연결 및 이스케이핑 불러오기
    require_once('config.php');
    require_once('common.php');
    
    $connection = new PDO($dsn, $username, $password, $options);
    
    if(isset($_GET['page'])){
        
        $page = $_GET['page'];
        
    }else{
        
        $page = 1;
    
    }
    
    # 게시판 총 레코드 수 구하기
    $page_sql = "SELECT * FROM board";
    
    $page_statment = $connection -> prepare($page_sql);
    $page_statment -> execute();
    
    $row_num = $page_statment -> rowCount();
    
    $list     = 10; # 한 페이지에 보여줄 개수
    $block_ct = 5; # 한 블록당 페이지 개수
    
    # 블록 구하기
    $block_num = ceil($page/$block_ct); # 현재 페이지 블록 구하기
    $block_start = (($block_num - 1) * $block_ct) + 1; # 블록의 시작 번호
    $block_end = $block_start + $block_ct - 1; # 블록의 마지막 번호
    
    $total_page = ceil($row_num / $list); # 페이징 한 페이지 수 구하기
    if($block_end > $total_page) $block_end = $total_page; # 만약 블록의 마지막 번호가 페이지수보다 많다면 마지막 번호는 페이지 수
    $total_block = ceil($total_page / $block_ct); # 블록 총 개수
    $start_num = ($page - 1) * $list;
    
    # 페이지별 게시물 불러오기
    $sql       = "SELECT * FROM board ORDER BY id DESC LIMIT :num, :list";
    $statment  = $connection -> prepare($sql);
    $statment -> bindParam(':num', $start_num, PDO::PARAM_INT);
    $statment -> bindParam(':list', $list, PDO::PARAM_INT);
    $statment -> execute();
    
    $result = $statment -> fetchAll();
    
    # 검색이 있다면 실행하기
    if(isset($_GET['search'])){
        
        # 카테고리와 검색 내용 받아오기
        $catagory         = $_GET['catagory'];
        $search           = $_GET['search'];
        $search_bind      = '%'.$search.'%';
        $search_sql       = "SELECT * FROM board WHERE $catagory LIKE :search ORDER by id DESC";
        $search_statment  = $connection -> prepare($search_sql);
        $search_statment -> bindParam('search', $search_bind);
        $search_statment -> execute();
        
        $search_result    = $search_statment -> fetchAll();
    
    }
    
}catch(PDOException $error){
    
    print $error -> getMessage();

}

?>
    
    <div class="d-flex" id="wrapper">

    <!-- 사이드바 시작 -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Jangho's PortPolio </div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
      </div>
    </div>
    <!-- 사이드바 끝 -->

    <!-- 페이지 컨텐츠 시작 -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
           <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <?php if(!isset($_SESSION['username'])) { ?>
                        <a class="dropdown-item" href="member/login.php">login</a>
                    <?php } else { ?>
                        <a class="dropdown-item" href="member/mypage.php">My page</a>
                        <a class="dropdown-item" href="member/logout.php">logout</a>
                    <?php } ?>        
                    <?php if(!isset($_SESSION['username'])) { ?>
                        <a class="dropdown-item" href="member/register.php">Account</a>
                    <?php } ?>
             </div>
            </li>
          </ul>
        </div>
      </nav>
       <div class="container-fluid">
       
        <div id="board_area">
           
           <h1 class="mt-4">PHP MySQL : CRUD With PDO</h1>
           
            <div id="serach_box">
               <div id="serach_box_padding">
                    <form method="get" action="<?=$_SERVER['PHP_SELF']?>">
                        <select name="catagory" id="select_box">
                            <option value="title">제목</option>
                            <option value="name">글쓴이</option>
                            <option value="content">내용</option>
                        </select>
                        <input type="text" name="search" size="40" required="required">
                        <button>검색</button>
                    </form>
                </div>
            </div>
           
           <table class="list-table">
           
            <thead>
              
               <tr>
                 <th width="70">번호</th>
                 <th width="500">제목</th>
                 <th width="120">글쓴이</th>
                 <th width="100">작성일</th>
                 <th width="100">조회수</th>
               </tr>
               
            </thead>
            
            <tbody>
            <?php
    
            # 검색 값이 없다면 기존 게시물 출력
            if(!isset($_GET['search'])){
                
                foreach($result as $row) { ?>
                
                <tr>
                    <td width="70"> <?php print escape($row['id']); ?></td>
                    <td width="500"><a href="pages/read.php?id=<?php print escape($row['id']); ?>"><?php print escape($row["title"]); ?></a></td>
                    <td width="120"><?php print escape($row['name']); ?></td>
                    <td width="100"><?php print escape($row['date']); ?></td>
                    <td width="100"><?php print escape($row['view']); ?></td>
                </tr>
                
             <?php } 
            # 검색 값이 있다면 검색 게시물 값 출력    
            } else {
                
                foreach($search_result as $search_row) { ?>
                
                 <tr>
                    <td width="70"> <?php print escape($search_row['id']); ?></td>
                    <td width="500"><a href="pages/read.php?id=<?php print escape($row['id']); ?>"><?php print escape($search_row["title"]); ?></a></td>
                    <td width="120"><?php print escape($search_row['name']); ?></td>
                    <td width="100"><?php print escape($search_row['date']); ?></td>
                    <td width="100"><?php print escape($search_row['view']); ?></td>
                </tr>
                
            <?php }
                
            } ?>
            
            
            </tbody>
            
            </table>
            <!-- 게시물 페이징 시작 -->
            <div id="page_num">
                
                <ul>
                    <?php
                    
                    if($page <= 1){
                        
                        print "<li class='fo_re'>처음</li>";
                        
                    }else{
                       
                        print "<li><a href='?page=1'>처음</a></li>";
                        
                    }
                    if($page <= 1){
                        
                    }else{
                        
                        $pre = $page - 1;
                        print "<li><a href='?page=$pre'>이전</a></li>";
                        
                    }
                    
                    for($i = $block_start; $i <= $block_end; $i++){
                        
                        if($page == $i){
                            
                            print "<li class='fo_re''>[$i]</li>";
                            
                        }else{
                            
                            print "<li><a href='?page=$i'>[$i]</a></li>";
                            
                        }
                    }
                    
                    if($block_num >= $total_block){
                        
                    }else{
                        
                        $next = $page + 1;
                        print "<li><a href='?page=$next'>다음</a></li>";
                        
                    }
                    
                    if($page >= $total_page){
                        
                        print "<li class='fo_re'>마지막</li>";
                        
                    }else{
                        
                        print "<li><a href='?page=$total_page'>마지막</a></li>";
                        
                    }
                    
                    ?>
                </ul>
                
            </div>
        <!-- 게시물 페이징 끝 -->
        
         <div id="write_btn">
            <a href="pages/write.php"><button>글 작성</button></a>
         </div>
     

         
         </div>
        </div>
    </div>
</div>
    <!-- 페이지 컨텐츠 끝 -->
 
<?php require_once('templates/footer.php'); ?>
