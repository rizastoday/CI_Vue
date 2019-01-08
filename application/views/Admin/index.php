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

     	<?php $this->load->view('_components/_modal_admin'); ?>

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
    <script src="<?php echo base_url('assets/js/_admin.js'); ?>"></script>
</body>
</html>