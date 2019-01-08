const path_uri = "http://localhost/PHP_PROJECT/CodeIgniter/codeigniter/"

import {footer} from "./footer.js"
import {themes} from "./themes.js"

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