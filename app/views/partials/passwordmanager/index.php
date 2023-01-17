<div class="container">
	<div>
		<h3>Reset Password </h3>
		<small class="text-muted">
			Silahkan gunakan alamat emailmu untuk reset password
		</small>
	</div>
	<hr />
	<div class="row">
		<div class="col-md-8">
			<?php 
				$this :: display_page_errors(); 
			?>
			<form method="post" action="<?php print_link("passwordmanager/postresetlink?csrf_token=" . Csrf::$token); ?>">
				<div class="row">
					<div class="col-9">
						<input value="<?php echo get_form_field_value('email'); ?>" placeholder="Masukan Emailmu.." required="required" class="form-control default" name="email" type="email" />
					</div>
					<div class="col-3">
						<button class="btn btn-success" type="submit"> Kirim <i class="fa fa-envelope"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<br />
	<div class="text-info">
	Tautan akan dikirim ke email Anda yang berisi informasi yang Anda butuhkan untuk kata sandi Anda
	</div>
</div>




