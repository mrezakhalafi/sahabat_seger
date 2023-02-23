<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
  <div class="row">
              
  </div>
  <div class="row">
    <div class="col-lg-8">
      <h1 class="h3 text-gray-800" style="margin-bottom: 17px;"><?= $title; ?></h1>
      <div class="card border-top-kirana shadow py-2">
        <div class="card-body">
          <div class="col-4 p-0">
      <div class="form-group">
        <label><strong>Plant</strong></label>
        <select class="form-control custom-select select2" id="id_plant_cabang_poktanam" name="id_plant_cabang[]" data-placeholder="Pilih Plant" data-multiple="true" multiple>
        <!-- <option value="">Pilih Plant</option> -->
        <?php foreach ($cabang as $row1): ?>
 
          <option value="<?php echo $row1['id'] ?>"><?php echo $row1['nama_cabang'] ?></option>
        <?php endforeach; ?>

                                
        </select>
      </div>
    </div>
      <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
      <table id="lahan" class="table table-striped table-responsive shadow">
        <thead class="bar-table">
          <th>No</th>
          <th class="min-width-120">Nama Lahan</th>
          <th>Luas</th>
          <th>Kepemilikan</th>
          <th>Poktan</th>
          <th>Petani</th>
          <th>Plant</th>
          <th>Provinsi</th>
          <th>Kabupaten</th>
          <th>Kecamatan</th>
          <th>Desa</th>
          <th>Aktif</th>
          <th>Action</th>
        </thead>
        <tbody>
        <?php $i =1; ?>
        <?php foreach ($tampil as $row): ?>
          <tr>
            <td><?= $i; ?></td>
            <td class="min-width-120"><?= $row['nama_lahan']?></td>
            <td><?= $row['luas']?></td>
            <td><?= $row['kepemilikan']?></td>
            <td class="min-width-120"><?= $row['nama_poktan']?></td>
            <td class="min-width-150"><?= $row['nama_petani']?></td>
            <td class="min-width-120">
                    <?php foreach($tampil2 as $row2) : ?>
                    <?php if($row2['id_user'] == $row['id_staff']) : ?>
                    <?= $row2['nama_cabang']?><br/>
                    
                  <?php endif; endforeach; ?></td>  
            <td class="min-width-120"><?= $row['nama_prov']?></td>
            <td class="min-width-120"><?= $row['nama_kab']?></td>
            <td class="min-width-120"><?= $row['nama_kec']?></td>
            <td class="min-width-120"><?= $row['nama_desa']?></td>
            <td>
              <?php if($row['aktif'] == 1): ?>
                <i class="fas fa-check-circle icon-check"></i>
              <?php else: ?>
                <i class="fas fa-times-circle icon-uncheck"></i>
              <?php endif; ?>
            </td>
            <td class="min-width-btn text-center"><button class="btn btn-success btn-sm" onclick="pilihdataLahan('<?= $row['id']; ?>');">Edit</button> 
              <?php if($row['aktif'] == 1) :?>
                <a class="tombol-hapus" href="<?= base_url('lahan/delete') ?>/<?=$row['id']?>"><button class="btn btn-danger btn-sm">Delete</button></a>
              <?php else: ?>
                <a class="" href="<?= base_url('lahan/aktif') ?>/<?=$row['id']?>"><button class="btn min-width-btn-59 btn-primary btn-sm">Aktif</button></a>
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
     <span id="txt-tambah-lahan">Tambah Data Lahan</span>
     <span id="txt-ubah-lahan">Ubah Data Lahan</span>
    </div>
  <div class="card border-top-kirana shadow h-100 py-2">
  <div class="card-body">

     
    <form action="<?= base_url('lahan/tambah') ?>" method="post" enctype="multipart/form-data" id="ubah_form_lahan">

    <div class="form-group">
      <label for="id_poktan">Poktan :</label>
      <select class="form-control custom-select sort select2" data-placeholder="Pilih Poktan" data-multiple="false"  name="id_poktan" id="id_poktan_lahan">
        <option value="">Pilih  Poktan</option>
        
        <?php foreach ($poktan as $row): ?>
         <option value="<?= $row->id ?>" <?php echo set_select('id_poktan',$row->id); ?>><?= $row->nama_poktan ?></option>
        <?php endforeach; ?>
      </select>
      <small class="form-text text-danger"><?= form_error('id_poktan'); ?></small>
    </div>


    <div class="form-group">
      <label for="id_petani">Petani :</label>
      <select class="form-control custom-select select2" data-placeholder="Pilih Petani" data-multiple="false" name="id_petani" id="id_petani">
        <option value="">Pilih  Petani</option>


        </select>
        <small class="form-text text-danger"><?= form_error('id_petani'); ?></small>
      </div>

      <div class="form-group">
        <label for="id_poktan">Provinsi :</label>
        <select class="form-control action_wilayah custom-select select2" name="id_prov" id="id_prov"  data-placeholder="Pilih Provinsi" data-multiple="false">
          <option value="">Pilih Provinsi</option>
          
          <?php foreach ($prov as $row3): ?>  
          <option value="<?= $row3['id'] ?>" <?php echo set_select('id_prov',$row3['id']); ?>><?= $row3['nama_prov'] ?>
          </option>
          <?php endforeach; ?>
        </select>
        <small class="form-text text-danger"><?= form_error('id_prov'); ?></small>
      </div>   

      <div class="form-group">
        <label for="id_poktan">Kabupaten :</label>
        <select class="form-control action_wilayah custom-select select2" name="id_kab" id="id_kab"  data-placeholder="Pilih Kabupaten" data-multiple="false">
          <option value="">Pilih Kabupaten</option>
           <?php foreach ($kab as $row4): ?>
            <option value="<?= $row4['id'] ?>" <?php echo set_select('id_kab',$row4['id']); ?>><?= $row4['nama_kab'] ?>
            </option>
          <?php endforeach; ?>
        </select>
        <small class="form-text text-danger"><?= form_error('id_kab'); ?></small>
      </div>   

      <div class="form-group">
        <label for="id_poktan">Kecamatan :</label>
        <select class="form-control action_wilayah custom-select select2" name="id_kec" id="id_kec"  data-placeholder="Pilih Kecamatan" data-multiple="false">
          <option value="">Pilih  Kecamatan</option>
          <?php foreach ($kec as $row5): ?>        
           <option value="<?= $row5['id'] ?>" <?php echo set_select('id_kec',$row5['id']); ?>><?= $row5['nama_kec'] ?>
           </option>
          <?php endforeach; ?>
        </select>
        <small class="form-text text-danger"><?= form_error('id_kec'); ?></small>
      </div>   

      <div class="form-group">
        <label for="id_poktan">Desa :</label>
        <select class="form-control action_wilayah custom-select select2" name="id_desa" id="id_desa"  data-placeholder="Pilih Desa" data-multiple="false">
          <option value="">Pilih  Desa</option>
            <?php foreach ($desa as $row6): ?>
             <option value="<?= $row6['id'] ?>" <?php echo set_select('id_desa',$row6['id']); ?>><?= $row6['nama_desa'] ?></option>
            <?php endforeach; ?>
        </select>
        <small class="form-text text-danger"><?= form_error('id_desa'); ?></small>
      </div>   

      <div class="form-group">
        <label for="nama_lahan">Nama Lahan :</label>
        <input type="text" name="nama_lahan" class="form-control" id="nama_lahan" value="<?= set_value('nama_lahan'); ?>">
        <small class="form-text text-danger"><?= form_error('nama_lahan'); ?></small>
      </div>

      <div class="form-group">
        <label for="luas">Luas :</label>
        <input type="text" name="luas" class="form-control" id="luas" value="<?= set_value('luas'); ?>">
        <small class="form-text text-danger"><?= form_error('luas'); ?></small>
        <small>Input berupa desimal</small>
      </div>

     <div class="form-group">
      <label for="kepemilikan">Kepemilikan :</label>
      <select class="form-control custom-select select2" name="kepemilikan" id="kepemilikan" data-placeholder="Pilih Jenis Kepemilikan" data-multiple="false">
          <option value="">Pilih  Jenis Kepemilikan</option>
          <option value="SHM" <?php echo set_select('kepemilikan','SHM'); ?>>SHM - Sertifikat Hak Milik</option>
          <option value="SHGB" <?php echo set_select('kepemilikan','SHGB'); ?>>SHGB - Sertifikat Hak Guna Bangunan</option>
          <option value="SHGU" <?php echo set_select('kepemilikan','SHGU'); ?>>SHGU - Sertifikat Hak Guna Usaha</option>
          <option value="HP" <?php echo set_select('kepemilikan','HP'); ?>>HP - Hak Pakai</option>
        </select>
        <small class="form-text text-danger"><?= form_error('kepemilikan'); ?></small>
      </div>

         <input type="hidden" name="in_date" class="form-control" id="in_date" value="<?= date("Y-m-d h:i:s") ?>">
         <input type="hidden" name="in_by" class="form-control" id="in_by" value="<?= $user['id']; ?>">
         <input type="hidden" name="edit_date" class="form-control" id="edit_date" value="<?= date("Y-m-d h:i:s") ?>">
         <input type="hidden" name="edit_by" class="form-control" id="edit_by" value="<?= $user['id']; ?>">
         <input type="hidden" name="id2" id="id2">

        <div class="status_lahan">
         <label>Status : </label>
          <div class="form-group">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="aktif" name="aktif" class="custom-control-input" value="1" checked>
              <label class="custom-control-label" for="aktif">Aktif</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="nonaktif" name="aktif" class="custom-control-input" value="2">
              <label class="custom-control-label" for="nonaktif">Tidak Aktif</label>
            </div>
          </div>
         </div>

          <button type="submit" id="ubahlahan" class="float-right btn btn-kirana">Ubah Data</button>
          <button type="button" id="cancellahan" class="float-right btn btn-danger mr-2">Cancel</button>
          <button type="submit" id="tambahlahan" name="tambah" class="btn btn-kirana float-right">Tambah Data</button>
        </form>       
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
</div>
</div>
<!-- End of Main Content -->

<!-- JS LAHAN -->
<script src="<?= base_url(); ?>assets/js/script_lahan.js"></script>
<!-- AKHIR JS LAHAN -->

