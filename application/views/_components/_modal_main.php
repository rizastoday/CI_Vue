<!-- Modal Login -->
<div class="modal animated fadeIn" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modalLogin" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header" :class="warnaNavbar">
		    <h5 class="modal-title text-center" :class="warnaText" id="modalLogin">Login Admin</h5>
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		      <span aria-hidden="true" :class="warnaText">&times;</span>
		    </button>
		  </div>
		  <div class="modal-body">
			<form method="post" autocomplete="off" action="<?= base_url('login/login_process') ?>">
			  <div class="form-group">
			    <label for="username">Username</label>
			    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Username">
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" id="password" name="password" aria-describedby="passhelp" placeholder="Password">
			    <small id="passhelp" class="form-text text-muted">Sebaiknya gunakan password yang sulit ditebak</small>
			  </div>
		      <div class="modal-footer">
				  <div class="w-100 d-flex">
				  	<button type="submit" class="btn m-auto" :class="warnaNavbar">Login</button>	
				  </div>
		      </div>
			</form>
		  </div>
		</div>
	</div>
</div>