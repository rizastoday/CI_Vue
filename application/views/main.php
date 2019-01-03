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
    <style type="text/css">
    	.text-close {
    		font-size: 1.2rem;
    		transition: all .4s;
    		margin: 5px;
    		cursor: pointer;
    		color: white;
    	}
    	.text-close:hover {
    		transform: scale(1.3);
    		color: red;
    	}
    	.cardBarang {
    		cursor: zoom-in;
    	}
    </style>
</head>
<body>
	<!-- inisialisasi root Vue -->
    <div id="app" style="min-height: 100vh; height: 100%;" :class="warnaBackground">

    	<!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top" :class="warnaNavbar">
        	<div class="container w-100 d-flex flex-row">
        		<div class="d-flex flex-row">
        			<a href="<?= base_url()  ?>" class="navbar-brand h2-responsive" :class="warnaText">Monitoring Business Center</a>
        		</div>
        		<div class="form-inline float-right">
        			<?php if ($this->session->userdata('status') == "login"): ?>
        				<a title="Anda sudah login, menuju halaman admin" href="<?= base_url('admin') ?>" class="hoverable nav-link d-none d-xl-block d-lg-block" :class="warnaText">Dashboard</a>
        			<?php else: ?>
        				<a title="Login sebagai Admin" data-toggle="modal" data-target="#loginModal" class="hoverable nav-link d-none d-xl-block d-lg-block" :class="warnaText">Login</a>
        			<?php endif ?>
        			<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a title="Ganti Tema" class="nav-link dropdown-toggle" :class="warnaText" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  {{textView}}
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							  <a class="dropdown-item" v-for="(color, index) in colorThemes" :key="color.id" :class="color.dropdownText" @click="themes(color)" >{{color.textView}}</a>
							</div>
						</li>
        			</ul>
        		</div>
        	</div>
        </nav>
        <!-- Panel utama -->
        <div class="container-fluid mt-5" :class="warnaText">
        	<h3 class="h3-responsive text-center" :class="warnaDokumen">{{judul}}</h3>
        	<div class="row">

        		<!-- Kolom pencarian dan informasi jumlah barang -->
	        	<div class="container d-flex flex-column p-3">

	        		<div class="justify-content-between d-lg-flex d-md-inline-block m-auto m-lg-0">
	        			<div :class="warnaDokumen">
	        				<span class="m-2" v-for="(i, index) in notes" :key="index">Pesan : {{i.catatan}} </span>
	        			</div>
	        			<div :class="warnaDokumen">
	        				<span class="m-2" v-for="(i, index) in logs" :key="index">Update Terakhir : {{i.tanggal}} </span>
	        			</div>
	        		</div>

				    <div class="d-flex flex-row w-100">
						<input title="Cari Barang" type="text" class="m-auto form-control mb-3 mr-0 alert-info m-auto" v-model="input" style="height: 3rem; border-radius: 25px" :class="warnaCari" placeholder="Cari barang...">
					    <button class="btn bg-transparent m-auto d-flex" :class="warnaDokumen" style="font-size: 1.2rem; box-shadow: none; border: none; position: absolute; right: 10%;" @click="input = ''" v-if="input.length">
					    	<span class="m-auto" style="font-size: 1.1rem;">&times;</span>
					    </button>
				    </div>

	        		<div class="justify-content-between d-lg-flex d-md-inline-block m-auto m-lg-0">
	        			<div :class="warnaDokumen" class="d-flex flex-row">
	        				<span class="m-2">Menampilkan :</span>
		        			<div class="m-2 d-flex m-auto">
		        				<select class="form-control custom-select m-auto" :class="[warnaNavbar, warnaText]" v-model="perPage" style="height: 2rem">
			        			<?php for ($x=10; $x <= 40; $x+=5) { 
			        			?>
			        				<option selected="0"><?= $x++ ?></option>
			        			<?php
			        			} ?>
			        			</select>
		        			</div>
		        			<span class="m-2">dari {{barang.length}}</span><br>
	        			</div>
	        			<div :class="warnaDokumen" class="m-2" v-if="input.length">Ditemukan: {{totalCari.length}}</div>
	        		</div>

	        	</div> <!-- </Kolom Pencarian -->
        		
        		<!-- Card Barang -->
	        	<div  class="col-lg-3 col-md-6 col-sm-12" v-for="(item, index) in display" :key="index" data-toggle="modal" data-target="#detailModal">
	        		<div :title="[item.nama_barang] + ', Rp. ' + [item.harga]" class="card cardBarang m-2 justify-content-center z-depth-3 hoverable" :class="[item.stok > 0 ? warnaCardAda : warnaCardHabis]" @click="detail(item)">
	        			<img src="<?= base_url('assets/img/1.jpg') ?>" class="card-img">
	        			<div class="card-img-overlay mask d-flex" :class="[item.stok > 0 ? warnaCardAda : warnaCardHabis]">
	        				<h3 class="card-title h3-responsive m-auto text-center" :class="warnaText">{{item.nama_barang}}</h3>
