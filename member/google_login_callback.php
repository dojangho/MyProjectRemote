<?php

session_start();

if(isset($_GET['code'])) {
    
	try {
        
        # 데이터 정보 가져오기
        require_once(__DIR__.'/google_config.php');
        require_once(__DIR__.'/google_login_api.php');
        require_once('../config.php');
        
        # API에 필요한 객체 생성
		$google_api = new GoogleLoginApi();
		
		# 액세스 토큰 받아오기 
		$data = $google_api -> GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
		
        
		# 구글 유저 정보 배열에 저장
		$google_user = $google_api -> GetUserProfileInfo($data['access_token']);
        
        # PDO를 이용한 MYSQL 연결
        $connection = new PDO($dsn, $username, $password, $options);
        
        # 구글로그인으로 이미 가입이 되어있는지 확인 
        $sql       = "SELECT * FROM users WHERE username=:username";
        $statment  = $connection -> prepare($sql);
        $statment -> bindParam(':username', $google_user['name']);
        $statment -> execute();
        $result    = $statment -> fetch(PDO::FETCH_ASSOC);
        
        # MYSQL에 있는 저장된 데이터와 구글 로그인 데이터 값이 같다면 로그인 아니면 MYSQL 데이터 저장 
        if($result['username'] === $google_user['name']){
            
            $_SESSION['username'] = $google_user['name'];
            $_SESSION['email']    = $google_user['email'];
            
            # 세션 생성 후 리다이렉트
            header("location: ../index.php");
            
        } else {
            
            # 위에 일치한 데이터가 없다면 데이터 저장  
            $sql = "INSERT INTO users(username, email, password) VALUES(:username, :email, :password)";
            $statment = $connection -> prepare($sql);
            $statment -> bindParam(':username', $google_user['name']);
            $statment -> bindParam(':email', $google_user['email']);
            $statment -> bindParam(':password', $google_user['id']);
            $statment -> execute();
            
            if($statment){
                
                # 로그인을 위한 세션 생성 
                $_SESSION['username'] = $google_user['name'];
                $_SESSION['email']    = $google_user['email'];
                
                # 로그인 후 리다이렉트
                header("location: ../index.php");
            }
        }
    }
    
	catch(Exception $error) {
        
		print $error -> getMessage();
		exit();
        
	}
} else {
?>
<script>alert('The unauthorized access'); history.back(); </script>
<?php
}
?>
