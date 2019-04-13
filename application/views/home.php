<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Demo </title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/vuetify.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/mdb.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/iconfont/material-icons.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/all.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/sweetalert2.css'); ?>">
    <style type="text/css">

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
	        			<v-toolbar-title class="position-fixed h2-responsive text-white">
	        				<span>Business-Center</span>
	        			</v-toolbar-title>
		        		<v-spacer></v-spacer>

		        		
		        		<v-btn flat round color="white" title="Logout dari admin?" @click="logout">
		        			<span>Sign Out</span>
		        			<v-icon right>exit_to_app</v-icon>
		        		</v-btn>
	        		</v-toolbar>
	        	</nav>
	        	<!-- Side Navigasi Drawer -->

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
    <script src="<?php echo base_url('assets/js/_home.js'); ?>"></script>
</body>
</html>