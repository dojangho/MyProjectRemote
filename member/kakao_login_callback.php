<?php

session_start();

try{
        
    # 카카오 로그인에 필요한 정보 불러오기
    require_once(__DIR__.'/kakao_config.php');
    require_once('../config.php');
        
    # 서버로 부터 토큰을 발급 받을 수 있는 코드 
    $tokenCode   = $_GET["code"];
        
    # PDO 연결
    $connection = new PDO($dsn, $username, $password, $options);

    # 토큰을 받아오는 url 생성
    $getTokenUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$kakao_config['apiKey']."&redirect_uri=".$kakao_config['callbackUrl']."&code=".$tokenCode;

    $isPost = false;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $getTokenUrl);
    curl_setopt($ch, CURLOPT_POST, $isPost);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $headers = array();
    $loginResponse = curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);

    # Access Token만 따로 뺌
    $accessToken= json_decode($loginResponse) -> access_token; 
    $header = "Bearer ".$accessToken; 
    $getProfileUrl = "https://kapi.kakao.com/v2/user/me";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $getProfileUrl);
    curl_setopt($ch, CURLOPT_POST, $isPost);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $headers = array();
    $headers[] = "Authorization: ".$header;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $kakaoResponse = curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);

    $kakaoResponse = json_decode($kakaoResponse);

    # 데이터 정보 가져오기
    $kakao_user = array(
            
        'password' => $kakaoResponse -> id,
        'username' => $kakaoResponse -> properties -> nickname,
        'email'    => $kakaoResponse -> kakao_account -> email    
        
    );
    
    $sql      = "SELECT * FROM users WHERE username=:username";
    $statment = $connection -> prepare($sql);
    $statment -> bindParam(':username', $kakao_user['username']);
    $statment -> execute();
    $result   = $statment -> fetch(PDO::FETCH_ASSOC);
    
    if($result['username'] === $kakao_user['username']){
        
        $_SESSION['username'] = $kakao_user['username'];
        $_SESSION['email']    = $kakao_user['email'];
        ?>
        <script>document.location.href = '../index.php'; </script> 
        <?php    
    } else {
        
        $sql = "INSERT INTO users(username, email, password) VALUES(:username, :email, :password)";
        $statment = $connection -> prepare($sql);
        $passwordHash = password_hash($kakao_user['password'], PASSWORD_BCRYPT, array("cost" => 12));
        $statment -> bindParam(':username', $kakao_user['username'], PDO::PARAM_STR);
        $statment -> bindParam(':email', $kakao_user['email'], PDO::PARAM_STR);
        $statment -> bindParam(':password', $passwordHash);
        $statment -> execute();
        
        if($statment){
            
            $_SESSION['username'] = $kakao_user['username'];
            $_SESSION['email']    = $kakao_user['email'];
            ?>
            <script>document.location.href = '../index.php'; </script> 
            <?php
            
        }
    }
}catch(PDOException $error){
        
        print $error -> getMessage();
        
    }
