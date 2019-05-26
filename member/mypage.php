<?php

# 세션 시작
session_start();

require_once('templates/header.php');

?>
    <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				
				<form class="login100-form validate-form flex-sb flex-w" method="post" action="mypage_process.php">
					
					<span class="login100-form-title p-b-32"> DON'T HAVE AN ACCOUNT? </span>

					<span class="txt1 p-b-11"> Username </span>
					
					<div class="wrap-input100 validate-input m-b-36">
						
						<input class="input100" type="text" name="username" required="" value="<?=$_SESSION['username'];?>" disabled>
						<span class="focus-input100"></span>
					
					</div>
					
					<span class="txt1 p-b-11"> Email Address </span>
					
					<div class="wrap-input100 validate-input m-b-36">
						
						<input class="input100" type="text" name="email" required="" value="<?=$_SESSION['email'];?>" disabled>
						<span class="focus-input100"></span>
					
					</div>
					
					<span class="txt1 p-b-11"> current password </span>
					
					<div class="wrap-input100 validate-input m-b-12">
						
						<input class="input100" type="password" name="current_password" required="">
						<span class="focus-input100"></span>
					
					</div>
					
					<span class="txt1 p-b-11"> new password </span>
					
					<div class="wrap-input100 validate-input m-b-12">
						
						<input class="input100" type="password" name="new_password" required="">
						<span class="focus-input100"></span>
					
					</div>
					
					<span class="txt1 p-b-11"> re-enter new password </span>
					
					<div class="wrap-input100 validate-input m-b-12">
						
						<input class="input100" type="password" name="re_new_password" required="">
						<span class="focus-input100"></span>
					
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
						
						<div>
							<a href="../index.php" class="txt3"> Back to home </a>
						</div>
					
					</div>
					
					<div class="container-login100-form-btn">
						<input type="submit" name="change_password" class="login100-form-btn" value="Save Details">
					</div>
				
				</form>
			
			</div>
		
		</div>
	
    </div>

<?php require_once('templates/footer.php'); ?>