$(document).ready(function() {
	$('#tabel').DataTable();
	$('#tabelLog').DataTable();
});

const api_uri = 'http://localhost/PHP_PROJECT/CodeIgniter/codeigniter/'


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
				photo: ''
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
		handlePhoto(){
			this.modelData.photo = this.$refs.photo.files[0]
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