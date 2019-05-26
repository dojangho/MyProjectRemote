<?php

# 구글 클라이언트 아이디
define('CLIENT_ID', '91465472510-akkqr6r4k6r60ftidldo8undo86d55fh.apps.googleusercontent.com');

# 구글 클라이언트 비밀번호
define('CLIENT_SECRET', 'VJn_qB_dUCD4bNjyAuPA8Odo');

# 구글 클라이언트 리다이렉트 URL
define('CLIENT_REDIRECT_URL', 'http://localhost/portfolio/member/google_login_callback.php');

$google_login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';

?>
