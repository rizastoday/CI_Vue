<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> <?php echo $title; ?> </title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/mdb.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/all.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/owl.carousel.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/owl.theme.default.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.css'); ?>">
</head>
<body>
	<!-- inisialisasi root Vue -->
    <div id="app" style="min-height: 100vh; height: 100%;" class="bg-white">

    	<!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top animated fadeIn bg-primary">
        	<div class="container w-100 justify-content-between">
    			<a href="<?= base_url()  ?>" class="navbar-brand h2-responsive text-white"><b>Business Center</b></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="text-white" :class="icons"></span>
				</button>

        		<div class="collapse navbar-collapse justify-content-between" id="menu">
        			<div class="d-none d-lg-block"></div>
	        		<div class="form-inline justify-content-center">
	        			<?php if ($this->session->userdata('status') == "admin"): ?>
						<?php $data_session = array('status'=>"admin");
							$this->session->set_userdata($data_session); ?>
							<ul class="navbar-nav">
								<li class="nav-item">
	        						<a title="Anda sudah login, menuju halaman admin" href="<?= base_url('admin') ?>" class="nav-link text-white">Dashboard</a>	
								</li>
							</ul>
	        			<?php elseif ($this->session->userdata('status') == "student"): ?>
	        				<ul class="navbar-nav">
	        					<li class="nav-item dropdown">
			        				<a class="text-white dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="student">
			        					<span class="fa fa-user-circle"></span>
			        				</a>
			        				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="student">
			        					<a class="dropdown-item"><?= $this->session->userdata('nama'); ?></a>
			        					<hr>
			        					<a href="<?= base_url('login/logout');  ?>" title="logout?" class="dropdown-item">Logout</a>
			        				</div>
	        					</li>
	        				</ul>
	        				<ul class="navbar-nav">
	        					<li class="nav-item">
			        				<a title="Buka Keranjang" class="nav-link text-white" data-toggle="modal" data-target="#cartModal" @click="[hasCart = false, loadCart]">
			        					<span class="fa fa-shopping-cart"></span>
			        					<span v-if="hasCart" class="dots"></span>
			        				</a>	
	        					</li>
	        				</ul>
	        			<?php else: ?>
	        			<ul class="navbar-nav">
	        				<li class="nav-item">
		        				<a title="Login" data-toggle="modal" data-target="#loginModal" class="nav-link text-white">
		        					<span class="fa fa-key"></span>
		        				</a>	
	        				</li>
	        			</ul>
	        			<?php endif ?>
	        			<ul class="navbar-nav">
	        				<div class="nav-item dropdown">
		        				<a class="text-white dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="notif">
		        					<span title="Pemberitahuan" class="fa fa-comment-dots"></span>
		        				</a>
		        				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="notif">
				        			<div class="dropdown-item">
				        				<span class="m-2" v-for="(i, index) in notes" v-if="notes.length" :key="index">Pesan : {{i.catatan}} </span>
				        				<span class="m-2" v-if="notes.length < 1">Belum ada pemberitahuan</span>
				        			</div>
				        			<div class="dropdown-divider"></div>
				        			<div class="dropdown-item">
				        				<span class="m-2" v-for="(i, index) in logs" v-if="logs.length" :key="index">Update Terakhir : {{i.tanggal}} </span>
				        				<span class="m-2" v-if="logs.length < 1">Belum ada perubahan</span>
				        			</div>
				        			<div class="dropdown-divider" v-if="token"></div>
				        			<div class="dropdown-item">
				        				<span class="m-2" v-if="token">Token belanja : {{token}}</span>
				        			</div>
		        				</div>
	        				</div>
	        			</ul>
	        		</div>
        		</div>
        	</div>
        </nav>
        <!-- Panel utama -->
        <div class="container-fluid mt-5 animated fadeIn text-white">
        	<h2 class="h2-responsive text-center p-3 bg-white light-blue-text">{{judul}}</h2>
        	<div class="col-12">

        		<!-- Kolom pencarian dan informasi jumlah barang -->
	        	<div class="container d-flex flex-column">

				    <div class="d-flex flex-row w-100">
						<input title="Cari Barang" max="30" maxlength="30" type="text" class="m-auto form-control mb-3 mr-0 m-auto input_search bg-white blue-text" v-model="input" placeholder="Aku mau beli...">
					    <button class="btn bg-transparent m-auto d-flex light-blue-text"  style="font-size: 1.3rem; box-shadow: none; border: none; position: absolute; right: 9.5%;" @click="input = ''" v-if="input.length">
					    	<span class="m-auto close" style="font-size: 1.1rem;">&times;</span>
					    </button>
				    </div>
			      	<transition enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown">
				      	<div class="alert alert-danger alert-dismissible d-flex m-auto fixed-bottom w-75" style="bottom: 1rem; z-index: 1000;" v-if="getToken">
				      		<button type="button" class="close" @click="getToken = false">&times;</button>
					    	<span class="text-sm-left">Harap cek pemberitahuan untuk mendapat token belanja | jangan refresh halaman</span>
				      	</div>
				    </transition>

	        		<div class="justify-content-between d-lg-flex d-md-inline-block m-auto m-lg-0 p-1">
	        			<div  class="d-flex flex-row m-auto animated fadeIn faster" v-if="!input.length">
	        				<span class="m-2 light-blue-text">Menampilkan :</span>
		        			<div class=" d-flex m-auto light-blue-text">
		        				<select class="form-control custom-select m-auto text-white light-blue-text" v-model="perPage" style="height: 2rem">
			        			<?php for ($x=10; $x <= 40; $x+=5) { 
			        			?>
			        				<option selected="0"><?= $x++ ?></option>
			        			<?php
			        			} ?>
			        			</select>
		        			</div>
		        			<span class="m-2 light-blue-text">dari {{barang.length}}</span><br>
	        			</div>
        				<div  class=" m-auto animated fadeIn faster light-blue-text" v-if="input.length">Menemukan : {{totalCari.length}}</div>
	        		</div>

	        	</div> <!-- </Kolom Pencarian -->

	        	<div class="row" v-show="!input.length">
	        		<div class="d-flex justify-content-center flex-column w-100">
	            		<h1 class="h4-responsive d-flex justify-content-center text-center mt-5 light-blue-text"  v-if="highlight.length">Barang Baru</h1>
	                    <div class="row w-50 m-auto p-2 m-0 owl-carousel foto owl-theme owl-lazy"  style="border-radius: 15px">
	                        <div class="item animated fadeIn" @click="detail(item)" v-for="(item, index) in highlight" :key="index">
			        			<img v-if="item.photo" :src="'<?= base_url('upload/') ?>' + item.photo" class="card-img" style="border-radius: 10px; height: 50%;">
			        			<img v-else src="<?= base_url('assets/img/default.jpg') ?>" class="card-img" style="border-radius: 10px; height: 50%;">
			        			<div class="card-img-overlay mask d-flex" :class="[item.stok > 0 ? 'rgba-blue-light' : 'rgba-mdb-color-light text-muted']" style="border-radius: 10px">
			        				<span class="card-title h4-responsive m-auto text-center text-white">{{item.nama_barang}}</span>
			        			</div>
	                        </div>
	                    </div>
	        		</div>
	        	</div>
	        	<hr style="border-width: 3px">

        		<div class="row">
	        		<!-- Card Barang -->

		        	<div  style="border-radius: 10px" class="col-lg-3 col-md-6 col-sm-6 mt-2 animated fadeIn faster" v-for="(item, index) in display" :key="index" data-toggle="modal" data-target="#detailModal">
		        		<div :title="[item.nama_barang] + ', Rp. ' + [item.harga]" class="card cardBarang m-1 justify-content-center z-depth-3 hoverable" :class="[item.stok > 0 ? 'rgba-blue-light' : 'rgba-mdb-color-light text-muted']" @click="detail(item)" style="border-radius: 10px">
		        			<img v-if="item.photo" :src="'<?= base_url('upload/') ?>' + item.photo" class="card-img" style="border-radius: 10px">
		        			<img v-else src="<?= base_url('assets/img/default.jpg') ?>" class="card-img" style="border-radius: 10px">
		        			<div class="card-img-overlay mask d-flex" :class="[item.stok > 0 ? 'rgba-blue-light' : 'rgba-mdb-color-light text-muted']" style="border-radius: 10px">
		        				<span class="card-title h4-responsive m-auto text-center text-white">{{item.nama_barang}}</span>
		        			</div>
		        		</div>
		        	</div>

	        	</div>
	        	<!-- Card Detail -->
		      	<div class="h-100 w-100 d-flex fixed-top animated faster fadeIn" v-if="showDetail" :class="overlay" v-for="(i, index) in detailBarang" :key="index">
						<div class="card justify-content-center m-auto w-50 h-50 animated zoomIn faster">
							<div class="card-header d-flex bg-primary">
								<h4 class="text-center text-white">{{i.nama_barang}}</h4>
								<button type="button" class="position-absolute close" style="right: 10px; top: auto;" @click="[detailBarang = [], qty = '', overlay = '', showDetail = false]">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="card-body" >
								<div class="row">
									<div class="col-lg-6 col-md-0 d-none d-lg-block d-flex flex-row w-100 justify-content-center">
										<img v-if="i.photo" :src="'<?= base_url('upload/') ?>' + i.photo" class="card-img w-75 m-auto d-none d-lg-block">
										<img v-else src="<?= base_url('assets/img/default.jpg') ?>" class="card-img w-75 m-auto d-none d-lg-block">
									</div>
									<div class="col-lg-6 col-md-12 text-dark d-flex">
										<table class="m-auto">
											<tr>
												<td><h6>Kode</h6></td>
												<td><h6>:</h6></td>
												<td><h6 v-text="i.kode"></h6></td>
											</tr>
											<tr>
												<td><h6>Harga</h6></td>
												<td><h6>:</h6></td>
												<td><h6>Rp.<span v-text="i.harga"></span></h6></td>
											</tr>
											<tr>
												<td><h6>Stok</h6></td>
												<td><h6>:</h6></td>
												<td><h6 v-text="i.stok"></h6></td>
											</tr>
										</table>
									</div>
								</div>
								<?php if ($this->session->userdata('status') == 'student'): ?>
									<div class="row" v-if="i.stok > 0">
										<div class="col-12 justify-content-between d-flex flex-row p-2">
											<input type="number" name="cart_qty" class="m-auto form-control form-control-sm float-left" style="width: 5rem" min="1" placeholder="Qty" type="button" v-if="i.stok > 0" ref="qty" v-model="qty">
											<button @click="[addToCart(i), qty = '', showDetail = false, addCart = true]" title="Tambah Ke Keranjang" type="button" class="m-auto btn waves-effect float-right bg-primary"><span class="fa fa-cart-plus text-white"></span></button>
										</div>
									</div>
									<div class="row" v-else>
										<div class="col-12 justify-content-center d-flex">
											<h6 class="text-danger m-auto p-3">Mohon maaf stok saat ini kosong</h6>
										</div>
									</div>
								<?php else: ?>
									<div class="col-12 d-flex p-3">
										<span class="m-auto text-muted text-small-center"><a data-toggle="modal" data-target="#loginModal" class="blue-text" @click="showDetail = false">Login</a>  untuk berbelanja</span>
									</div>
								<?php endif ?>
							</div>
						</div>
		      	</div>
		      	<transition enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown">
			      	<div class="alert alert-success alert-dismissible d-flex m-auto fixed-bottom w-75" style="bottom: 1rem; z-index: 1000;" v-if="addCart">
			      		<button type="button" class="close" @click="addCart = false">&times;</button>
			      		<span><strong>Berhasil!</strong> Ayo Cek Keranjang</span>
			      	</div>
		      	</transition>

		      	<!-- End Of Card Detail -->

        	</div>
        </div>

        <!-- Pagination -->
      	<div class="container w-100 d-flex mb-3 mt-3" v-if="!input.length" style="z-index: -10 !important" v-if="showDetail = false">
      		<div class="m-auto" :class="isEmpty">
	        	<button type="button" class="btn btn-sm hoverable waves-effect waves-light blue text-white" v-for="pageNumber in pages.slice(page-1, page+5)" @click="page = pageNumber"> {{pageNumber}} </button>
	        	<div class="d-flex w-100 justify-content-between">
		            <button type="button" class="btn btn-sm hoverable waves-effect waves-light blue text-white" v-if="page != 1" @click="page--"> Prev </button>
		        	<button type="button" class="btn btn-sm hoverable waves-effect waves-light blue text-white" v-if="page < pages.length" @click="page++" > Next </button>
	        	</div>
      		</div>
      	</div>
      	<!-- End of Pagination -->


      	<?php $this->load->view('_components/_modal_main'); ?>

      	<!-- Shopping Cart Modal -->

		<div class="modal animated fadeInDown faster" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="modalCart" ref="cartModal" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header bg-primary">
				    <h5 class="modal-title text-center text-white" id="modalCart">Keranjang Belanja</h5>
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="[nextBill = true, textBill = 'Lanjut', id_user = '', error = []]">
				      <span aria-hidden="true" class="text-white">&times;</span>
				    </button>
				  </div>
				  <div class="modal-body" style="min-height: 13.5rem; transition: .5s all ease-in-out;">
				  	<transition leave-active-class="animated zoomOut">
					  	<div v-show="nextBill">
						  	<table class="table table-sm table-hover table-striped table-light table-success">
						  		<thead class="thead-default">
						  			<tr>
						  				<th scope="col">#</th>
						  				<th scope="col">Kode</th>
						  				<th scope="col">Barang</th>
						  				<th scope="col">Sub. Harga</th>
						  				<th scope="col">QTY</th>
						  				<th scope="col">Total Harga</th>
						  				<th scope="col">Action</th>
						  			</tr>
						  		</thead>
						  		<tbody id="cart_data"><!-- data loaded from ajax --></tbody>
						  	</table>
							<div class="col-lg-4 offset-lg-8 col-md-12 d-flex">
								<button @click="addBill" type="button" class="m-auto btn btn-primary waves-effect waves-light float-right">Pesan</button>	
					  		</div>
					  	</div>
				  	</transition>
				  	<transition enter-active-class="animated zoomIn" leave-active-class="animated fadeOut">
					  	<div class="col-12 d-flex flex-column position-absolute m-auto w-100" style="top: 20px;" v-if="!nextBill">
					  		<h4 class="h4-responsive m-auto">Masukan Kode Siswa</h4>
					  		<form class="m-auto p-3 col-12 d-flex flex-column" @submit.prevent="processBill" autocomplete="off">
					  			<input type="text" name="id_user" v-model="id_user" ref="id_user" class="form-control m-auto col-4 m-3">
					  			<small class="m-auto text-danger" v-html="error.id_user"></small>
						  		<div class="col-lg-4 offset-lg-8 col-md-12 d-flex p-3">
									<button type="submit" class="m-auto btn btn-primary waves-effect waves-light d-flex flex-row mt-5">
										<span v-html="textBill"></span>
									</button>
						  		</div>
					  		</form>
					  	</div>
					</transition>
				  </div>
				</div>
			</div>
		</div>

      	<!-- footer dan copyright -->
      	<copyright :class="isEmpty"></copyright>

    </div>


    <script src="<?= base_url('assets/js/vue.js'); ?>"></script>
    <script src="<?= base_url('assets/js/axios.js'); ?>"></script>
    <script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
    <script src="<?= base_url('assets/js/mdb.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('assets/js/all.js'); ?>"></script>
    <script src="<?= base_url('assets/js/owl.carousel.js'); ?>"></script>
    <script src="<?= base_url('assets/js/_main.js')  ?>" ></script>
    <script src="<?php echo base_url('assets/js/sweetalert2.all.js'); ?>"></script>
</body>
</html>