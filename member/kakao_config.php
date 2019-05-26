<?php

# Rest Api, callback url 생성 후 카카오 로그인 url 생성
$kakao_config = array(
    'apiKey'      => '3d0d934f28c96f3fc19cf09fdbdbe756',
    'callbackUrl' => urlencode('http://localhost/portfolio/member/kakao_login_callback.php'),
);

$kakao_login_url = "https://kauth.kakao.com/oauth/authorize?client_id=".$kakao_config['apiKey']."&redirect_uri=".$kakao_config['callbackUrl']."&response_type=code";

?>
