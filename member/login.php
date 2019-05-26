<?php 
require_once('templates/header.php'); 
require_once(__DIR__.'/kakao_config.php');
require_once(__DIR__.'/google_config.php');
?>

<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				
				<form class="login100-form validate-form flex-sb flex-w" method="post" action="login_process.php">
					
					<span class="login100-form-title p-b-32"> Already, have account? </span>

					<span class="txt1 p-b-11"> Username </span>
					
					<div class="wrap-input100 validate-input m-b-36">
						<input class="input100" type="text" name="username" required="">
						<span class="focus-input100"></span>
					</div>
					
					<span class="txt1 p-b-11"> Password </span>
					
					<div class="wrap-input100 validate-input m-b-12">
						<input class="input100" type="password" name="password" required="">
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
					
					    <div>
							<a href="<?=$kakao_login_url?>" class="txt3" name="kakao_login"> Login with kakao </a>
                        </div>
                        
                        <div>
							<a href="<?=$google_login_url?>" class="txt3" name="kakao_login"> Login with google </a>
                        </div>
					
					    <div>
							<a href="register.php" class="txt3"> Not yet a member? </a>
						</div>
						
						<div>
							<a href="../index.php" class="txt3"> Back to home </a>
				        </div>
				        
				    </div>

					<div class="container-login100-form-btn">
						<input type="submit" name="login_user" class="login100-form-btn" value="login">
					</div>
					
                </form>
			
			</div>
		
		</div>
	</div>

<?php require_once('templates/footer.php'); ?>