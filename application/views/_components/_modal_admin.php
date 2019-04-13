
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
					  <div class="form-group">
					  	<label for="image">Foto <span v-if="removed" class="text-danger">(dihapus)</span></label><br>
					  	<img :src="'<?= base_url('upload/') ?>' + isSelected.photo" id="image" class="w-50" :class="[isDisabled, willRemove]" alt="foto"><br>
					  	<small class="text-sm-left" v-html="isSelected.photo"></small>
						<br><br>
				  		<label class="form-check-label">
					    	<input class="form-check-input" type="checkbox" id="photo" false-value="" :true-value="isSelected.photo" name="remove" :class="isDisabled" @change="[updatedPhoto = '', removed = true]" v-model="isRemoveSelected">Hapus & Ubah
					    	<input type="file" class="form-control-file" id="photo" name="photo" ref="photos" @change="handlePhotoUpdate" :class="isDisabled"> <br>
						    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.photo"></small>
					  	</label>
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
					    <input type="file" class="form-control-file" id="photo" name="photo" ref="photo" @change="handlePhoto">
					    <small class="text-sm-left text-danger animated fadeIn" v-html="isValidate.photo"></small>
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