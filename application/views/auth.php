<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V10</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href ="<?php echo base_url()?>aset/fonts/font-awesome-4.7.0/css/font-awesome.min.css " rel="stylesheet" type="text/css">
	<link href="<?php echo base_url()?>aset/css/main.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url()?>aset/css/util.css" rel="stylesheet" type="text/css">
	
</head>
<body>
		<div class="container-login100">
			<div class="wrap-login100 p-t-30 p-b-40">	
				<form class="login100-form validate-form flex-sb flex-w">
					<div class="wrap_logo">
						<img src="image/logo_up.png">
					</div>
				
					<span class="login100-form-title p-b-30 p-t-10">
						Sistem Informasi Pengelolaan Laboratorium QLab Fakultas Farmasi Universitas Pancasila
					</span>
					
					<span class="login200-form-title p-b-13 p-t-5">
						<marquee width="100%" height="20" style="color:purple; text-transform:capitalize; font-size:13px;">Silahkan login untuk dapat menggunakan sistem informasi pengelolaan laboratorium Qlab</marquee>
					</span>
					
					<div class="wrap-input100 validate-input m-b-11" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-t-3 p-b-24">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="#" class="txt1">
								Forgot?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					
					<span class="login300-form-copyright m-t-17">
						 &copy; SIP Laboratorium QLab 2019, Develop by Bradika
					</span>
				</form>
			</div>
		</div>
</body>
</html>