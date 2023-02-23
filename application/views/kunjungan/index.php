<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<div class="row">
		<div class="col-sm-6">
			<h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
		</div>
	</div>
<form id="form_kunjungan" action="<?= base_url('kunjungan/tambah'); ?>" method="post">
	<!-- Page Content -->
	<div class="row mt-3">
		<div class="col-sm-12">
			<div class="card border-top-kirana shadow h-100 py-2">
				<div class="card-body">
					<form>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label><strong>Staff</strong></label>
									<select class="form-control custom-select select2" name="id_staff" id="id_staff_kunjungan" data-placeholder="Pilih Staff" data-multiple="false">
										<option value="">Pilih  Staff</option>									
										<?php $old = null; ?>
	                                      <?php foreach ($tampilstaff as $row3): ?>
	                                        <?php if ($row3['fullname']!=$old) : ?>
	                                        <option value="<?= $row3['id'] ?>" <?php echo set_select('id_staff_kunjungan',$row3['id']); ?>><?= $row3['fullname'] ?></option>
	                                        <?php $old = $row3['fullname'] ?>
	                                        <?php else: endif; ?>
	                                      <?php endforeach; ?>
	                                      									
									</select>
						

								</div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group">
									<label><strong>Periode</strong></label>
									<p><input type="text" name="tgl_kunjungan" class="form-control" id="tgl_kunjungan_kunjungan" placeholder="<?= date('d/m/Y') ?>"><i class="fas fa-calendar-alt txt-kirana" style="font-size: 20px; position: absolute; right: 0; margin-top: -29px; margin-right: 22px;" value="<?= set_value('tgl_kunjungan'); ?>"></i></p>
								</div>
							</div>

							<div class="col align-self-end">
								<div class="float-right mb-3">
									<a href="<?= base_url('kunjungan/tambah'); ?>"><button type="submit" class="btn btn-kirana" id="btn_tambah_kunjungan"><i class="fas fa-user-plus"></i> Tambah Data Kunjungan</button></a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<small class="form-text text-danger"><?= form_error('tgl_lahir'); ?></small>    
								<table class="table table-bordered" id="tabel_tampil_kunjungan">
									<thead class="bar-table">
										<th>No</th>
										<th>Tanggal Rencana</th>
										<th>&nbsp;</th>
										<th>Nama Mitra</th>
										<th>Alamat</th>
										<th>Tipe Kunjungan</th>
										<th>Action</th>
									</thead>
									<tbody id="tbodyid" class="aye">
										<tr>
											<td colspan="7">Silahkan pilih nama staff dan tanggal kunjungan terlebih dahulu.</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal TAMBAH/EDIT-->
	<div class="modal fade" id="modalKunjungan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
					<h5 class="modal-title" id="text-tambah">Tambah Rencana Kunjungan</h5>
					<h5 class="modal-title" id="text-edit">Edit Rencana Kunjungan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body rencana_kunjungan">
					<form action="<?= base_url('kunjungan/ubah'); ?>" method="post">
					<div class="form-group">
						<label for="tgl_kunjungan_input"><strong>Tanggal Kunjungan :</strong></label>
						<input type="text" name="tgl_kunjungan" id="tgl_kunjungan_input" class="form-control" readonly value="">
						<input type="hidden" name="id2" id="id2">
						<input type="hidden" name="periode" id="periode">
				        <input type="hidden" name="tgl_mulai" id="tgl_mulai">
				        <input type="hidden" name="tgl_akhir" id="tgl_akhir">

					</div>
					<div class="form-group">
						<label for="tipe_kunjungan"><strong>Tipe Kunjungan :</strong></label>
						<select class="form-control custom-select" name="tipe_kunjungan" id="tipe_kunjungan">
							<option value="">Pilih Tipe Kunjungan</option>
		 					<?php foreach($tipekun as $row2): ?>
								<option value="<?= $row2['id'] ?>"><?= $row2['tipe_kunjungan'] ?></option>
							<?php endforeach; ?>
							<div class='error_msg'>

</div>
						</select>
					</div>
					<div class="form-group">
						<label for="id_poktan"><strong>Pilih Poktan :</strong></label><br>	
						<select class="form-control custom-select select2" name="id_poktan" id="id_poktan" data-placeholder="Pilih Poktan" data-multiple="false" style="width: 100%">
							<option value="">Pilih  Poktan</option>
							<?php if(isset($poktan)): ?>
								<?php   foreach($poktan as $row): ?>
									<option value="<?= $row->id ?>" data-alamat="<?= $row->alamat ?>"><?= $row->nama_poktan ?></option>
								<?php   endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
				 <div class="form-group">
						<input type="hidden" name="alamat" id="alamat_edit" value="" class="form-control">
				<input type="hidden" name="id_poktan_tanam" id="id_poktan_tanam" value="" class="form-control">		
					</div>
		 		</div>
		 <div class="modal-footer">
		 	<input type="hidden" id="editTempRow" value="" class="form-control">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" id="btn-tambah" onclick="printdata()" class="btn btn-kirana">Tambah</button>
			<button type="submit" id="btn-edit"class="btn btn-kirana">Edit</button>
			<button type="button" id="btn-editTemp" class="btn btn-success">Simpan</button>
		</form>
		 </div>
		</div>
	 </div>
	</div>
<!-- Akhir Modal TAMBAH/EDIT -->

</div>


</form>	

<!-- JS KUNJUNGAN -->
<script src="<?= base_url(); ?>assets/js/script_kunjungan.js"></script>
<!-- AKHIR JS KUNJUNGAN -->
