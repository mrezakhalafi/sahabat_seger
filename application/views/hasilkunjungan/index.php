<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-sm-6">
      <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    </div>
  </div>
  <!-- Page Content -->
  <div class="row mt-3">
    <div class="col-sm-12">
      <div class="card border-top-kirana shadow h-100 py-2">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
            </div>
          </div>
            <div class="row">
              <div class="col-sm-3">
                <div class="form-group">
                  <form action="<?= base_url('kunjungan/tambahhasil'); ?>" method="post" id="form_tancana">
                  <label><strong>Staff</strong></label>
                  <select class="form-control custom-select select2" name="id_staff" id="id_staff_hasil" data-placeholder="Pilih Staff" data-multiple="false">
                    <option value="">Pilih  Staff</option>     

                      <?php $old = null; ?>
                      <?php foreach ($tampilstaff as $row3): ?>
                        <?php if ($row3['fullname']!=$old) : ?>
                        <option value="<?= $row3['id'] ?>" <?php echo set_select('id_staff',$row3['id']); ?>><?= $row3['fullname'] ?></option>
                        <?php $old = $row3['fullname'] ?>
                        <?php else: endif; ?>
                      <?php endforeach; ?>    

                  </select>
                </div>
              </div>
              
              <div class="col-sm-3">
                <div class="form-group">
                  <label><strong>Periode</strong></label>
                  <p><input type="text" name="tgl_kunjungan" class="form-control" id="tgl_kunjungan_hasil" placeholder="<?= date('d/m/Y') ?>"><i class="fas fa-calendar-alt txt-kirana" style="font-size: 20px; position: absolute; right: 0; margin-top: -29px; margin-right: 22px;" value="<?= set_value('tgl_kunjungan'); ?>"></i></p>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-12">
                <small class="form-text text-danger"><?= form_error('tgl_lahir'); ?></small>    
                <table class="table table-bordered" id="tabel_tampil_hasil">
                  <thead class="bar-table">
                    <th>No</th>
                    <th>Tanggal Rencana</th>
                    <th>&nbsp;</th>
                    <th>Aktual Kunjungan</th>
                    <th>Nama Mitra</th>
                    <th>Hasil Kunjungan</th>
                    <th>Periode Tanam</th>
                    <th>Action</th>
                  </thead>
                 <tbody id="tbodyid">
                    <tr>
                      <td colspan="7">Silahkan pilih nama staff dan tanggal kunjungan terlebih dahulu.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- Modal -->
  <div class="modal fade" id="modalKunjungan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Tambah Hasil Kunjungan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body rencana_kunjungan">
      
        <div class="form-group">
          <label for="tgl_kunjungan_input"><strong>Tanggal Kunjungan :</strong></label>
          <input type="text" name="tgl_kunjungan_modal" id="tgl_kunjungan_input" class="form-control" readonly value="">
        </div>

        <input type="hidden" name="periode" id="periode">
        <input type="hidden" name="tgl_mulai" id="tgl_mulai">
        <input type="hidden" name="tgl_akhir" id="tgl_akhir">

        <div class="form-group tipe_wrapper">
            <label for="tipe_kunjungan"><strong>Tipe Kunjungan :</strong></label>
            <select class="form-control custom-select" name="tipe_kunjungan" id="tipe_kunjungan">
              <option value="">Pilih Tipe Kunjungan</option>
              <?php foreach($tipekun as $row2): ?>
                <option value="<?= $row2['id'] ?>"><?= $row2['tipe_kunjungan'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

        <div class="form-group">
            <label for="id_poktan"><strong>Poktan :</strong></label><br>  
            <select class="form-control custom-select select2" name="id_poktan" id="id_poktan" data-placeholder="Pilih Poktan" data-multiple="false" style="width: 100%">
               
            </select>
          </div>
          <input type="hidden" name="id_poktan_tanam" id="id_poktan_tanam" value="" class="form-control">
          <input type="hidden" name="alamat" id="alamat_edit" value="" class="form-control">

        <div class="form-group">
          <label for="aktual_kunjungan_input"><strong>Aktual Kunjungan :</strong></label>
          <input type="text" name="aktual_kunjungan_modal" id="aktual_kunjungan_input" class="form-control" placeholder="<?= date('d-m-Y') ?>" value="">
        </div>

      <div class="form-group">
        <label for="hasil_kunjungan"><strong>Hasil Kunjungan :</strong></label>
        <textarea class="form-control" rows="5" name="hasil_kunjungan" id="hasil_kunjungan"></textarea>
      </div>
    <input type="hidden" name="id2" id="id2">
  </div>
     <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="submit" id="btn-tambah" class="btn btn-kirana" onclick="check()">Tambah</button>
      <button type="submit" id="btn-tambah-hasil" class="btn btn-kirana">Tambah Hasil</button>
      <button type="submit" id="btn-edit" class="btn btn-kirana">Edit</button>
      </form>
     </div>
    </div>
   </div>
  </div>

<!-- Akhir Modal -->
</div>

<!-- JS HASIL KUNJUNGAN -->
<script src="<?= base_url(); ?>assets/js/script_hasilkunjungan.js"></script>
<!-- AKHIR JS HASIL KUNJUNGAN -->
