<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modalLogin" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header bg-primary">
		    <h5 class="modal-title text-center text-white" id="modalLogin">Login</h5>
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="formLogin = []">
		      <span aria-hidden="true text-primary">&times;</span>
		    </button>
		  </div>
		  <div class="modal-body">
			<form method="post" autocomplete="off" @submit.prevent="addLoginProcess">
			  <div class="form-group">
			    <label for="username">Username</label>
			    <input type="text" class="form-control" id="username" name="username" placeholder="Username" v-model="formLogin.username">
			  	<small class="text-sm-left text-danger" v-html="isError.username"></small>
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" id="password" name="password" placeholder="Password" v-model="formLogin.password">
			  	<small class="text-sm-left text-danger" v-html="isError.password"></small>
			  </div>
			  <div class="form-group">
			  	<label>Login Sebagai</label><br>
			  	<small class="text-sm-left text-danger" v-html="isError.types"></small>
				<div class="form-check form-check-inline">
				  <label class="form-check-label">
				    <input class="form-check-input" type="radio" id="student" v-model="formLogin.types" value="student" name="types">Siswa
				  </label>
				</div>
				<div class="form-check form-check-inline">
				  <label class="form-check-label">
				    <input class="form-check-input" type="radio" id="admin" v-model="formLogin.types" value="admin" name="types"> Admin
				  </label>
				</div>
			  </div>
		      <div class="modal-footer">
				  <div class="w-100 d-flex flex-column">
				  	<button type="submit" class="btn m-auto bg-primary">{{Login}}</button>
				  	<small class="text-sm-center text-danger" v-html="isError.no_account"></small>
				  </div>
		      </div>
			</form>
		  </div>
		</div>
	</div>
</div>

