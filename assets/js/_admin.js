const api_uri = 'http://localhost/PHP_PROJECT/CodeIgniter/codeigniter/'


// Component for First tabs in routes
	let Main = {
		template: `

			<div>
				<v-layout>
					<v-flex lg12 md12 row justify-center class="pa-4">
						<span class="title text-center">Dashboard</span>
					</v-flex>
				</v-layout>
				<div class="d-flex flex-row col-12">
					<v-flex class="col-lg-4 col-md-12 m-2">
						<v-card v-ripple hover>
							<v-layout row class="pa-1 col-12">
								<div class="col-md-12 col-lg-8 d-flex">
									<v-card-title primary-title class="m-auto d-flex">
									  	<div lg12 class="m-auto d-flex flex-column">
									  		<div style="cursor: normal" xs12 class="display-1 m-auto">{{allItems}}</div>
									  		<div style="cursor: normal" xs12 class="m-auto text-xs-center">Jumlah Barang</div>
									  	</div>
									</v-card-title>
								</div>
								<div class="d-flex overflow-hidden col-sm-12 col-lg-4">
								  <v-icon class="m-auto d-none d-lg-inline text-warning" style="font-size: 5rem; margin-left: -5px;">inbox</v-icon>
								</div>
							</v-layout>
						</v-card>
					</v-flex>
					<v-flex class="col-lg-4 col-md-12 m-2">
						<v-card v-ripple hover>
							<v-layout row class="pa-1 col-12">
								<div class="col-md-12 col-lg-8 d-flex">
									<v-card-title primary-title class="m-auto d-flex">
									  	<div lg12 class="m-auto d-flex flex-column">
									  		<div style="cursor: normal" xs12 class="display-1 m-auto">{{allBills}}</div>
									  		<div style="cursor: normal" xs12 class="m-auto text-xs-center">Jumlah Pesanan</div>
									  	</div>
									</v-card-title>
								</div>
								<div class="d-flex overflow-hidden col-sm-12 col-lg-4">
								  <v-icon class="m-auto d-none d-lg-inline text-info" style="font-size: 5rem; margin-left: -5px;">add_shopping_cart</v-icon>
								</div>
							</v-layout>
						</v-card>
					</v-flex>
					<v-flex class="col-lg-4 col-md-12 m-2">
						<v-card v-ripple hover>
							<v-layout row class="pa-1 col-12">
								<div class="col-md-12 col-lg-8 d-flex">
									<v-card-title primary-title class="m-auto d-flex">
									  	<div lg12 class="m-auto d-flex flex-column">
									  		<div style="cursor: normal" xs12 class="display-1 m-auto">{{allSuccess}}</div>
									  		<div style="cursor: normal" xs12 class="m-auto text-xs-center">Transaksi</div>
									  	</div>
									</v-card-title>
								</div>
								<div class="d-flex overflow-hidden col-sm-12 col-lg-4">
								  <v-icon class="m-auto d-none d-lg-inline text-success" style="font-size: 5rem; margin-left: -5px;">done_all</v-icon>
								</div>
							</v-layout>
						</v-card>
					</v-flex>
				</div>
			</div>
		`,
		async mounted(){
			await this.getData()
		},
		data(){
			return {
				timer: null,
				allItems: 0,
				allBills: 0,
				allSuccess: 0
			}
		},
		methods: {
	        getData(){
				return new Promise((resolve, reject)=>{
					return setInterval(()=>{
						clearTimeout(this.timer);
						this.timer = setTimeout(()=>{
							axios({
								url: api_uri + 'main/business_center_main_rest',
								method: 'get',
							})
							.then(res=>{
								if(res.status == 200){
									let items = '';
									let total = '';

									items = res.data;
									total = items.length;

									resolve({
										items, total
									});

									this.allItems = total
								}
							});

							axios({
								url: api_uri + 'Cart_Controller/business_center_main_get_bill',
								method: 'get',
							})
							.then(res=>{
								if(res.status == 200){
									let items = '';
									let total = '';

									items = res.data;
									total = items.length;

									resolve({
										items, total
									});

									this.allBills = total
								}
							});

							axios({
								url: api_uri + 'main/business_center_get_success_bill',
								method: 'get',
							})
							.then(res=>{
								if(res.status == 200){
									let items = '';
									let total = '';

									items = res.data;
									total = items.length;

									resolve({
										items, total
									});

									this.allSuccess = total
								}
							});
						}, 500);
					}, 1000)
				})
	        }
		}
	}

