<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="row">
    <div class="col-lg-8">
      <h1 class="h3 text-gray-800" style="margin-bottom: 17px;"><?= $title; ?></h1>
        <div class="card border-top-kirana shadow py-2">
          <div class="card-body">
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
            <table id="plant" class="table table-striped table-responsive shadow">
              <thead class="bar-table">
                <th>No</th>
                <th>Kode Plant</th>
                <th>Nama Plant</th>
                <th>Region</th>
                <th>Aktif</th>
                <th>Action</th>
              </thead>
              <tbody>
                <?php $i =1; ?>
                <?php foreach ($tampil as $row): ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td class="min-width-120"><?= $row['kode_plant']?></td>
                    <td class="min-width-120"><?= $row['nama_plant']?></td>
                    <td class="min-width-120"><?= $row['nama_region']?></td>
                    <td class="min-width-120 text-center">
                      <?php if($row['aktif'] == 1): ?>
                       <i class="fas fa-check-circle icon-check"></i>
                       <?php else: ?>
                       <i class="fas fa-times-circle icon-uncheck"></i>
                      <?php endif; ?>
                    </td>
                   <td class="min-width-btn text-center"><button class="btn btn-success btn-sm" onclick="pilihdataPlant('<?= $row['id']; ?>');">Edit</button> 
                    <?php if($row['aktif'] == 1): ?>
                      <a class="tombol-hapus" href="<?= base_url('plant/delete') ?>/<?=$row['id']?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                    <?php else: ?>
                      <a class="" href="<?= base_url('plant/aktif') ?>/<?=$row['id']?>"><button class="btn btn-primary min-width-btn-59 btn-sm">Aktif</button></a>
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
       <span id="txt-tambah-plant">Tambah Data Plant</span>
      <span id="txt-ubah-plant">Ubah Data Plant</span>
    </div>
    <div class="card border-top-kirana shadow h-100 py-2">
      <div class="card-body">
     
        <form action="<?= base_url('plant/tambahPlant') ?>" method="post" id="ubah_form_plant">
        <div class="form-group">
          <label for="kode_plant">Kode Plant :</label>
            <input type="text" name="kode_plant" class="form-control" id="kode_plant" value="<?= set_value('kode_plant'); ?>">
           <small class="form-text text-danger"><?= form_error('kode_plant'); ?></small>
        </div>

        <div class="form-group">
          <label for="nama_plant">Nama Plant :</label>
            <input type="text" name="nama_plant" class="form-control" id="nama_plant" value="<?= set_value('nama_plant'); ?>">
           <small class="form-text text-danger"><?= form_error('nama_plant'); ?></small>
        </div>

        <div class="form-group">
          <label for="id_region">Region :</label>
          <select class="form-control custom-select select2" name="id_region" id="id_region" data-placeholder="Pilih Region" data-multiple="false">
            <option value="">Pilih  Region</option>
            <?php foreach ($region as $row): ?>
              <option value="<?= $row['id'] ?>" <?php echo set_select('id_region',$row['id']); ?>><?= $row['nama_region'] ?>
              </option>
            <?php endforeach; ?>
          </select>
          <small class="form-text text-danger"><?= form_error('id_region'); ?></small>
        </div>

        <input type="hidden" name="id2" id="id2">

        <div class="status_plant">
         <label>Status : </label>
         <div class="form-group">
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="aktif" id="aktif" name="aktif" class="custom-control-input" value="1">
            <label class="custom-control-label" for="aktif">Aktif</label>
          </div>

          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="nonaktif" name="aktif" class="custom-control-input" value="0">
            <label class="custom-control-label" for="nonaktif">Tidak Aktif</label>
          </div>
        </div>
       </div>

            <button type="submit" id="ubahplant" class="float-right btn btn-kirana">Ubah Data</button>
            <button type="button" id="cancelplant" class="float-right btn btn-danger mr-2">Cancel</button>
            <button type="submit" id="tambahplant" name="tambah" class="btn btn-kirana float-right">Tambah Data</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- JS PLANT -->
<script src="<?= base_url(); ?>assets/js/script_plant.js"></script>
<!-- AKHIR JS PLANT -->

     