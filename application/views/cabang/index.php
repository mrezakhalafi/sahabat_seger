<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-lg-8">
      <h1 class="h3 text-gray-800" style="margin-bottom: 17px;"><?= $title; ?></h1>
      <div class="card border-top-kirana shadow py-2">
        <div class="card-body">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
          <table id="cabang" class="table table-striped table-responsive shadow">
            <thead class="bar-table">
              <th>No</th>
              <th>Kode Cabang</th>
              <th>Nama Cabang</th>
              <th>Nama Plant</th>
              <th>Provinsi</th>
              <th>Kabupaten</th>
              <th>Status</th>
              <th>Action</th>
            </thead>
            <tbody>
            <?php $i =1; ?>
            <?php foreach ($tampil as $row): ?>
                <tr>
                  <td><?= $i; ?></td>
                  <td class="min-width-120"><?= $row['kode_cabang']?></td>
                  <td class="min-width-150"><?= $row['nama_cabang']?></td>
                  <td class="min-width-120"><?= $row['nama_plant']?></td>
                  <td class="min-width-120"><?= $row['nama_prov']?></td>
                  <td class="min-width-120"><?= $row['nama_kab']?></td>
                  <td class="min-width-120 text-center">
                  <?php if($row['aktif'] == 1): ?>
                    <i class="fas fa-check-circle icon-check"></i>
                  <?php else: ?>
                    <i class="fas fa-times-circle icon-uncheck"></i>
                  <?php endif; ?>
                  </td>

                  <td class="min-width-btn text-center"><button class="btn btn-success btn-sm" onclick="pilihdataCabang('<?= $row['id']; ?>');">Edit</button> 
                    <?php if($row['aktif'] == 1): ?>
                      <a class="tombol-hapus" href="<?= base_url('cabang/delete') ?>/<?=$row['id']?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                    <?php else: ?>
                      <a href="<?= base_url('cabang/aktif') ?>/<?=$row['id']?>"><button class="btn btn-primary min-width-btn-59 btn-sm">Aktif</button></a>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php $i ++; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      

      </div>
        <div class="col-lg-4">
          <div class="card shadow" style="background-color: #f8f9fc">

            <div class="card-header m-0 font-weight-bold txt-kirana">
                <span id="txt-tambah-cabang">Tambah Data Cabang</span>
                <span id="txt-ubah-cabang">Ubah Data Cabang</span>
            </div>
            <div class="card border-top-kirana shadow h-100 py-2">
            <div class="card-body">
         
            <form action="<?= base_url('cabang/tambahCabang') ?>" method="post" id="ubah_form_cabang">

            <div class="form-group">
              <label for="id_plant">Plant :</label>

              <select class="form-control custom-select select2" name="id_plant" id="id_plant" data-placeholder="Pilih Plant" data-multiple="false">
                <option value="">Pilih  Plant</option>
                
                <?php
                foreach ($plant as $row): ?>
                
                <option value="<?= $row['id'] ?>" <?php echo set_select('id_plant',$row['id']); ?>><?= $row['nama_plant'] ?></option>
                
                <?php endforeach; ?>
                
              </select>
              <small class="form-text text-danger"><?= form_error('id_plant'); ?></small>
            </div>

            <div class="form-group">
              <label for="kode_cabang">Kode Cabang :</label>
                <input type="text" name="kode_cabang" class="form-control" id="kode_cabang" value="<?= set_value('kode_cabang'); ?>">
               <small class="form-text text-danger"><?= form_error('kode_cabang'); ?></small>
            </div>

            <div class="form-group">
              <label for="nama_cabang">Nama Cabang :</label>
                <input type="text" name="nama_cabang" class="form-control" id="nama_cabang" value="<?= set_value('nama_cabang'); ?>">
               <small class="form-text text-danger"><?= form_error('nama_cabang'); ?></small>
            </div>

            <div class="form-group">
              <label for="id_prov">Provinsi :</label>

            <select class="form-control custom-select action_wilayah select2" name="id_prov" id="id_prov" data-placeholder="Pilih Provinsi" data-multiple="false">
              <option value="">Pilih  Provinsi</option>
              
              <?php
              foreach ($prov as $row): ?>
                
              <option value="<?= $row['id'] ?>" <?php echo set_select('id_prov',$row['id']); ?>><?= $row['nama_prov'] ?></option>
              
              <?php endforeach; ?>
            </select>
             
            <small class="form-text text-danger"><?= form_error('id_prov'); ?></small>
          </div>

          <div class="form-group">
            <label for="id_kab">Kabupaten :</label>
            <select class="form-control custom-select select2" name="id_kab" id="id_kab" data-placeholder="Pilih Kabupaten" data-multiple="false">
              <option value="">Pilih  Kabupaten</option>
              
              <?php
              foreach ($kab as $row2): ?>
                
              <option value="<?= $row2['id'] ?>" <?php echo set_select('id_kab',$row2['id']); ?> > <?= $row2['nama_kab'] ?></option>
            
              <?php endforeach; ?>
            </select>
          <small class="form-text text-danger"><?= form_error('id_kab'); ?></small>
          </div>
          
          <input type="hidden" name="id2" id="id2">

          <div class="status_cabang">
          <label>Status : </label>
          <div class="form-group">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="aktif" id="aktif" name="aktif" class="custom-control-input" value="1">
              <label class="custom-control-label" for="aktif">Aktif</label>
            </div>

          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="nonaktif" name="aktif" class="custom-control-input" value="2">
            <label class="custom-control-label" for="nonaktif">Tidak Aktif</label>
          </div>
        </div>
     </div>
          <button type="submit" id="ubahcabang" class="float-right btn btn-kirana">Ubah Data</button>
          <button type="button" id="cancelcabang" class="float-right btn btn-danger mr-2">Cancel</button>
          <button type="submit" id="tambahcabang" name="tambah" class="btn btn-kirana float-right">Tambah Data</button>
        </form>                  
      </div>
    </div>
  </div>
</div>
 <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
</div>
</div>
<!-- JS CABANG -->
<script src="<?= base_url(); ?>assets/js/script_cabang.js"></script>
<!-- AKHIR JS CABANG -->

       