<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($_SESSION['status'] != "admin") {
	redirect(base_url());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Admin </title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/vuetify.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/mdb.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/iconfont/material-icons.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/all.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.css'); ?>">
    <style type="text/css">
    	.sidebar {
    		height: 100vh;
    		width: 20%;
    	}
    	.content{
    		width: 80%;
    	}
    	.nav-pills .nav-link {
    		border-top-right-radius: 20px !important;
    		border-bottom-right-radius: 20px !important;
    	}
    	.message {
    		height: 3.5rem;
    		border-radius: 25px;
    		width: 90%;
    		transition: .75s all;
    	}
    </style>
</head>
<body>
        <div id="app">
        	<!-- Inisialisasi Vuetify -->
	        <v-app class="animated fadeIn slower" id="inspire">
	        	<!-- Navbar -->
	        	<nav>
	        		<v-toolbar 
	        			app 
	        			color="info"
	        			class=" text-uppercase"
	        			clipped-right
	        			absolute
	        			>

	        			<v-toolbar-side-icon @click.stop="drawer = !drawer" class="text-white"></v-toolbar-side-icon>
	        			<v-toolbar-title class="position-fixed h2-responsive text-white pl-3">
	        				<span class="font-weight-light d-none d-lg-inline">Admin:</span>
	        				<span right>Business-Center</span>
	        			</v-toolbar-title>
		        		<v-spacer></v-spacer>

		        		<!-- Modal Insert Barang -->
						<v-dialog v-model="dialog" width="500" persistent>
							<v-btn slot="activator" flat dark round color="white" title="Tambah Barang" @click="dialog = !dialog">
								<span class="d-none d-lg-block">Tambah</span>
								<v-icon right>add_circle_outline</v-icon>
							</v-btn>
							<v-card>
								<v-card-title class="h3-responsive text-center">Tambah Barang</v-card-title>
								<v-divider></v-divider>

								<v-card-text>
									<v-form method="POST">
										<v-text-field 
											name="kode"
											v-model="modelData.kode"
											prepend-icon="fa fa-user-lock"
											label="Kode Barang"
											required
										></v-text-field>
									    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.kode"></small>

										<v-text-field 
											name="nama_barang"
											v-model="modelData.nama_barang"
											prepend-icon="fa fa-clipboard-list"
											label="Nama Barang"
											required
										></v-text-field>
									    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.nama_barang"></small>


										<v-text-field 
											name="harga"
											v-model="modelData.harga"
											prepend-icon="fa fa-dollar-sign"
											label="Harga Barang"
											type="number"
											required
										></v-text-field>
									    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.harga"></small>


										<v-text-field 
											name="stok"
											v-model="modelData.stok"
											prepend-icon="fa fa-cubes"
											label="Stok Barang"
											type="number"
											required
										></v-text-field>
									    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.stok"></small>

										<v-text-field 
											label="Pilih Foto"
											v-model="imageName"
											prepend-icon="fa fa-file-image"
											style="cursor: pointer;"
											@click="pickPhoto"
										></v-text-field>
										<input type="file" name="photo" style="display: none;" ref="photo" accept="image/*" @change="handlePhoto">
									    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.photo"></small>
									    
									    <div class="col-12">
									    	<img :src="imageURI" class="img-fluid col-8 m-auto justify-content-center img-thumbnail animated fadeIn">
									    </div>


										<v-card-actions>
											<v-btn outline block wrap color="red" flat @click="[dialog = !dialog, modelData = [], isValidate = [], imageURI = '', imageName = '']">Batal</v-btn>
											<v-spacer></v-spacer>
											<v-btn outline block wrap color="indigo" type="button" flat v-html="Simpan" @click="save" ></v-btn>
										</v-card-actions>

									</v-form>
								</v-card-text>
							</v-card>
						</v-dialog>
		        		<!-- /// Modal Insert Barang -->

		        		<v-btn flat round color="white" title="Logout dari admin?" @click="logout">
		        			<span class="d-none d-lg-block">Sign Out</span>
		        			<v-icon right>exit_to_app</v-icon>
		        		</v-btn>
	        		</v-toolbar>
	        	</nav>
	        	<!-- Side Navigasi Drawer -->
		        <v-navigation-drawer
		        	app
		        	v-model="drawer"
		        	fixed
		        	temporary
		        	>
		        	<v-list class="p-1">
		        		<v-list-tile tag="div">
		        			<v-list-tile-content>
		        				<v-list-tile-title class="h3-responsive">ADMIN</v-list-tile-title>
		        			</v-list-tile-content>
		        		</v-list-tile>
		        	</v-list>
		        	<v-list class="p-0 " dense>
		        		<v-divider light class="bg-white"></v-divider>


		    			<v-list-tile class="waves-effect waves-dark" v-for="item in homes" :key="item.title" :title="item.title" route :to="item.route">
		    			  <v-list-tile-action>
		    			    <v-icon class="text-dark">{{item.icon}}</v-icon>
		    			  </v-list-tile-action>
		    			  <v-list-tile-content>
		    			  	<v-list-tile-title class="text-dark">{{item.title}}</v-list-tile-title>
		    			  </v-list-tile-content>
		    			</v-list-tile>

		    			<v-list-group
		    			  prepend-icon="account_circle"
		    			  value="true"
		    			  active-class="text-dark"
		    			  class="text-dark"
		    			>
		    			  <v-list-tile slot="activator">
		    			  	<v-list-tile-content>
		    			    	<v-list-tile-title class="text-dark">Users</v-list-tile-title>
		    			  	</v-list-tile-content>
		    			  </v-list-tile>

				    			<v-list-group
				    				append-icon=""
				    			    no-action
				    			    sub-group
				    			    value="true"
				    			  	active-class="text-dark">
				    			    
					    			  <v-list-tile slot="activator">
					    			    <v-list-tile-title>Admin</v-list-tile-title>
					    			  </v-list-tile>

						        		<v-list-tile class="text-dark waves-effect waves-dark" :title="item.title" v-for="item in items" :key="item.title" route :to="item.route">
							        			<v-list-tile-action>
							        				<v-icon class="text-dark">{{item.icon}}</v-icon>
							        			</v-list-tile-action>

							        			<v-list-tile-content>
							        				<v-list-tile-title class="text-dark">{{item.title}}</v-list-tile-title>
							        			</v-list-tile-content>
						        		</v-list-tile>

				    			</v-list-group>

				    			<v-list-group
				    				lazy
				    			    no-action
				    			    sub-group
				    			    value="true"
				    			  	active-class="text-dark">
				    			    
					    			  <v-list-tile slot="activator">
					    			    <v-list-tile-title>Client</v-list-tile-title>
					    			  </v-list-tile>

						        		<v-list-tile class="text-dark waves-effect waves-dark" title="Pesanan" route to="/pesanan">
							        			<v-list-tile-action>
							        				<v-icon class="text-dark">shopping_cart</v-icon>
							        			</v-list-tile-action>

							        			<v-list-tile-content>
							        				<v-list-tile-title class="text-dark">Pesanan</v-list-tile-title>
							        			</v-list-tile-content>
						        				<v-spacer></v-spacer>
						        				<span right class="badge badge-pill badge-primary" v-if="queue">{{queue}}</span>
						        		</v-list-tile>

						        		<v-list-tile class="text-dark waves-effect waves-dark" title="Data Piutang" route to="/piutang">
							        			<v-list-tile-action>
							        				<v-icon class="text-dark">list</v-icon>
							        			</v-list-tile-action>

							        			<v-list-tile-content>
							        				<v-list-tile-title class="text-dark">Piutang</v-list-tile-title>
							        			</v-list-tile-content>
						        				<v-spacer></v-spacer>
						        				<span right class="badge badge-pill badge-success" v-if="sukses">{{sukses}}</span>
						        		</v-list-tile>

				    			</v-list-group>

				    			<v-list-group
				    				append-icon=""
				    			    no-action
				    			    sub-group
				    			    value="true"
				    			  	active-class="text-dark">
				    			    
					    			  <v-list-tile slot="activator">
					    			    <v-list-tile-title>Advanced</v-list-tile-title>
					    			  </v-list-tile>

						        		<v-list-tile class="text-dark waves-effect waves-dark" title="Export" route to="">
							        			<v-list-tile-action>
							        				<v-icon class="text-dark">link</v-icon>
							        			</v-list-tile-action>

							        			<v-list-tile-content>
							        				<v-list-tile-title class="text-dark">Export</v-list-tile-title>
							        			</v-list-tile-content>
						        		</v-list-tile>

				    			</v-list-group>

		    			</v-list-group>


		        	</v-list>
		        </v-navigation-drawer>
	        	<!-- // Side Navigasi Drawer -->



		        <v-content app>
		        	<v-container fluid>
						<div class="d-flex flex-column col-12 m-auto">
        					<router-view></router-view>
        					<v-snackbar
        					  v-model="snackbar"
        					  :bottom="y === 'bottom'"
        					  :left="x === 'left'"
        					  :multi-line="mode === 'multi-line'"
        					  :right="x === 'right'"
        					  :timeout="timeout"
        					  :top="y === 'top'"
        					  :vertical="mode === 'vertical'"
        					>
        					  Ada Pesanan Baru
        					  <v-btn flat color="primary" @click.native="goToQueue">See & Close</v-btn>
        					</v-snackbar>
        				</div>
		        	</v-container>
		        </v-content>
	        </v-app>
        </div>

	</div>




	<script src="<?php echo base_url('assets/js/vue.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/vuetify.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/vue-router.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/axios.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/mdb.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/sweetalert2.all.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/all.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/_admin.js'); ?>"></script>
</body>
</html>