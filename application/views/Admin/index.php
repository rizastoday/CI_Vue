<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Admin </title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/mdb.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/datatables.min.css'); ?>">
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
	<div id="app" style="height: 100vh">

        <div class="row w-100 d-flex align-items-stretch">
 
			<div class="alert-info sidebar p-2 d-flex flex-column position-fixed fixed-top">
				<p class="ml-auto mr-auto h1-responsive text-center">Admin BC</p><hr>
		        <ul class="nav nav-pills d-flex flex-column" id="myTab" role="tablist">
		        	<li class="nav-item"> 
		        		<a class="d-flex flex-row w-100 justify-content-between nav-link active" href="#tableTab" id="table" aria-control="tableTab" data-toggle="tab" role="tab" aria-selected="true">
		        			Tabel
		        			<span class="mt-auto mb-auto fa fa-table"></span>
		        		</a>
		        	</li>
		        	<li class="nav-item"> 
		        		<a class="d-flex flex-row w-100 justify-content-between nav-link" href="#logTab" id="log" aria-control="logTab" data-toggle="tab" role="tab" aria-selected="false">
		        			Log
		        			<span class="mt-auto mb-auto fas fa-history"></span>
		        		</a>
		        	</li>
		        	<li class="nav-item"> 
		        		<a class="d-flex flex-row w-100 justify-content-between nav-link" href="#messageTab" id="message" aria-control="messageTab" data-toggle="tab" role="tab" aria-selected="false" >
		        			Pesan
		        			<span class="mt-auto mb-auto fa fa-sticky-note"></span>
		        		</a>
		        	</li>
		        </ul>
		        <div class="position-absolute justify-content-between d-flex flex-row p-2 m-auto" style="bottom: 1.3rem; width: 90%;">
	        		<a class="waves-effect waves-light" title="Logout" href="<?= base_url('login/logout') ?>" style="box-shadow: none; border: none;">
	        			<span class="fa fa-arrow-alt-circle-left fa-2x blue-text"></span>
	        		</a>
	        		<a class="waves-effect waves-light" title="Tambah Barang" style="box-shadow: none; border: none;" data-toggle="modal" data-target="#modalInsert">
			  			<span class="fas fa-plus-circle fa-2x blue-text"></span>
			  		</a>
		        </div>

			</div>
			<div class="content position-absolute" style="right: 0;">
				<div class="tab-content container-fluid">

				  <div class="tab-pane active p-3" id="tableTab" role="tabpanel" aria-labelledby="table">
					  	<!-- Tab Table -->

					  	<div class="row d-flex flex-row justify-content-center p-2 bg-white sticky-top">
					  		<h1 class="h1-responsive m-auto text-black">Tabel Barang</h1>
					  	</div>

					  	<table class="table table-hover table-bordered table-striped table-sm" id="tabel">
					  		<thead class="alert-info">
				  				<th scope="row">#</th>
				  				<th scope="row">ID</th>
				  				<th scope="row">Nama Barang</th>
				  				<th scope="row">Harga</th>
				  				<th scope="row">Stok</th>
					  		</thead>
					  		<tbody>
					  			<tr v-for="(i, index) in allData" :key="index" style="cursor: pointer" @click="detail(i)" data-toggle="modal" data-target="#modalDetail" title="Klik untuk detail">
					  				<td>{{index+1}}</td>
					  				<td>{{i.kode}}</td>
					  				<td>{{i.nama_barang}}</td>
					  				<td>Rp. {{i.harga}}</td>
					  				<td>{{i.stok}}</td>
					  			</tr>
					  		</tbody>
					  	</table>

				  </div>
				  <div class="tab-pane p-3" id="logTab" role="tabpanel" aria-labelledby="log">
					  	<!-- Log Tab -->

					  	<div class="row d-flex flex-row justify-content-center p-2 bg-white sticky-top">
					  		<h1 class="h1-responsive m-auto text-black">Log Aktivitas</h1>
					  	</div>

					  	<table class="table table-hover table-bordered table-striped table-sm" id="tabelLog">
					  		<thead class="alert-info">
				  				<th scope="row">#</th>
				  				<th scope="row">Aktivitas</th>
				  				<th scope="row">Waktu</th>
					  		</thead>
					  		<tbody>
					  			<tr v-for="(i, index) in logs" :key="index">
					  				<td>{{index+1}}</td>
					  				<td>{{i.kejadian}}</td>
					  				<td>{{i.tanggal}}</td>
					  			</tr>
					  		</tbody>
					  	</table>

				  </div>
				  <div class="tab-pane" id="messageTab" role="tabpanel" aria-labelledby="message">
				  	<div class="d-flex justify-content-center w-100" style="height: 100vh">
				  		<div class="m-auto d-flex position-absolute" style="top: 3rem">
					  		<h1 class="h1-responsive m-auto text-center text-black">Pesan Untuk Siswa</h1>
				  		</div>
				  		<div class="m-auto w-100 ">
				  			<form method="post" @submit.prevent="sendMessage" class="d-flex flex-column">
					    		<small class="m-auto text-danger" v-html="isValidate.message"></small>
					  			<input type="text" ref="message" name="message" v-model="note.message" class="message m-auto form-control hoverable alert-info" placeholder="Masukan pesan, lalu tekan enter">
				    		</form>
				  		</div>
				  	</div>
				  </div>
				</div>
			</div>
        </div>

		<!-- Modal Detail, Edit, dan Hapus  -->
      	<div class="modal fade" id="modalDetail" ref="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetail" aria-hidden="true" data-backdrop="static">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header bg-primary">
		        <h5 class="modal-title text-center text-white" id="modalDetail">{{isSelected.nama_barang}}</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="[isEditable = true, isDisabled = 'disabled blue-grey lighten-4', isValidate = [] ]">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="col-12">
					<form>
					  <div class="form-group">
					    <label for="kode">Kode Barang</label>
					    <input type="text" class="form-control" id="kode" name="kode" v-model="isSelected.kode" @focus="Simpan = 'Simpan'" :class="[isDisabled, {'is-invalid' : isValidate.kode}]">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.kode"></small>
					  </div>
					  <div class="form-group">
					    <label for="nama">Nama Barang</label>
					    <input type="text" class="form-control" id="nama" name="nama_barang" v-model="isSelected.nama_barang" @focus="Simpan = 'Simpan'" :class="[isDisabled, {'is-invalid' : isValidate.nama}]">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.nama_barang"></small>
					  </div>
					  <div class="form-group">
					    <label for="harga">Harga</label>
					    <input type="text" class="form-control" id="harga" name="harga" v-model="isSelected.harga" @focus="Simpan = 'Simpan'" :class="[isDisabled, {'is-invalid' : isValidate.harga}]">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.harga"></small>
					  </div>
					  <div class="form-group">
					    <label for="stok">Persediaan</label>
					    <input type="text" class="form-control" id="stok" name="stok" v-model="isSelected.stok" @focus="Simpan = 'Simpan'" :class="[isDisabled, {'is-invalid' : isValidate.stok}]">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.stok"></small>
					  </div>
				      <div class="modal-footer">
						  <div class="w-100 d-flex" v-if="isEditable">
						  	<button type="button" class="btn waves-effect waves-light m-auto bg-secondary" @click="editThis">Edit</button>	
						  	<button type="button" class="btn waves-effect waves-light m-auto bg-danger" @click="deleteThis(isSelected)">Hapus</button>	
						  </div>
						  <div class="w-100 d-flex animated fadeIn" v-if="!isEditable">
						  	<button type="button" class="btn waves-effect waves-light m-auto bg-secondary" @click="updateThis(isSelected)" v-html="Simpan"></button>	
						  	<button type="button" class="btn waves-effect waves-light m-auto bg-danger" data-dismiss="modal" @click="[isEditable = true, isDisabled = 'disabled blue-grey lighten-4', isValidate = [] ]">Batal</button>	
						  </div>
				      </div>
					</form>
		      	</div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal Tambah -->
      	<div class="modal fade" id="modalInsert" ref="modalInsert" tabindex="-1" data-show="true" role="dialog" aria-labelledby="modalInsert" aria-hidden="true" data-backdrop="static">
		  <div class="modal-dialog" role="document" ref="modalInsert">
		    <div class="modal-content">
		      <div class="modal-header bg-primary">
		        <h5 class="modal-title text-center text-white" id="modalInsert">Tambah Baru</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="clear">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      	<div class="col-12">
					<form autocomplete="off" ref="formAdd" enctype="multipart/form-data" method="post">
					  <div class="form-group">
					    <label for="kode">Kode</label>
					    <input type="text" class="form-control" id="kode" name="kode" ref="kode" v-model="modelData.kode" @focus="Simpan = 'Simpan'" :class="{'is-invalid' : isValidate.kode}">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.kode"></small>
					  </div>
					  <div class="form-group">
					    <label for="nama">Nama</label>
					    <input type="text" class="form-control" id="nama" name="nama_barang" ref="nama" v-model="modelData.nama_barang" @focus="Simpan = 'Simpan'" :class="{'is-invalid' : isValidate.nama}">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.nama_barang"></small>
					  </div>
					  <div class="form-group">
					    <label for="harga">Harga</label>
					    <input type="number" class="form-control" id="harga" name="harga" ref="harga" v-model="modelData.harga" placeholder="Hanya Angka" @focus="Simpan = 'Simpan'" :class="{'is-invalid' : isValidate.harga}">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.harga"></small>
					  </div>
					  <div class="form-group">
					    <label for="stok">Stok</label>
					    <input type="number" class="form-control" id="stok" name="stok" ref="stok" v-model="modelData.stok" @focus="Simpan = 'Simpan'" :class="{'is-invalid' : isValidate.stok}">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.stok"></small>
					  </div>
					  <div class="form-grup">
					    <label for="foto">Foto</label>
					    <input type="file" class="form-control-file" id="foto" name="foto" ref="foto">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.error_upload"></small>
					  </div>
				      <div class="modal-footer">
						  <div class="w-100 d-flex">
						  	<button class="btn waves-effect waves-light m-auto bg-secondary" @click.prevent="save" v-html="Simpan"></button>	
						  	<button class="btn waves-effect waves-light m-auto bg-danger" data-dismiss="modal" @click="[isEditable = true, isDisabled = 'disabled blue-grey lighten-4', Simpan = 'Simpan', clear]">Batal</button>	
						  </div>
				      </div>
					</form>
		      	</div>
		      </div>
		    </div>
		  </div>
		</div>

	</div>




	<script src="<?php echo base_url('assets/js/vue.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/axios.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datatables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/mdb.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/sweetalert2.all.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/all.js'); ?>"></script>
    <script type="text/javascript">


    	$(document).ready(function() {
    		$('#tabel').DataTable();
    		$('#tabelLog').DataTable();
    	});

    	const api_uri = '<?= base_url() ?>'


    	const app = new Vue ({
    		el:'#app',
    		data(){
    			return {
    				allData: [],
    				logs:[],
    				note: { 
    					message: '' 
    				},
    				isSelected: {},
    				isEditable: true,
    				isDisabled: 'disabled blue-grey lighten-4',
    				Simpan: 'Simpan',
    				modelData: {
    					kode: '',
    					nama_barang: '',
    					harga: '',
    					stok: '',
    					form_photo: 'default.jpg'
    				},
    				Status: '',
    				isValidate: []
    			}
    		},
    		mounted(){

    		},
    		created(){
    			this.getData
    		},
    		methods: {
    			detail(e){this.isSelected = e},
    			editThis(){
    				this.isDisabled = ''
    				this.isEditable = false
    			},
    			save(){
    				this.Simpan = '<i class="fa fa-spinner fa-spin text-white"></i>'
    				let data = this.toFormData(this.modelData)
    				axios.post(api_uri+'admin/business_center_save_models', data)
    				.then(response=>{
						if(response.data.error){
	    					this.Simpan = 'Simpan'
							this.isValidate = response.data.msg
						}else{
	    					this.Simpan = 'Tersimpan'
    						$('#modalInsert').modal('hide')
							Swal({
								title: 'Sukses',
								text: 'Data tersimpan ke database, halaman akan direload',
								type: 'success'
							}).then(result=>{
								if(result.value){
	    							$(this.$refs.modalInsert).on("hidden.bs.modal", window.location.assign(api_uri + 'admin'))
								}
							})
						}
    				})
    			},
    			deleteThis(e){
    				Swal({
    					title: "Yakin ingin menghapus data ?\n" + e.nama_barang,
    					type: 'warning',
    					showCancelButton: true,
    					cancelButtonText: 'Jangan',
    					confirmButtonText: 'Hapus',
    				}).then(result=>{
    					if(result.value){
	    					axios.post(api_uri+'admin/business_center_delete_models/'+e.kode)
	    					.then(response=>{
		    						Swal({
		    							title: 'Berhasil',
		    							text: e.nama_barang + ' telah dihapus, silakan reload halaman',
		    							type: 'success'
		    						}).then(result=>{
		    							if(result.value){
			    							$('#modalDetail').modal('hide')
			    							$(this.$refs.modalDetail).on("hidden.bs.modal", window.location.assign(api_uri + 'admin'))
		    							}
		    						})
	    					})
    					}
    				})
    			},
    			updateThis(e){
    				this.Simpan = '<i class="fa fa-spinner fa-spin text-white"></i>'
    				let data = this.toFormData(e)
    				axios.post(api_uri+'admin/business_center_update_models', data)
    				.then(response=>{
    					if(response.data.error){
    						this.Simpan = 'Simpan'
    						this.isValidate = response.data.msg
    					}else{
	    					this.Simpan = 'Tersimpan'
	    					$('#modalDetail').modal('hide')
							Swal({
								title: 'Sukses',
								text: 'Data berhasil di update, halaman akan direload',
								type: 'success'
							}).then(result=>{
								if(result.value){
	    							$(this.$refs.modalDetail).on("hidden.bs.modal", window.location.assign(api_uri + 'admin'))
								}
							})
						}
    				})
    			},
    			sendMessage(){
    				let data = this.toFormData(this.note)
    				axios.post(api_uri+'admin/business_center_save_notes_models', data)
    				.then(response=>{
    					if(response.data.error){
    						this.isValidate = response.data.msg
    					}else{
    						Swal({
    							title: 'Sukses!',
    							text: 'Catatan anda telah di sampaikan ke siswa',
    							type: 'success'
    						})
    						this.note.message = ''
    						this.isValidate = []
    					}
    				})
    			},
		        toFormData(obj){
		            const form_data = new FormData();
		            for(var key in obj){
		                form_data.append(key, obj[key])
		            }
		            return form_data
		        },
		        clear(){
					this.isValidate = []
					this.modelData.kode = ''
					this.modelData.nama_barang = ''
					this.modelData.harga = ''
					this.modelData.stok = ''
					this.Simpan = 'Simpan'
					$('#modalDetail').modal('hide')
					$('#modalInsert').modal('hide')
		        }
    		},
    		computed:{
    			getData(){
    				axios.get(api_uri+'main/business_center_main_rest').then(response=>{this.allData = response.data});
    				axios.get(api_uri+'main/business_center_main_log_rest').then(res=>this.logs = res.data)
    			}
    		},
    		watch: {
    		}
    	})
    </script>
</body>
</html>