// Component for Home/Table tabs in routes
	let Home = {
		template: `
			<div>

				<v-dialog v-model="details" width="500" persistent>
					<v-card>
						<v-card-title class="h3-responsive text-center">{{isSelected.nama_barang}}</v-card-title>
						<v-divider></v-divider>

						<v-card-text>
							<v-form method="POST">
								<v-text-field 
									name="kode"
									v-model="isSelected.kode"
									prepend-icon="fa fa-user-lock"
									label="Kode Barang"
									required
								></v-text-field>
							    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.kode"></small>

								<v-text-field 
									name="nama_barang"
									v-model="isSelected.nama_barang"
									prepend-icon="fa fa-clipboard-list"
									label="Nama Barang"
									required
								></v-text-field>
							    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.nama_barang"></small>


								<v-text-field 
									name="harga"
									v-model="isSelected.harga"
									prepend-icon="fa fa-dollar-sign"
									label="Harga Barang"
									type="number"
									required
								></v-text-field>
							    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.harga"></small>


								<v-text-field 
									name="stok"
									v-model="isSelected.stok"
									prepend-icon="fa fa-cubes"
									label="Stok Barang"
									type="number"
									required
								></v-text-field>
							    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.stok"></small>
							    
							    <div class="col-12 d-flex flex-column">
					  				<img v-if="isSelected.photo" :src="'http://localhost/PHP_PROJECT/CodeIgniter/codeigniter/upload/' + isSelected.photo" id="image" class="img-fluid col-8 m-auto justify-content-center animated w-75 m-auto fadeIn"><br>
					  				<v-layout class="d-flex flex-column" v-if="!isSelected.photo">
										<span class="m-auto">
											<v-icon>image</v-icon>
										</span>
										<span class="m-auto">No photo uploaded</span>
					  				</v-layout>

								    <v-checkbox label="Ubah" v-model="$root.isRemoveSelected" name="remove"></v-checkbox>
									<input type="file" name="photo"  ref="photo" accept="image/*" @change="handlePhotoUpdate($event)">
									<small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.photo"></small>

					  				<hr>
					  				<span v-if="imageURI" class="text-sm-center">Foto Baru</span>
							    	<img :src="imageURI" class="img-fluid col-8 m-auto justify-content-center animated w-75 m-auto fadeIn">
							    </div>


								<v-card-actions>
									<v-btn outline block wrap color="red" flat @click="[details = !details, isSelected = [], isValidate = [], removed = false, imageURI = '']">Batal</v-btn>
									<v-spacer></v-spacer>
									<v-btn outline block wrap color="indigo" type="button" flat v-html="Simpan" @click="updateThis(isSelected)"></v-btn>
								</v-card-actions>

							</v-form>
						</v-card-text>
					</v-card>
				</v-dialog>

				<v-layout row>
					<v-flex lg12 md12 row justify-center>
						<span class="title text-center">Tabel Barang</span>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex md3 xs12>
						<v-text-field 
							label="Search" 
							v-model="search"
							append-icon="fa fa-search"
							single-line
							hide-details
							class="m-2"
							>
						</v-text-field>
					</v-flex>
			<!-- <v-flex md6 xs12 row>
						<v-btn class="m-auto" title="refresh" icon flat round color="info" @click.native="refresh">
							<v-icon>refresh</v-icon>
						</v-btn>
					</v-flex> -->
					<v-spacer xs0></v-spacer>
					<v-flex md3 xs12 row justify-end>
						<span class="m-auto">Menampilkan {{totalData}} data</span>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex lg12 md-12 xs-12>
						<v-data-table 
							:headers="headers"
							:items="allData"
							:pagination.sync="pagination"
							:total-items="totalData"
							:loading="loading"
							rowsPerPageText="Data per-halaman"
							class="elevation-1"
							style="cursor: pointer"
						>
							<template slot="items" slot-scope="props">
								<tr>
									<td>{{props.item.kode}}</td>
									<td class="text-xs-right">{{props.item.nama_barang}}</td>
									<td class="text-xs-right">{{props.item.harga}}</td>
									<td class="text-xs-right">{{props.item.stok}}</td>
									<td class="text-xs-right">{{props.item.photo}}</td>
									<td>
										<v-btn icon class="m-auto" small color="success" flat @click="[isSelected = props.item, details = !details]" title="Edit">
											<v-icon class="text-success">edit</v-icon>
										</v-btn>
										<v-btn icon class="m-auto" small color="error" flat @click="deleteThis(props.item)" title="Hapus?">
											<v-icon class="text-danger">delete_forever</v-icon>
										</v-btn>
									</td>
								</tr>
							</template>
						</v-data-table>
					</v-flex>
				</v-layout>
			</div>
		`,
		data(){
			return {
				details: false,
				imageURI:'',
				search: "",
				allData: [], //fe
				getDatas: [], //be
				totalData: 0,
				loading: true,
				pagination: {},
				headers: [
					{
						text: "Kode Barang",
						align: "left",
						sortable: false,
						value: "kode"
					},
					{	text: "Nama Barang ", align: "right", value: "nama_barang"},
					{	text: "Harga ", align: "right", value: "harga"},
					{	text: "Stok ", align: "right", value: "stok"},
					{	text: "Photo ", align: "right", value: "photo", sortable: true},
					{	text: "Action ", align: "right", sortable: false}
				],

				isSelected: {},
				isEditable: true,
				isRemoveSelected: '',
				isDisabled: 'disabled blue-grey lighten-4',
				updatedPhoto: '',
				removed: false,
				willRemove: '',
				Simpan: 'Simpan',
				modelData: {
					kode: '',
					nama_barang: '',
					harga: '',
					stok: '',
					photo: ''
				},
				isValidate: [],
			}
		},
		watch: {
			pagination: {
				handler(){
					this.getDataFromApi2().then(data=>{
						this.allData = data.items;
						this.totalData = data.total;
					})
				},
				deep: true
			},
			// search(){
			// 	if(this.search != ''){
			// 		this.getDataFromApi2().then(data=>{
			// 		 	this.allData = data.allDatas;
			// 			this.totalData = data.total;
			// 		})
			// 	}else{
			// 		this.getDataFromApi2().then(data=>{
			// 			this.allData = data.items;
			// 			this.totalData = data.total;
			// 		})
			// 	}
			// },
		},
		async mounted(){
			await this.getDataFromApi2().then(data=>{
				this.allData = data.items;
				this.totalData = data.total;
			})
		},
		methods: {
			refresh(){
				return this.getDataFromApi().then(res=>{
					this.queue = res.items
					this.totalData = res.total
				})
			},
			getDataFromApi2(){
				this.loading = true;
				return new Promise((resolve, reject)=>{
					var { sortBy, descending, page, rowsPerPage } = this.pagination;
					clearTimeout(this.timer);
					this.timer = setTimeout(()=>{
						axios({
							url: api_uri + 'main/business_center_main_rest',
							method: 'get',
						})
						.then(res=>{
							if(res.status == 200){

								let items = res.data;
								let allDatas = res.data;
	        					let search = this.search.trim().toLowerCase();
								const total = items.length;

				        		if(sortBy){
				        			items = items.sort((a, b)=> {
					        				const sortA = a[sortBy];
					        				const sortB = b[sortBy];

					        				if(descending){
					        					if(sortA < sortB) return 1;
					        					if(sortA > sortB) return -1;
					        					return 0;
					        				}else{
					        					if(sortA < sortB) return -1;
					        					if(sortA > sortB) return 1;

					        				}
				        			});
				        		}
				        		
				        		if(rowsPerPage > 0){
			        				items = items.slice(
				        					(page - 1)*rowsPerPage,
				        					page*rowsPerPage
			        				);
				        		}
				        		if(search){
				        			allDatas = allDatas.filter(item => {
				        				return 	Object.values(item)
							        				  .join(",")
							        				  .toLowerCase()
							        				  .includes(this.search.trim().toLowerCase())
						        		})
				        		}
								this.loading = false;
								resolve({
									items, total, allDatas
								});
							}
						});
					}, 300)
				})
			},
			editThis(){
				this.isDisabled = ''
				this.isEditable = false
			},
			handlePhotoUpdate(e){
				app.updatedPhoto = e.target.files[0]
				const files = e.target.files
				if(files[0] !== undefined){
					const fr = new FileReader();
					fr.readAsDataURL(files[0])
					fr.addEventListener('load',()=>{
						this.imageURI = fr.result
					})
				}else{
					// 
				}
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
						axios.post(api_uri+'Post_Controller/business_center_delete_models/'+e.kode)
						.then(response=>{
	    						Swal({
	    							title: 'Berhasil',
	    							text: e.nama_barang + ' telah dihapus',
	    							type: 'success'
	    						}).then(result=>{
	    							if(result.value){
	    								this.dialog = !this.dialog
										this.getDataFromApi2().then(data=>{
											this.allData = data.items;
											this.totalData = data.total;
										})
	    							}
	    						})
						})
					}
				})
			},
			updateThis(e){
				this.Simpan = 'Menyimpan  <i class="fa fa-spinner fa-spin indigo-text"></i>'
				let data = {
					kode: e.kode,
					nama_barang: e.nama_barang,
					harga: e.harga,
					stok: e.stok,
					cur_photo: e.photo,
					photo: app.updatedPhoto,
					remove: app.isRemoveSelected
				}
				let formData = this.toFormData(data)
				axios.post(api_uri+'Post_Controller/business_center_update_models', formData)
					.then(response=>{
						// console.log(response.data)
						if(response.data.error){
							this.Simpan = 'Simpan'
							this.isValidate = response.data.msg
						}else{
							this.Simpan = 'Tersimpan'
	    					this.details = !this.details
							this.imageURI = ''
							Swal({
								title: 'Sukses',
								text: 'Data berhasil di update',
								type: 'success'
							}).then(result=>{
    							if(result.value){
    								this.dialog = !this.dialog
    								this.isValidate = []
									this.getDataFromApi2().then(data=>{
										this.allData = data.items;
										this.totalData = data.total;
									})
    							}
    						})
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
		},
	}

// Component for Logs tabs in routes
	let Logs = {
		template: `
			<div>
				<v-layout row>
					<v-flex lg12 md12 row justify-center>
						<span class="title text-center">Riwayat Kejadian</span>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex md6 xs12 row>
						<span class="m-auto p-3">Ada {{totalData}} kejadian</span>
					</v-flex>
					<v-spacer></v-spacer>
					<v-flex md6 xs12 row>
						<v-btn class="m-auto" :class="totalData.length != 0 ? isAble : isNot" title="kosongkan riwayat kejadian" icon flat round color="red" @click.native="clearHistory">
							<v-icon>delete_forever</v-icon>
						</v-btn>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex lg12 md-12 xs-12>
						<v-data-table 
							:headers="headers"
							:items="logs"
							:pagination.sync="pagination"
							:total-items="totalData"
							:loading="loading"
							rowsPerPageText="Data per-halaman"
							class="elevation-1"
						>
							<template slot="items" slot-scope="props">
								<tr>
									<td class="text-xs-center">{{props.item.tanggal}}</td>
									<td class="text-xs-center">{{props.item.kejadian}} {{props.item.barang}}</td>
								</tr>
							</template>
						</v-data-table>
					</v-flex>
				</v-layout>
			</div>
		`,
		data(){
			return {
				isAble: '',
				isNot: 'disabled',
				search: "",
				logs: [], //fe
				getDatas: [], //be
				totalData: 0,
				loading: false,
				pagination: {},
				timer: null,
				headers: [
					{
						text: "Tanggal",
						align: "center",
						sortable: true,
						value: "tanggal"
					},
					{	text: "Kejadian", align: "center", value: "kejadian", sortable: false}
				],
			}
		},
		watch: {
			pagination: {
				handler(){
					this.getDataFromApi().then(data=>{
						this.logs = data.items;
						this.totalData = data.total;
					})
				},
				deep: true
			}
		},
		async mounted(){
			await this.getDataFromApi().then(res=>{
				this.logs = res.items;
				this.totalData = res.total;
			})
		},
		computed :{
			params(nv){
				return{
					...this.pagination,
					query: this.search
				}
			},
		},
		methods: {
			clearHistory(){
				let dummy = { delete: 'delete' }
				let data = this.toFormData(dummy)
				axios.post(api_uri+'Post_Controller/business_center_truncate_log', data)
				.then(response=>{
					this.getDataFromApi().then(data=>{
						this.logs = data.items;
						this.totalData = data.total;
					})
				})
			},
	        toFormData(obj){
	            const form_data = new FormData();
	            for(var key in obj){
	                form_data.append(key, obj[key])
	            }
	            return form_data
	        },
			getDataFromApi(){
				this.loading = true;
				return new Promise((resolve, reject)=>{
					var { sortBy, descending, page, rowsPerPage } = this.pagination;
					clearTimeout(this.timer);
					return setInterval(()=>{
						this.timer = setTimeout(()=>{
							axios({
								url: api_uri + 'main/business_center_main_log_rest',
								method: 'get',
							})
							.then(res=>{
								if(res.status == 200){

									let items = res.data;
									const total = items.length;

					        		if(sortBy){
					        			items = items.sort((a, b)=> {
						        				const sortA = a[sortBy];
						        				const sortB = b[sortBy];

						        				if(descending){
						        					if(sortA < sortB) return 1;
						        					if(sortA > sortB) return -1;
						        					return 0;
						        				}else{
						        					if(sortA < sortB) return -1;
						        					if(sortA > sortB) return 1;

						        				}
					        			});
					        		}
					        		if(rowsPerPage > 0){
				        				items = items.slice(
					        					(page - 1)*rowsPerPage,
					        					page*rowsPerPage
				        				);
					        		}
									this.loading = false;
									resolve({
										items, total
									});
								}
							});
						}, 500)
					}, 1000)
				})
			},
		}
	}

// Component for Message tabs in routes
	let Message = {
		template: `
			<div class="d-flex">
				<div class="col-10 m-auto">
					<v-layout row>
						<v-flex class="title text-center">Pesan Untuk Siswa</v-flex>
					</v-layout>
					<v-layout row justify-center style="height: 70vh">
						<v-flex class="m-auto">
							<v-form method="post" @submit.prevent="sendMessage" autocomplete="off" class="d-flex flex-column w-100">
								<v-text-field
									ref="message"
									name="message"
									v-model="note.message"
									class="m-auto w-100"
									label="Tulis pesan lalu enter"
									required
								>
								</v-text-field>
						    	<small class="text-danger" v-html="isValidate.message"></small>
						    	<small class="text-danger" v-if="!isValidate.message">(Note** Ini adalah pesan yang akan disampaikan ke halaman dimana siswa akses)</small>
							</v-form>
						</v-flex>
					</v-layout>
				</div>
			</div>
		`,
		data(){
			return {
				note: { 
					message: '' 
				},
				isValidate: [],
			}
		},
		methods: {
			sendMessage(){
				let data = this.toFormData(this.note)
				axios.post(api_uri+'Post_Controller/business_center_save_notes_models', data)
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

		}
	}

// Component for Queue(Pesanan) tabs in routes
	let Queue = {
		template: `
			<div style="transition: .5s all">
				<v-layout row>
					<v-flex lg12 md12 row justify-center>
						<span class="title text-center">Daftar Pesanan</span>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex md6 xs12 row>
						<span class="m-auto p-3">Ada {{totalData}} pesanan</span>
					</v-flex>
					<v-spacer></v-spacer>
					<v-flex md6 xs12 row>
						<v-btn class="m-auto" title="refresh" icon flat round color="info" @click.native="refresh">
							<v-icon>refresh</v-icon>
						</v-btn>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex lg12 md-12 xs-12>
						<v-data-table 
							:headers="headers"
							:items="queue"
							:pagination.sync="pagination"
							:total-items="totalData"
							:loading="loading"
							rowsPerPageText="Data per-halaman"
							class="elevation-1 mb-5"
							>
							<template slot="items" slot-scope="props">
								<tr>
									<keep-alive>
										<td>
											<v-checkbox multiple @change="process(props.item)" v-model="props.checkData" :value="props.item" primary hide-details ></v-checkbox>
										</td>
									</keep-alive>
									<td class="text-xs-center"><b> {{props.item.kode_pesanan}} </b></td>
									<td class="text-xs-center">{{props.item.id_user}}</td>
									<td class="text-xs-center">{{props.item.id_barang}}</td>
									<td class="text-xs-center">{{props.item.nama_barang}}</td>
									<td class="text-xs-center">{{props.item.qty}}</td>
									<td class="text-xs-center">Rp.{{props.item.harga}}</td>
									<td class="text-xs-center">Rp.{{props.item.sub_total}}</td>
									<td class="text-xs-center">{{props.item.tanggal}}</td>
									<td class="text-xs-center">
										<span :class="textWarning">Menunggu</span>
									</td>
								</tr>
							</template>
						</v-data-table>

						<transition enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown">
							<div class="d-flex flex-column" v-if="queue2.length">
								<v-flex lg12 md12 row justify-center>
									<span class="title text-center mb-2">Barang Siap</span>
								</v-flex>
								<v-data-table 
									:headers="headers2"
									:items="queue2"
									:total-items="queue2.length"

									rowsPerPageText="Data per-halaman"
									class="elevation-1"
									>
									<template slot="items" slot-scope="props">
										<tr>
											<td class="text-xs-center">{{props.item.kode_pesanan}}</td>
											<td class="text-xs-center"><b> {{props.item.id_user}} </b></td>
											<td class="text-xs-center">{{props.item.id_barang}}</td>
											<td class="text-xs-center">{{props.item.nama_barang}}</td>
											<td class="text-xs-center">{{props.item.qty}}</td>
											<td class="text-xs-center">Rp.{{props.item.harga}}</td>
											<td class="text-xs-center">Rp.{{props.item.sub_total}}</td>
											<td class="text-xs-center">{{props.item.tanggal}}</td>
											<td class="text-xs-center">
												<span class="text-primary">ready?</span>
											</td>
										</tr>

										<transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
											<v-snackbar
											  style="box-shadow: none !important;"
											  v-model="snackbars"
											  :bottom="y === 'bottom'"
											  :left="x === 'left'"
											  :multi-line="mode === 'multi-line'"
											  :right="x === 'right'"
											  :timeout="tos"
											  :top="y === 'top'"
											  :vertical="mode === 'vertical'"
											  >
											  Barang Siap ?
											  <v-spacer></v-spacer>
											  <v-btn flat color="success" @click.native="Bill(queue2)">Proses</v-btn>
											</v-snackbar>
										</transition>

									</template>
								</v-data-table>
							</div>
						</transition>

					</v-flex>
				</v-layout>
			</div>
		`,

		data(){
			return {

				search: "",
				selected: false,
				queue: [], //fe
				getDatas: [], //be
				totalData: 0,
				loading: false,
				pagination: {},
				timer: null,
				textWarning:'text-warning',
				textSuccess:'text-success',
				iconWarning:'fa fa-times-circle',
				iconSuccess:'fa fa-check-circle',
				headers: [
					{
						text: "#",
						align: "left",
						sortable: false,
					},
					{
						text: "Token",
						align: "left",
						sortable: false,
						value: "kode_pesanan"
					},
					{
						text: "ID User",
						align: "left",
						sortable: true,
						value: "id_user"
					},
					{
						text: "Kode Barang",
						align: "left",
						sortable: true,
						value: "id_barang"
					},
					{
						text: "Nama Barang",
						align: "left",
						sortable: true,
						value: "nama_barang"
					},
					{
						text: "QTY",
						align: "left",
						sortable: false,
						value: "qty"
					},
					{
						text: "@ Harga",
						align: "left",
						sortable: false,
						value: "harga"
					},
					{
						text: "Sub Total",
						align: "left",
						sortable: false,
						value: "sub_total"
					},
					{
						text: "Tanggal",
						align: "left",
						sortable: true,
						value: "tanggal"
					},
					{
						text: "Status",
						align: "left",
						sortable: false,
						value: "status"
					},
				],
				snackbar: false,
				snackbars: false,
				y: 'bottom',
				x: 'right',
				mode:'',
				timeout: 10000,
				tos: 0,
				willReady: false,
				queue2: [],
				checkData: null,
				headers2: [
					{
						text: "Token",
						align: "left",
						sortable: false,
						value: "kode_pesanan"
					},
					{
						text: "ID User",
						align: "left",
						sortable: false,
						value: "id_user"
					},
					{
						text: "Kode Barang",
						align: "left",
						sortable: false,
						value: "id_barang"
					},
					{
						text: "Nama Barang",
						align: "left",
						sortable: false,
						value: "nama_barang"
					},
					{
						text: "QTY",
						align: "left",
						sortable: false,
						value: "qty"
					},
					{
						text: "@ Harga",
						align: "left",
						sortable: false,
						value: "harga"
					},
					{
						text: "Sub Total",
						align: "left",
						sortable: false,
						value: "sub_total"
					},
					{
						text: "Tanggal",
						align: "left",
						sortable: false,
						value: "tanggal"
					},
					{
						text: "Status",
						align: "left",
						sortable: false,
						value: "status"
					},
				],
			}
		},
		watch: {
			pagination: {
				handler(){
					this.getDataFromApi().then(res=>{
						this.queue = res.items
						this.totalData = res.total
					})
				},
				deep: true
			}
		},
		async mounted(){
			await this.getDataFromApi().then(res=>{
				this.queue = res.items
				this.totalData = res.total
			})
		},
		methods: {
			refresh(){
				return this.getDataFromApi().then(res=>{
					this.queue = res.items
					this.totalData = res.total
				})
			},
			getDataFromApi(){
				this.loading = true;
				return new Promise((resolve, reject)=>{
					var { sortBy, descending, page, rowsPerPage } = this.pagination;
					this.timer = setTimeout(()=>{
						axios({
							url: api_uri + 'Cart_Controller/business_center_main_get_bill',
							method: 'get',
						})
						.then(res=>{
							if(res.status == 200){

								let items = res.data;
								const total = items.length;

				        		if(sortBy){
				        			items = items.sort((a, b)=> {
					        				const sortA = a[sortBy];
					        				const sortB = b[sortBy];

					        				if(descending){
					        					if(sortA < sortB) return 1;
					        					if(sortA > sortB) return -1;
					        					return 0;
					        				}else{
					        					if(sortA < sortB) return -1;
					        					if(sortA > sortB) return 1;

					        				}
				        			});
				        		}
				        		if(rowsPerPage > 0){
			        				items = items.slice(
				        					(page - 1)*rowsPerPage,
				        					page*rowsPerPage
			        				);
				        		}
								this.loading = false;
								resolve({
									items, total
								});
							}
						});
					}, 500)
				})
			},
			process(ev){
				this.checkData = true
				console.log(this.checkData)
				if(this.queue2.includes(ev)){
					this.queue2.splice(this.queue2.indexOf(ev),1)
				}else {
					this.queue2.push(ev)
					setTimeout(()=>{
						this.snackbars === true ? /**do nothing' **/this.snackbars : this.snackbars = true	
					}, 1000)
				}
			},
			Bill(par){
				let e = []
				e.push(par)
				var kode =  {
						kode: e[0][0].kode_pesanan,
						id:e[0][0].id_user,
						tanggal: e[0][0].tanggal,
						total: e[0][0].total
				}
				let data = this.toFormData(kode)
				axios.post(api_uri+'Post_Controller/business_center_save_bill_models', data)
				.then(res=>{
					console.log(res.data)
					if(res.data.error == false){
						Swal({
							title: 'Barang ready!',
							text: 'Siswa telah diberitahu',
							type: 'success'
						}).then(result=>{
							if(result.value){
								this.queue2 = false
								this.getDataFromApi().then(res=>{
									this.queue = res.items
									this.totalData = res.total
								})
							}
						})
					}else{

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
		}
	}

// Component for Piutang/Transaksi tabs in routes
	let Success = {
		template: `
			<div>
				<div style="transition: .5s all">
					<v-layout row>
						<v-flex lg12 md12 row justify-center>
							<span class="title text-center">Transaksi</span>
						</v-flex>
					</v-layout>
					<v-layout row>
						<v-flex md6 xs12 row>
							<span class="m-auto p-3">{{totalData}} Transaksi</span>
						</v-flex>
						<v-spacer></v-spacer>
						<v-flex md6 xs12 row>
							<v-btn class="m-auto" title="refresh" icon flat round color="info" @click.native="refresh">
								<v-icon>refresh</v-icon>
							</v-btn>
						</v-flex>
					</v-layout>
					<v-layout row>
						<v-flex lg12 md-12 xs-12>
							<v-data-table 
								:headers="headers"
								:items="sukses"
								:pagination.sync="pagination"
								:total-items="totalData"
								:loading="loading"
								rowsPerPageText="Data per-halaman"
								class="elevation-1 mb-5"
								>
								<template slot="items" slot-scope="props">
									<tr>
										<td class="text-xs-left">{{props.item.NISN}}</td>
										<td class="text-xs-left">{{props.item.Nama}}</td>
										<td class="text-xs-left"><b> {{props.item.token}} </b></td>
										<td class="text-xs-left">{{props.item.tanggal}}</td>
										<td class="text-xs-left">Rp.{{props.item.total}}</td>
										<td class="text-xs-left">
											<v-btn icon class="m-auto" small color="success" flat @click="detail(props.item.token)">
												<v-icon class="text-primary">info</v-icon>
											</v-btn>
										</td>
									</tr>
								</template>
							</v-data-table>
						</v-flex>
					</v-layout>
				</div>
				<v-dialog v-model="detailPesan" width="500">
					<v-card>
						<v-card-title class="h3-responsive text-center">Kode Pesanan : <span class="font-weight-bold"> {{id_pesanan.kode_pesanan}}</span></v-card-title>
						<v-divider></v-divider>

						<v-card-text>

							<table class="table table-hover table-bordered table-success table-light table-primary table-striped table-sm">
								<thead>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
									<th>Harga Satuan</th>
									<th>QTY</th>
									<th>Sub Total</th>
								</thead>
								<tbody v-for="(i, index) in details">
									<tr>
										<td>{{i.id_barang}}</td>
										<td>{{i.nama_barang}}</td>
										<td>Rp. {{i.harga}}</td>
										<td>{{i.qty}}</td>
										<td>Rp. {{i.sub_total}}</td>
									</tr>
								</tbody>
							</table>

						</v-card-text>
					</v-card>
				</v-dialog>
			</div>

		`,

		data(){
			return {
				search: "",
				sukses: [], //fe
				getDatas: [], //be
				totalData: 0,
				loading: false,
				pagination: {},
				timer: null,
				headers: [
					{
						text: "NISN",
						align: "left",
						sortable: false,
						value: "nisn"
					},
					{
						text: "Nama",
						align: "left",
						sortable: false,
						value: "nama"
					},
					{
						text: "Token Belanja",
						align: "left",
						sortable: false,
						value: "token"
					},
					{
						text: "Tanggal",
						align: "left",
						sortable: true,
						value: "tanggal"
					},
					{
						text: "Total Belanja",
						align: "left",
						sortable: true,
						value: "total"
					},
					{
						text: "Detail",
						align: "left",
						sortable: false,
						value: "detail"
					},
				],
				detailPesan: false,
				details:[],
				id_pesanan:[]
			}
		},
		watch: {
			pagination: {
				handler(){
					this.getDataFromApi().then(res=>{
						this.sukses = res.items
						this.totalData = res.total
					})
				},
				deep: true
			}
		},
		async mounted(){
			await this.getDataFromApi().then(res=>{
				this.sukses = res.items
				this.totalData = res.total
			})
		},

		methods: {
			refresh(){
				return this.getDataFromApi().then(res=>{
					this.queue = res.items
					this.totalData = res.total
				})
			},
			getDataFromApi(){
				this.loading = true;
				return new Promise((resolve, reject)=>{
					var { sortBy, descending, page, rowsPerPage } = this.pagination;
					this.timer = setTimeout(()=>{
						axios({
							url: api_uri + 'main/business_center_get_success_bill',
							method: 'get',
						})
						.then(res=>{
							if(res.status == 200){

								let items = res.data;
								const total = items.length;

				        		if(sortBy){
				        			items = items.sort((a, b)=> {
					        				const sortA = a[sortBy];
					        				const sortB = b[sortBy];

					        				if(descending){
					        					if(sortA < sortB) return 1;
					        					if(sortA > sortB) return -1;
					        					return 0;
					        				}else{
					        					if(sortA < sortB) return -1;
					        					if(sortA > sortB) return 1;

					        				}
				        			});
				        		}
				        		if(rowsPerPage > 0){
			        				items = items.slice(
				        					(page - 1)*rowsPerPage,
				        					page*rowsPerPage
			        				);
				        		}
								this.loading = false;
								resolve({
									items, total
								});
							}
						});
					}, 500)
				})
			},
			detail(par){
				let token = {
					token : par
				}
				let data = this.toFormData(token)
				axios.post(api_uri + 'main/business_center_get_detail_bill', data)
				.then(res=>{
					this.details = res.data
					this.id_pesanan = res.data[0]
					console.log(this.details)
					this.detailPesan = !this.detailPesan
				})
			},
	        toFormData(obj){
	            const form_data = new FormData();
	            for(var key in obj){
	                form_data.append(key, obj[key])
	            }
	            return form_data
	        },
		}
	}

// Routing
	const Routes = new VueRouter({
		mode: 'history',
		base: 'PHP_PROJECT/CodeIgniter/codeigniter/admin/',
		routes : [
			{
				path: "/",
				name: "main",
				component: Main //Component, look above!
			},
			{
				path: "/home",
				name: "home",
				component: Home //Component, look above!
			},
			{
				path: "/logs",
				name: "logs",
				component: Logs //Component, look above!
			},
			{
				path: "/message",
				name: "message",
				component: Message //Component, look above!
			},
			{
				path: "/pesanan",
				name: "pesanan",
				component: Queue //Component, look above!
			},
			{
				path: "/piutang",
				name: "Piutang",
				component: Success
			},
			{
				path: "*",
				component: Main
			},
		]
	})

// Main Instance
	const app = new Vue ({
		el: '#app',
		router: Routes,
		iconfont: 'fa',
		data(){
			return {
				updatedPhoto: '',
				isRemoveSelected: '',
		        drawer: null,
		        homes: [
		       		{ title: 'Home', icon: 'home', route: '/' },
		        ],
		        items: [
		         	{ title: 'Tabel Barang', icon: 'view_list' , route: '/home'},
		          	{ title: 'Tabel Riwayat', icon: 'history' , route: '/logs'},
		          	{ title: 'Catatan', icon: 'note' , route: '/message'},
		          	{ title: 'Statistik', icon: 'show_chart' , route: '/statistik'},
		        ],
		        right: null,

				dialog: false,
				Simpan: 'Simpan',
				modelData: {
					kode: '',
					nama_barang: '',
					harga: '',
					stok: '',
					photo: ''
				},
				isValidate: [],
				imageName: '',
				imageURI: '',
				productImg: 'image',
				queue: 0,
				sukses: 0,
				snackbar: false,
				y: 'bottom',
				x: 'left',
				mode:'',
				timeout: 6000,
				texts: '',
				timer: null,
			}
		},
		async mounted(){
			await this.getDataQueue()
		},
		methods: { //Global Methods
			goToQueue(){
				this.snackbar = false
				this.$router.push("/pesanan")
			},
	        logout(){
	        	window.location.assign(api_uri + 'login/logout')
	        },
	        pickPhoto(){
	        	this.$refs.photo.click()
	        },
			handlePhoto(e){
				const files = e.target.files
				if(files[0] !== undefined){
					this.imageName = files[0].name
					this.modelData.photo = files[0]
					const fr = new FileReader();
					fr.readAsDataURL(files[0])
					fr.addEventListener('load',()=>{
						this.imageURI = fr.result
					})
					if(this.imageName.lastIndexOf('.' <= 0)){
						return
					}
				}else{
					this.modelData.photo = ''
				}
			},
			save(){
				this.Simpan = '<i class="m-2 fa fa-spinner fa-spin text-indigo"></i>'
				let data = this.toFormData(this.modelData)
				console.log(data)
				axios.post(api_uri+'Post_Controller/business_center_save_models', data)
				.then(response=>{
					if(response.data.error){
						this.Simpan = 'Simpan'
						this.isValidate = response.data.msg
					}else{
						this.Simpan = 'Tersimpan'
						Swal({
							title: 'Sukses',
							text: 'Data tersimpan ke database',
							type: 'success'
						}).then(result=>{
							if(result.value){
		    					this.dialog = !this.dialog
				        		this.modelData = []
				        		this.isValidate = []
				        		this.imageName = ''
							}
						})
					}
				})
			},
			getDataQueue(){
				return new Promise((resolve, reject)=>{
					return setInterval(()=>{
						let items = '';
						let total = '';
						clearTimeout(this.timer);
						this.timer = setTimeout(()=>{
							axios({
								url: api_uri + 'Cart_Controller/business_center_main_get_bill',
								method: 'get',
							})
							.then(res=>{
								if(res.status == 200){

									items = res.data;
									total = items.length;

									resolve({
										items, total
									});

									this.queue = total
								}
							});

							axios({
								url: api_uri + 'main/business_center_get_success_bill',
								method: 'get',
							})
							.then(res=>{
								if(res.status == 200){

									items = res.data;
									total = items.length;

									resolve({
										items, total
									});

									this.sukses = total
								}
							});
						}, 500);
					}, 1000)
				})
			},
	        toFormData(obj){
	            const form_data = new FormData();
	            for(var key in obj){
	                form_data.append(key, obj[key])
	            }
	            return form_data
	        },

		},
		watch: {
			queue(){
				this.snackbar = true
			}
		}
	})
