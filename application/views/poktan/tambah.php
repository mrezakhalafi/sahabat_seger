<!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
      <div class="col-lg-12" style="padding: 0">
        <?= $this->session->flashdata('message'); ?>
        <div class="card shadow">
          <div class="card-header m-0 font-weight-bold txt-kirana">
            Tambah Data Poktan
          </div>
            <div class="card-body">
              <div class="col-lg-12">
                <div class="card border-top-kirana shadow h-100 py-2">
                  <div class="card-body" style="padding-bottom: 10px;">
                    <div class="row">
                      <div class="col-lg-6">
                        <form action="<?= base_url('poktan/tambah') ?>" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                           <label><strong>Nama Poktan : </strong></label>
                             <input class="form-control" type="text" id="nama_poktan" name="nama_poktan" value="<?= set_value('nama_poktan'); ?>">
                            <small class="form-text text-danger"><?= form_error('nama_poktan'); ?></small>
                          </div>                
                          <div class="form-group">
                           <label><strong>Alamat : </strong></label>
                             <input class="form-control" type="text" id="alamat" name="alamat" value="<?= set_value('alamat'); ?>">
                            <small class="form-text text-danger"><?= form_error('alamat'); ?></small>
                          </div>              
                          <div class="form-group">
                           <label><strong>Email : </strong></label>
                             <input class="form-control" type="text" id="email" name="email" value="<?= set_value('email'); ?>">
                            <small class="form-text text-danger"><?= form_error('email'); ?></small>
                          </div>     
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label for="id_staff"><strong>Staff :</strong></label>
                                  <select name="id_staff" class="form-control custom-select select2" data-placeholder="Pilih Staff" data-multiple="false">
                                    <option value="">Pilih Staff</option>

                                    <?php $old = null; ?>
                                      <?php foreach ($staff as $row): ?>
                                        <?php if ($row['fullname']!=$old) : ?>
                                        <option value="<?= $row['id'] ?>" <?php echo set_select('id_staff',$row['id']); ?>><?= $row['fullname'] ?></option>
                                        <?php $old = $row['fullname'] ?>
                                        <?php else: endif; ?>
                                      <?php endforeach; ?>
                                      
                                    </select>
                                   <small class="form-text text-danger"><?= form_error('id_staff'); ?></small>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label for="id_jenis_mitra"><strong>Jenis Mitra :</strong></label>
                                    <select name="id_jenis_mitra" class="form-control custom-select select2" data-placeholder="Pilih Mitra" data-multiple="false">
                                      <option value="">Pilih Mitra</option>
                                        <?php foreach ($mitra as $row3): ?>
                                          <option value="<?= $row3['id'] ?>" <?php echo set_select('id_jenis_mitra',$row3['id']); ?>><?= $row3['jenis_mitra'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                  <small class="form-text text-danger"><?= form_error('id_jenis_mitra'); ?></small>
                                </div>
                              </div>
                              <div class="col">
                                <div class="form-group">
                                  <label for="id_komuditi"><strong>Komuditi :</strong></label>
                                    <select name="id_komuditi" class="form-control custom-select select2" data-placeholder="Pilih Komuditi" data-multiple="false">
                                      <option value="">Pilih Komuditi</option>
                                        <?php foreach ($komuditi as $row4): ?>
                                          <option value="<?= $row4['id'] ?>" <?php echo set_select('id_komuditi',$row4['id']); ?>><?= $row4['nama_komuditi'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                  <small class="form-text text-danger"><?= form_error('id_komuditi'); ?></small>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label><strong>Ketua : </strong></label>
                               <input class="form-control" type="text" id="ketua" name="ketua" value="<?= set_value('ketua'); ?>">
                                <small class="form-text text-danger"><?= form_error('ketua'); ?></small>
                            </div>              
                            <div class="form-group">
                              <label><strong>Sekretaris : </strong></label>
                               <input class="form-control" type="text" id="sekretaris" name="sekretaris" value="<?= set_value('sekretaris'); ?>">
                                <small class="form-text text-danger"><?= form_error('sekretaris'); ?></small>
                            </div>              
                            <div class="form-group">
                              <label><strong>Bandahara : </strong></label>
                                <input class="form-control" type="text" id="bendahara" name="bendahara" value="<?= set_value('bendahara'); ?>">
                              <small class="form-text text-danger"><?= form_error('bendahara'); ?></small>
                            </div>   
                          </div>
                          <div class="col-lg-6">
                            <div class="row">
                              <div class="col">
                                <div class="form-group">
                                  <label for="id_prov"><strong>Provinsi :</strong></label>
                                    <select name="id_provinsi" id="id_prov" class="form-control custom-select action_wilayah select2" data-placeholder="Pilih Provinsi" data-multiple="false">
                                        <option value="">Pilih Provinsi</option>
                                        <?php foreach ($prov as $row5): ?>
                                          <option value="<?= $row5['id'] ?>" <?php echo set_select('id_provinsi',$row5['id']); ?> >   <?= $row5['nama_prov'] ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    <small class="form-text text-danger"><?= form_error('id_provinsi'); ?></small>
                                  </div>
                                </div>
                              <div class="col">
                                <div class="form-group">
                                  <label for="id_kab"><strong>Kabupaten :</strong></label>
                                    <select name="id_kabupaten"  id="id_kab"  class="form-control custom-select action_wilayah select2" data-placeholder="Pilih Kabupaten" data-multiple="false">
                                      <option value="">Pilih Kabupaten</option>
                                        <?php foreach ($kab as $row6): ?>
                                          <option value="<?= $row6['id'] ?>" <?php echo set_select('id_kabupaten',$row6['id']); ?> > <?= $row6['nama_kab'] ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                    <small class="form-text text-danger"><?= form_error('id_kabupaten'); ?></small>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <label for="id_kec"><strong>Kecamatan :</strong></label>
                                      <select name="id_kecamatan"  id="id_kec" class="form-control action_wilayah custom-select select2" data-placeholder="Pilih Kecamatan" data-multiple="false">
                                        <option value="">Pilih Kecamatan</option>
                                          <?php foreach ($kec as $row7): ?>
                                            <option value="<?= $row7['id'] ?>" <?php echo set_select('id_kecamatan',$row7['id']); ?> > <?= $row7['nama_kec'] ?></option>
                                          <?php endforeach; ?>
                                          </select>
                                      <small class="form-text text-danger"><?= form_error('id_kecamatan'); ?></small>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="form-group">
                                      <label for="id_desa"><strong>Desa :</strong></label>
                                        <select name="id_desa"  id="id_desa" class="form-control custom-select action_wilayah select2" data-placeholder="Pilih Desa" data-multiple="false">
                                          <option value="">Pilih Desa</option>
                                            <?php foreach ($desa as $row8): ?>
                                              <option value="<?= $row8['id'] ?>" <?php echo set_select('id_desa',$row8['id']); ?> > <?= $row8['nama_desa'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                      <small class="form-text text-danger"><?= form_error('id_desa'); ?></small>
                                    </div>
                                  </div>
                                </div>
                                <div class="row"> 
                                  <div class="col">      
                                    <div class="form-group">
                                      <label><strong>Rekening Bank : </strong></label>
                                        <select class="form-control custom-select select2" name="rek_bank" id="rek_bank" data-placeholder="Pilih Rekening Bank" data-multiple="false">
                                          <option value="">Pilih Rekening Bank</option>
                                            <?php foreach ($bank as $row5): ?>
                                              <option value="<?= $row5['id'] ?>" <?php echo set_select('rek_bank',$row5['id']); ?>><?= $row5['nama_bank'] ?></option>
                                          <?php endforeach; ?>
                                        </select>
                                      <small class="form-text text-danger"><?= form_error('rek_bank'); ?></small>
                                    </div> 
                                  </div> 
                                  <div class="col">             
                                    <div class="form-group">
                                     <label><strong>Rekening Cabang : </strong></label>
                                       <input class="form-control" type="text" id="rek_cabang" name="rek_cabang" value="<?= set_value('rek_cabang'); ?>">
                                      <small class="form-text text-danger"><?= form_error('rek_cabang'); ?></small>
                                    </div>
                                  </div>
                                </div>               
                                <div class="form-group">
                                 <label><strong>Nama Rekening : </strong></label>
                                   <input class="form-control" type="text" id="rek_nama" name="rek_nama" value="<?= set_value('rek_nama'); ?>">
                                  <small class="form-text text-danger"><?= form_error('rek_nama'); ?></small>
                                </div>              
                                <div class="form-group">
                                 <label><strong>No. Rekening : </strong></label>
                                   <input class="form-control" type="text" id="rek_no" name="rek_no" value="<?= set_value('rek_no'); ?>">
                                  <small class="form-text text-danger"><?= form_error('rek_no'); ?></small>
                                </div>              
                                <div class="form-group">
                                  <label for="tlp"><strong>Telepon :</strong></label>
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">+62</div>
                                      </div>
                                      <input type="text" name="tlp" class="form-control" id="tlp" value="<?= set_value('tlp'); ?>">
                                    </div>
                                   <small class="form-text text-danger"><?= form_error('tlp'); ?></small>
                                </div>   
                                <input class="form-control" id="in_date" type="hidden" name="in_date" value="<?= date("Y-m-d h:i:s") ?>">
                                <input class="form-control" id="in_by" type="hidden" name="in_by" value="<?= $user['id']; ?>">
                                <input class="form-control" id="edit_date" type="hidden" name="edit_date" value="<?= date("Y-m-d h:i:s") ?>">
                                <input class="form-control" id="edit_by" type="hidden" name="edit_by" value="<?= $user['id']; ?>">

                               </div>

                                  </div>
                                  <button type="submit" class="btn btn-kirana float-right ml-2">Tambah Data</button>
                            <a href="<?= base_url('poktan'); ?>"><button type="button" class="btn btn-danger float-right">Cancel</button></a>
                                </div>
                              </div>
                              
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            

<!-- JS POKTAN -->
<script src="<?= base_url(); ?>assets/js/script_poktan.js"></script>
<!-- AKHIR JS POKTAN -->