
	<div class="container">
		<div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
			<div class="card-body p-0">
			<!-- Nested Row within Card Body -->
				<div class="row">
					<div class="col-lg">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
							</div>
								<form class="user" method="post" action="<?php echo base_url('auth/registration') ?>">
									<div class="form-group">
										<input type="text" class="form-control form-control-user" name="name" id="name" placeholder="Nama Lengkap"
										value="<?php echo set_value('name'); ?>">
										<?php echo form_error('name','<small class="text-danger pl-3">','</small>') ?>
									</div>
									<div class="form-group">
										<input type="text" class="form-control form-control-user"  name= "email" id="email" placeholder="Alamat Email"
										value="<?php echo set_value('email'); ?>">
										<?php echo form_error('email','<small class="text-danger pl-3">','</small>') ?>
									</div>
									<div class="form-group row">
										<div class="col-sm-6 mb-3 mb-sm-0">
											<input type="password" class="form-control form-control-user" name="password1" id="password1" placeholder="Password">
											<?php echo form_error('password1','<small class="text-danger pl-3">','</small>') ?>
										</div>
										<div class="col-sm-6">
											<input type="password" class="form-control form-control-user" name="password2" id="password2" placeholder="Ulangi Password">
										</div>
									</div>
									<button class="btn btn-primary btn-user btn-block" type="submit">
									  Daftar Akun
									</button>
								</form>
									<hr>
								<div class="text-center">
									<a class="small" href="#">Lupa Password?</a>
								</di v>
								<div class="text-center">
									<a class="small" href="<?php echo base_url('auth') ?>">Already have an account? Login!</a>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>