let footer = {
	template: `
      	<footer class="w-100 bg-dark p-3 sticky-bottom" style="bottom: 0">
      		<p class="text-center yellow-text" v-html="footer"></p>
      	</footer>
	`,
	data(){
		return{
			footer:'<i class="fa fa-code yellow-text"></i> with <i class="fa fa-heart pink-text"></i> by <a class="yellow-text" href="#" title="">Superman</a> | Copyright &copy; 2018 - now'
		}
	}
}


const path_uri = "http://localhost/PHP_PROJECT/CodeIgniter/codeigniter/" //Set base path based on config.php


const app = new Vue({
    el:'#app',
    components: {
    	'copyright' : footer
    },
	data(){
		return{
			addCart : false,
			getToken: false,
			hasCart : false,
			icons: 'fa fa-chevron-down',
			barang: [], //data barang dari database
			notes:[],
			hasNote: null,
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
			isEmpty:'',
			formLogin : {
				username: '',
				password: '',
				types: ''
			},
			Login: 'Login',
			isError:  [],
			levelType: '',
			disabled : 'disabled',
			qty: null,
			dataCart: {},
			total:'',
			cart_data: '',
			nextBill: true,
			textBill: 'Lanjut',
			id_user: '',
			error: {},
			highlight: [],
			token:''

		}
	},
	created(){ //funsi create, fungsi yang akan dijalankan saat aplikasi vue di load
		this.getPosts() //function untuk mendapat data dari database
		this.loadCart
	},
	methods: {
		getPosts(){
			axios.get(path_uri + 'main/business_center_main_rest') // load API
			.then((response)=>{
				this.barang = response.data //data response hasil observeb di tampung di variabel barang
			});

			axios.get(path_uri + 'main/business_center_main_hot_rest')
			.then((response)=>{
				this.highlight = response.data
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
		},
		addLoginProcess(){
			// console.log(this.formLogin)
			this.Login = 'Memprosess..'
			let formData = this.toFormData(this.formLogin)
			axios.post(path_uri + 'login/login_process', formData)
			.then(response=>{
				// console.log(response.data)
				if(response.data.error){
					this.Login = 'Login'
					this.isError = response.data.message
					
				}else{
					this.Login = 'Berhasil'
					// console.log(response.data.type)
					if (response.data.type = 'admin') {
						window.location.assign(path_uri + 'admin')
					}else if (response.data.type = 'siswa') {
						$('#loginModal').modal('hide')
						this.formLogin = []
						
					}
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
        addToCart(e){
        	let i = {
        		code: e.kode,
        		name: e.nama_barang,
        		sprice: Number(e.harga),
        		qty: Number(this.qty)
        	}
        	let data = this.toFormData(i)
        	axios.post(path_uri + 'Cart_Controller', data)
        	.then(response=>{
        		this.hasCart = true
        		$('#cart_data').html(response.data)
        	})
        },
		addBill(){
        	this.nextBill = false
        },
        processBill(){
        	this.textBill = 'Process <i class="fa fa-spinner fa-spin"></i>'
        	let i = {
        		id_user: this.id_user
        	}
        	let data = this.toFormData(i)
        	axios.post(path_uri + 'Cart_Controller/business_center_main_bill_cart',data)
        	.then(res=>{
        		if(res.data.error){
        			this.error = res.data.message
        			this.textBill = 'Ulangi'
        		}if(res.data.success){
        			this.addCart = false
					Swal({
						title: 'Sukses',
						text: 'Pesanan Anda sudah dikirim! Cek token pembelanjaan',
						type: 'success'
					}).then(result=>{
						if(result.value){
				        	let t = {
				        		id_user: this.id_user
				        	}
				        	let data1 = this.toFormData(t)
				        	axios.post(path_uri + 'main/business_center_main_get_token', data1)
				        	.then(res=>{
				        		this.token = res.data[0].kode_pesanan
								$('#cartModal').modal('hide')
								this.getToken = true
				        	})

	    					this.dialog = !this.dialog
			        		this.modelData = []
			        		this.isValidate = []
			        		this.imageName = ''
						}
					})
        		}
        	})
        }
	},
	computed:{
		loadCart(){
        	return axios.get(path_uri + 'Cart_Controller/business_center_main_load_cart')
        	.then(response=>{
        		$('#cart_data').html(response.data)
        	})
		},
		display(){ //elastic search!!!!!!!!!!
			return this.paginate(this.barang.filter((e)=>{
				return e.nama_barang.toLowerCase().match(this.input.toLowerCase())
			}))
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
		},
		id_user(){
			if(this.id_user == ''){
				this.error = ''
				this.textBill = 'Lanjut'
			}
		}
	}
});

// Terpaksa memakai jQuery.

$(document).ready(function(){
    $(document).on('click','.remove_cart',function(){ //belum bisa ES6 :(
	    let data=$(this).attr("id"); 
	    let url = "http://localhost/PHP_PROJECT/CodeIgniter/codeigniter/Cart_Controller/business_center_main_delete_cart";
	    $.ajax({
	        url : url,
	        method : "POST",
	        data : {data : data},
	        success :function(data){
	            $('#cart_data').html(data);
	            // console.log(data);
	        }
	    });
	});

	$(".foto").owlCarousel({
        loop: true,
        margin: 5,
        center: false,
        lazyLoad: true,
        responsiveClass: true,
        autoplay:true,
        autoplayTimeout:7000,
        autoplayHoverPause:true,
        responsive :{
            768: {
                items: 1,
                dotEach: false,
            },
            900: {
                items: 2,
                dotEach: false
            }
        }
    });
	// $('.bill_cart').click(function(){
	// 	// let data2 = new FormData($('#form_cart')[0]);
	// 	let data = {
	// 		pruduct_id: $(this).data('productid'),
	// 		product_name: $(this).data('productname'),
	// 		product_price: $(this).data('productprice'),
	// 		product_qty: $(this).data('productqty'),
	// 		product_subtotal: $(this).data('productsubtotal'),
	// 		product_total: $(this).data('producttotal'),
	// 	}
	// 	console.log(data);
	// 	$.ajax({
	// 	});
	// });
});