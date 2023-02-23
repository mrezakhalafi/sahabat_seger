<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
 
  <div class="row">
    <div class="col-lg-8">
       <h1 class="h3 text-gray-800" style="margin-bottom: 17px;"><?= $title; ?></h1>
          <div class="card border-top-kirana shadow py-2">
          <div class="card-body">
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
      <table class="table table-striped table-responsive shadow" id="tb_dokpoktan">
        <thead>
          <tr class="bar-table">
            <th>No</th>
            <th scope="col">Poktan</th>
            <th scope="col">Jenis Dokumen</th>
            <th scope="col">Location</th>
            <th scope="col">File Poktan</th>
            <th scope="col">Aktif</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach ($dokpoktan as $row) :?>
        <tr>
          <td><?= $i; ?></td>
          <td class="min-width-150"><?= $row['nama_poktan']; ?></td>
          <td class="min-width-150"><?= $row['jns_dokumen']; ?></td>
          <td class="min-width-120"><?= $row['location']; ?></td>
          <td class="min-width-120"><a href="<?= base_url().$row['location'] ?>" target="_blank"><?=$row['file_poktan']?></a></td>
          <td>
            <?php if($row['aktif'] == 1): ?>
              <i class="fas fa-check-circle icon-check"></i>
            <?php else: ?>
              <i class="fas fa-times-circle icon-uncheck"></i>
            <?php endif; ?>
          </td>
          <td class="min-width-btn text-center">
            <button class="btn btn-success btn-sm btn-ubah" id="btn-ubah" type="button" onclick="pilihDataDokpok('<?= $row['id']; ?>');">Edit</button> 
            <?php if($row['aktif'] == 1): ?>
              <a class="tombol-hapus" href="<?= base_url('dokpoktan/delete') ?>/<?=$row['id']?>"><button class="btn btn-danger btn-sm">Delete</button></a>
            <?php else: ?>
              <a href="<?= base_url('dokpoktan/aktif') ?>/<?=$row['id']?>"><button class="btn btn-primary min-width-btn-59 btn-sm">Aktif</button></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php $i++ ;?>
        <?php endforeach ;?>
      </tbody>
  </table>
          </div>
          </div>
      
</div>

        <div class="col-lg-4">
          <div class="card shadow" style="background-color: #f8f9fc">
           <div class="card-header m-0 font-weight-bold txt-kirana">
            <span id="txt-tambah-dokpoktan">Tambah Data Dokumen Poktan</span>
            <span id="txt-ubah-dokpoktan">Ubah Data Dokumen Poktan</span>
          </div>
          <div class="card border-top-kirana shadow h-100 py-2">
            <div class="card-body">
            
             <form id="ubah_form_dokpoktan" action="<?= base_url('dokpoktan/tambah') ?>" method="post" enctype="multipart/form-data">       
             <input type="hidden" name="id_poktan" value="" id="id_poktan_hidden">
           
            <div id="poktan_awal">
              <label>Poktan : </label>
              <div class="form-group">
               <select name="id_poktan" id="id_poktan_dok" class="form-control custom-select select2" data-placeholder="Pilih Poktan" data-multiple="false">
                <option value="">Pilih Poktan</option>
                   <?php if(isset($poktan)): ?>
                       <?php   foreach($poktan as $row): ?>
                           <option value="<?= $row->id ?>" <?php echo set_select('id_poktan',$row->id); ?>><?= $row->nama_poktan ?></option>
                       <?php   endforeach; ?>
                   <?php endif; ?>
                </select>
                <small class="form-text text-danger"><?= form_error('id_poktan'); ?></small>
             </div>
           </div>

           <div id="poktan_akhir">
              <label>Poktan : </label>
               <div class="form-group">
                <input type="text" class="form-control" value="" id="id_poktan2">
              </div>
            </div>

              <!-- AWAL DOKUMEN -->
            <input type="hidden" name="id_jns_dok" value="" id="id_jns_dok_hidden">
            <div id="jns_dokumen_awal">
              <label>Jenis Dokumen : </label>
               <div class="form-group">
                 <select class="form-control custom-select select2" name="id_jns_dok" id="id_jns_dok" data-placeholder="Pilih Jenis Dokumen" data-multiple="false">
                   <option value="">Pilih Jenis Dokumen</option>
                      <?php foreach($jns_dok as $row2) : ?>                   
                        <option value="<?= $row2['id']; ?>" <?php echo set_select('id_jns_dok',$row2['id']);?>><?= $row2['jns_dokumen']; ?></option>
                      <?php endforeach; ?>
                </select>
                <small class="form-text text-danger"><?= form_error('id_jns_dok'); ?></small>
              </div>
            </div>

            <div id="jns_dokumen_akhir">
              <label>Jenis Dokumen : </label>
               <div class="form-group">
                  <input type="text" class="form-control" value="" id="id_jns_dok2">
              </div>
            </div>
          <!-- AKHIR DOKUMEN -->

            <div class="form-group0" style="padding: 0">
                <div class="row">
                  <div class="col">
                    <label for="dok_mou"><strong>File :</strong></label>
                  </div>
                </div>
              
              <div class="row">
                <div class="col">
                  <div class="upload-btn-wrapper">
                    <button class="upload">Upload a file</button><div id="txt_upload" style="display: inline;"> <small>No file uploaded.</small>
                  </div>
                  <input type="file" name="file_dokpoktan" id="file_dokpoktan">  
                </div>
                <small class="form-text text-danger"><?= form_error('file_dokpoktan'); ?></small>
              </div>
            </div>  
          <small>Dokumen harus berupa format PDF, JPG, PNG, file maksimal 2 MB</small><br><br>
        </div>

         <input class="form-control" id="in_date" type="hidden" name="in_date" value="<?= date("Y-m-d h:i:s") ?>">
         <input class="form-control" id="in_by" type="hidden" name="in_by" value="<?= $user['id']; ?>">
         <input class="form-control" id="edit_date" type="hidden" name="edit_date" value="<?= date("Y-m-d h:i:s") ?>">
         <input class="form-control" id="edit_by" type="hidden" name="edit_by" value="<?= $user['id']; ?>">

        <div class="status_dokpoktan">
         <label>Status : </label>
          <div class="form-group">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="aktif" name="aktif" class="custom-control-input" value="1">
              <label class="custom-control-label" for="aktif">Aktif</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="nonaktif" name="aktif" class="custom-control-input" value="2">
              <label class="custom-control-label" for="nonaktif">Tidak Aktif</label>
              <br><br>
            </div>
          </div>
        </div>              

          <input type="hidden" id="id2" name="id2" value="">
          <button type="submit" id="ubahdokpoktan" class="float-right btn btn-kirana">Ubah Dokumen Poktan</button>
          <button type="button" id="canceldokpoktan" class="float-right btn btn-danger mr-2">Cancel</button>       
          <button type="submit" id="tambahdokpoktan" class="float-right btn btn-kirana">Tambah Dokumen Poktan</button>
               
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- JS DOKPOKTAN -->
<script src="<?= base_url(); ?>assets/js/script_dokpoktan.js"></script>
<!-- AKHIR JS DOKPOKTAN -->