<!-- 	        				<div class="d-flex flex-row col-12 position-absolute" style="bottom: 1.5rem">
	        					<p class="text-center col-6">Rp. {{item.harga}}</p>
	        					<p class="text-center col-6" v-text="item.stok > 0 ? 'stok: ' + item.stok : 'stok habis'"></p>
	        				</div> -->
	        			</div>
	        		</div>
	        	</div>

	        	<!-- Card Detail -->
		      	<div class="h-100 w-100 d-flex fixed-top animated faster fadeIn" v-if="showDetail" :class="overlay" v-for="(i, index) in detailBarang" :key="index">
		      		<div class="card justify-content-center m-auto w-50 animated zoomIn faster">
			      		<div class="card-header" :class="[i.stok > 0 ? warnaCardAda : warnaCardHabis]">
			      			<h4 class="text-center" :class="warnaText">{{i.nama_barang}}</h4>
			      			<div class="position-absolute text-close" style="right: 10px; top: 10px;" @click="close">x</div>
			      		</div>
			      		<div class="card-body" style="height: 10rem">
			      			<div class="row">
			      				<div class="col-lg-6 col-md-0 d-none d-lg-block">
			      					<div class="bg-dark w-100 h-100 text-white">Gambar</div>
			      				</div>
			      				<div class="col-lg-6 col-md-12 text-dark">
			      					<table>
			      						<tr>
			      							<td>Kode</td>
			      							<td>:</td>
			      							<td>{{i.kode}}</td>
			      						</tr>
			      						<tr>
			      							<td>Harga</td>
			      							<td>:</td>
			      							<td>Rp.{{i.harga}}</td>
			      						</tr>
			      						<tr>
			      							<td>Stok</td>
			      							<td>:</td>
			      							<td>{{i.stok}}</td>
			      						</tr>
			      					</table>
			      				</div>
			      			</div>
			      		</div>
		      		</div>
		      	</div>

		      	<!-- End Of Card Detail -->

        	</div>
        </div>

        <!-- Pagination -->
      	<div class="container w-100 d-flex mb-3 mt-3">
      		<div class="m-auto" :class="isEmpty">
	        	<button type="button" class="btn btn-sm hoverable waves-effect waves-light" :class="[warnaNavbar, warnaText]" v-for="pageNumber in pages.slice(page-1, page+5)" @click="page = pageNumber"> {{pageNumber}} </button>
	        	<div class="d-flex w-100 justify-content-between">
		            <button type="button" class="btn btn-sm hoverable waves-effect waves-light" :class="[warnaNavbar, warnaText]" v-if="page != 1" @click="page--"> Prev </button>
		        	<button type="button" class="btn btn-sm hoverable waves-effect waves-light" :class="[warnaNavbar, warnaText]" v-if="page < pages.length" @click="page++" > Next </button>
	        	</div>
      		</div>
      	</div>
      	<!-- End of Pagination -->


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


      	<!-- footer dan copyright -->
      	<copyright :class="isEmpty"></copyright>

    </div>


    <script src="<?php echo base_url('assets/js/vue.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/axios.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/all.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/themes.js'); ?>"></script>
    <script type="module">
    	import {footer} from "./assets/js/footer.js"
    	import {themes} from "./assets/js/themes.js"

    	const path_uri = "<?= base_url() ?>"

        new Vue({
            el:'#app',
            components: {
            	'copyright' : footer
            },
			data(){
				return{
					warnaNavbar: '', //warna navbar
					warnaCari:'', //warna input teks
					warnaText:'', //warna teks di navbar
					textView:'', //teks dinamis pada pemilihan tema
					warnaCardAda:'', //warna card barang jika barang ada
					warnaCardHabis:'', //warna card barang jika barang habis
					warnaDokumen:'', //warna teks paragraf
					warnaBackground: '', // aturan untuk background di halaman ini
					colorThemes: themes, //library warna tema
					applyThemes:[], //menampung tema yang dipilih dan memasukan datanya sebagai array baru
					barang: [], //data barang dari database
					notes:[],
					logs: [],
					firstLog: [],
					input: '', //kolom pencarian, berguna untuk elastic search
					totalCari:'', //DOM untuk menampilkan jumlah hasil pencarian
					judul:'Data Barang',
					page: 1, //posisi awal halaman pagination
					perPage: 10, //data perhalaman, default
					pages:[], //observeb untuk menampung data barang untuk pagination
					showDetail: false, //card detail saat di klik
					overlay: '', //warna container card detail
					detailBarang: [], //menampung data barang saat per item di klik
					isEmpty:''

				}
			},
			created(){ //funsi create, fungsi yang akan dijalankan saat aplikasi vue di load
				this.warnaDefault //warna default terpilih, computed
				this.getPosts() //function untuk mendapat data dari database
			},
			methods: {
				themes(e){ //on click themes, menampung tema terpilih di parameter e sebagai array
					this.applyThemes = e //menampung array e ke variabel applyThemes dan dijadikan sebagai variabel baru
					this.warnaNavbar = e.warnaNavbar //mengatur....
					this.warnaText = e.warnaText
					this.warnaCari = e.warnaCari
					this.warnaBackground = e.warnaBackground
					this.warnaDokumen = e.warnaDokumen
					this.warnaCardAda = e.warnaCardAda
					this.warnaCardHabis = e.warnaCardHabis
					this.textView = e.textView
				},
				getPosts(){
					axios.get(path_uri + 'main/business_center_main_rest') // load API
					.then((response)=>{
						this.barang = response.data //data response hasil observeb di tampung di variabel barang
					});

					axios.get(path_uri + 'main/business_center_main_notes_rest')
					.then(response=>{
						this.notes = response.data
					});

					axios.get(path_uri + 'main/business_center_main_first_log_rest')
					.then(response=>{
						this.logs = response.data
					});
				},
				setPages(){
					let numberOfPage = Math.ceil(this.barang.length / this.perPage)
					for(let index = 1; index <= numberOfPage; index++){
						this.pages.push(index)
					}
				},
				paginate(posts){
					let page = this.page
					let perPage = this.perPage
					let from = (page * perPage) - perPage
					let to = (page * perPage)
					return posts.slice(from, to)
				},
				detail(e){ //permainan show hide untuk modal.....
					this.showDetail = true
					this.detailBarang.push(e)
					this.overlay = 'rgba-mdb-color-strong'
				},
				close(){
					this.detailBarang = []
					this.showDetail = false
					this.overlay = ''
				}
			},
			computed:{
				display(){ //elastic search!!!!!!!!!!
					return this.paginate(this.barang.filter((e)=>{
						return e.nama_barang.toLowerCase().match(this.input.toLowerCase())
					}))
				},
				warnaDefault(){ //perubahan tema secara otomatis selain pemilihan di dropdown
					return this.colorThemes.filter((color)=>{
						let time = new Date().getHours()

						if (time < 17) {
							color = this.colorThemes[0] //tema terang jika kurang dari pukul 5 sore
								this.applyThemes = color
								this.warnaNavbar = color.warnaNavbar
								this.warnaText = color.warnaText
								this.warnaBackground = color.warnaBackground
								this.warnaDokumen = color.warnaDokumen
								this.warnaCardAda = color.warnaCardAda
								this.warnaCardHabis = color.warnaCardHabis
								this.warnaCari = color.warnaCari
								this.textView = color.textView
						}else {
							color = this.colorThemes[1] //tema akan berganti gelap saat pukul 5 sore
								this.applyThemes = color
								this.warnaNavbar = color.warnaNavbar
								this.warnaText = color.warnaText
								this.warnaBackground = color.warnaBackground
								this.warnaDokumen = color.warnaDokumen
								this.warnaCardAda = color.warnaCardAda
								this.warnaCardHabis = color.warnaCardHabis
								this.warnaCari = color.warnaCari
								this.textView = color.textView
						}
					})
				},
			},
			watch: {
				barang(){
					this.setPages() //set halaman
				},
				input(){ //DOM untuk menampilkan nama barang saat mulai mengetik di kolom pencarian
					if(this.input == ''){ //saat posisi pencarian kosong, tampilkan judul default yaitu Data Barang
						this.judul = 'Data Barang' //kenapa re-assign ? karena judul di variabel default sudah di override oleh watch / dihapus
						this.isEmpty = 'd-block'
					} else {
						this.judul = this.input.toUpperCase() //override judul dengan apa yang diketikkan
					}
					this.totalCari = this.barang.filter((i)=>{ //membaca jumlah barang yang cocok saat melakukan pencarian
						return i.nama_barang.toLowerCase().match(this.input.toLowerCase())
					})
				},
				totalCari(){
					if(this.totalCari.length <= 4){
						this.isEmpty = 'd-none'
					}else {
						this.isEmpty = 'd-block'
					}
				}
			}
        });
    </script>
</body>
</html>