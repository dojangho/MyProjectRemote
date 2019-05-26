<?php require_once('templates/header.php'); ?>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				
				<form class="login100-form validate-form flex-sb flex-w" method="post" action="register_process.php">
					
					<span class="login100-form-title p-b-32"> DON'T HAVE AN ACCOUNT? </span>

					<span class="txt1 p-b-11"> Username </span>
					
					<div class="wrap-input100 validate-input m-b-36">
						
						<input class="input100" type="text" name="username" required="">
						<span class="focus-input100"></span>
					
					</div>
					
					<span class="txt1 p-b-11"> Email Address </span>
					
					<div class="wrap-input100 validate-input m-b-36">
						
						<input class="input100" type="text" name="email" required="">
						<span class="focus-input100"></span>
					
					</div>
					
					<span class="txt1 p-b-11"> Password </span>
					
					<div class="wrap-input100 validate-input m-b-12">
						
						<input class="input100" type="password" name="password" required="">
						<span class="focus-input100"></span>
					
					</div>
					
					<span class="txt1 p-b-11"> Confirm Password </span>
					
					<div class="wrap-input100 validate-input m-b-12">
						
						<input class="input100" type="password" name="confirm_password" required="">
						<span class="focus-input100"></span>
					
					</div>
					
					<div class="flex-sb-m w-full p-b-48">
						
						<div>
							<a href="login.php" class="txt3"> Don't have any login yet? </a>
						</div>
						
						<div>
							<a href="../index.php" class="txt3"> Back to home </a>
						</div>
					
					</div>

					<div class="container-login100-form-btn">
						<input type="submit" name="register_user" class="login100-form-btn" value="Account">
					</div>
				
				</form>
			
			</div>
		
		</div>
	
    </div>

<?php require_once('templates/footer.php'); ?>