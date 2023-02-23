<!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
      <div class="col-lg-12" style="padding: 0">
        <?= $this->session->flashdata('message'); ?>
          <div class="card shadow">
            <div class="card-header m-0 font-weight-bold txt-kirana">
              Tambah Data Poktan Tanam
            </div>
              <div class="card-body">
                <div class="col-lg-12">
                  <div class="card border-top-kirana shadow h-100 py-2">
                    <div class="card-body">
                      <form action="<?= base_url('poktantanam/tambah') ?>" method="post">
                        <div class="row">
                          <div class="col-lg-6">
                            <label><strong>Poktan : </strong></label>
                              <div class="form-group">
                                <select class="form-control custom-select sort select2" name="id_poktan" id="id_poktan_tanam" data-placeholder="Pilih Poktan" data-multiple="false">
                                  <option value="">Pilih Poktan</option>
                                    <?php 
                                      $tampung = "";
                                      foreach ($poktan as $row): ?>
                                      <?php
                                      if($tampung != $row->nama_poktan): ?>
                                      <option value="<?= $row->id ?>" <?php echo set_select('id_poktan',$row->id); ?>><?= $row->nama_poktan ?></option>
                                      <?php
                                      $tampung = $row->nama_poktan;
                                    endif; ?>
                                    <?php endforeach; ?>
                                  </select>
                                <small class="form-text text-danger"><?= form_error('id_poktan'); ?></small>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <label for="tgl_tanam"><strong>Tanggal Tanam :</strong></label>
                                      <input type="text" name="tgl_tanam" placeholder="<?=date('d/m/Y')?>" class="form-control" id="tgl_tanam" value="<?= set_value('tgl_tanam'); ?>">
                                      <small class="form-text text-danger"><?= form_error('tgl_tanam'); ?></small>
                                  </div>
                                </div>
                                <div class="col">
                                  <div class="form-group">
                                    <label for="tgl_panen"><strong>Tanggal Panen :</strong></label>
                                     <input type="text" name="tgl_panen" class="form-control" id="tgl_panen" value="<?= set_value('tgl_panen'); ?>" readonly>
                                     <small>* Masa aktif tanam selama 120 hari</small>
                                     <small class="form-text text-danger"><?= form_error('tgl_panen'); ?></small>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="luas_tanam"><strong>Luas Tanam :</strong></label>
                                  <input type="text" name="luas_tanam" class="form-control" id="luas_tanam" value="<?= set_value('luas_tanam'); ?>">
                                    <small>* Batas maksimal luas lahan yang dapat dimasukan : <span id="angkaluas"></span></small>
                                    <small class="form-text text-danger"><?= form_error('luas_tanam'); ?></small>
                                </div>
                                  <input type="hidden" name="value123" value="" id="luas_lahan">
                                <div class="form-group">
                                  <div class="row">
                                    <div class="col">
                                      <label><strong>Pengairan 1 : </strong></label>
                                        <div class="form-group">
                                          <select class="form-control custom-select" name="pengairan1" id="pengairan1">
                                            <option value="">Pilih Kondisi</option>
                                            <option value="Baik" <?php echo set_select('pengairan1','Baik'); ?>>Baik</option>
                                            <option value="Cukup" <?php echo set_select('pengairan1','Cukup'); ?>>Cukup</option>
                                            <option value="Kurang" <?php echo set_select('pengairan1','Kurang'); ?>>Kurang</option>
                                          </select>
                                          <small>* 0-7 HST</small>
                                          <small class="form-text text-danger"><?= form_error('pengairan1'); ?></small>
                                        </div>
                                      </div>
                                      <div class="col">
                                        <label><strong>Pemupukan 1 : </strong></label>
                                          <div class="form-group">
                                            <input type="text" name="pemupukan1" class="form-control" value="<?= set_value('pemupukan1'); ?>">
                                              <small>* (KG) 0-7 HST</small>
                                              <small class="form-text text-danger"><?= form_error('pemupukan1'); ?></small>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="row">
                                        <div class="col">
                                          <label><strong>Penjarangan : </strong></label>
                                            <div class="form-group">
                                              <select class="form-control custom-select" name="penjarangan" id="penjarangan">
                                                <option value="">Pilih Kondisi</option>
                                                <option value="Ya" <?php echo set_select('penjarangan','Ya'); ?>>Ya</option>
                                                <option value="Tidak" <?php echo set_select('penjarangan','Tidak'); ?>>Tidak</option>
                                              </select>
                                              <small>* 5-7 HST</small>
                                              <small class="form-text text-danger"><?= form_error('penjarangan'); ?></small>
                                            </div>
                                          </div>
                                        <div class="col">
                                          <label><strong>Penyiangan : </strong></label>
                                            <div class="form-group">
                                              <select class="form-control custom-select" name="penyiangan" id="penyiangan">
                                                <option value="">Pilih Kondisi</option>
                                                <option value="Ya" <?php echo set_select('penyiangan','Ya'); ?>>Ya</option>
                                                <option value="Tidak" <?php echo set_select('penyiangan','Tidak'); ?>>Tidak</option>
                                              </select>
                                            <small>* 10-15 HST</small>
                                            <small class="form-text text-danger"><?= form_error('penyiangan'); ?></small>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-lg-6">
                                    <label><strong>Staff : </strong></label>
                                      <div class="form-group">
                                        <select class="form-control custom-select select2" name="staff" id="staff" data-placeholder="Pilih Staff" data-multiple="false">

                                          <option value="">Pilih Staff</option>
                                  
                                        </select>
                                        <small class="form-text text-danger"><?= form_error('staff'); ?></small>
                                      </div>
                                    <label><strong>Penyakit : </strong></label>
                                      <div class="form-group">
                                        <select class="form-control custom-select" name="penyakit" id="penyakit">
                                          <option value="">Pilih Kondisi</option>
                                          <option value="Ada" <?php echo set_select('penyakit','Ada'); ?>>Ada</option>
                                          <option value="Tidak Ada" <?php echo set_select('penyakit','Tidak Ada'); ?>>Tidak Ada</option>
                                        </select>
                                        <small class="form-text text-danger"><?= form_error('penyakit'); ?></small>
                                      </div>
                                    <div class="form-group" id="wrapper_penyakit_description">
                                      <input type="text" name="penyakit_desc" class="form-control" id="penyakit_desc" placeholder="Deskripsi penyakit">
                                    </div>
                                    <div class="form-group">
                                      <div class="row">
                                        <div class="col">
                                          <label><strong>Pemupukan 2 : </strong></label>
                                            <div class="form-group">
                                              <input type="text" name="pemupukan2" class="form-control" value="<?= set_value('pemupukan2'); ?>">
                                              <small>* (KG) 40-45 HST</small>
                                              <small class="form-text text-danger"><?= form_error('pemupukan2'); ?></small>
                                            </div>
                                          </div>
                                        <div class="col">
                                          <label><strong>Pengairan 2 : </strong></label>
                                            <div class="form-group">
                                              <select class="form-control custom-select" name="pengairan2" id="pengairan2">
                                                <option value="">Pilih Kondisi</option>
                                                <option value="Baik" <?php echo set_select('pengairan2','Baik'); ?>>Baik</option>
                                                <option value="Cukup" <?php echo set_select('pengairan2','Cukup'); ?>>Cukup</option>
                                                <option value="Kurang" <?php echo set_select('pengairan2','Kurang'); ?>>Kurang</option>
                                              </select>
                                            <small>* 45-57 HST</small>
                                            <small class="form-text text-danger"><?= form_error('pengairan2'); ?></small>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                      <input type="hidden" name="in_date" class="form-control" id="in_date" value="<?= date("Y-m-d h:i:s") ?>">
                                      <input type="hidden" name="in_by" class="form-control" id="in_by" value="<?= $user['id']; ?>">
                                      <input type="hidden" name="edit_date" class="form-control" id="edit_date" value="<?= date("Y-m-d h:i:s") ?>">
                                      <input type="hidden" name="edit_by" class="form-control" id="edit_by" value="<?= $user['id']; ?>">
                                    <div class="row">
                                      <div class="col-lg-6">
                                      <div class="form-group">
                                      <label><strong>Pengairan 3 : </strong></label>
                                        <div class="form-group">
                                          <select class="form-control custom-select" name="pengairan3" id="pengairan3">
                                            <option value="">Pilih Kondisi</option>
                                            <option value="Baik" <?php echo set_select('pengairan3','Baik'); ?>>Baik</option>
                                            <option value="Cukup" <?php echo set_select('pengairan3','Cukup'); ?>>Cukup</option>
                                            <option value="Kurang" <?php echo set_select('pengairan3','Kurang'); ?>>Kurang</option>
                                          </select>
                                        <small>* 60-80 HST</small>
                                        <small class="form-text text-danger"><?= form_error('pengairan3'); ?></small>
                                        </div>
                                      </div>
                                      </div>
                                      <div class="col-lg-6">
                                         <div class="form-group">
                                          <label><strong>Prediksi Tonase : </strong></label>
                                            <div class="form-group">
                                            <input type="text" name="prediksi_tonase" class="form-control" value="<?= set_value('prediksi_tonase'); ?>">
                                            <small>* Satuan ton</small>
                                            <small class="form-text text-danger"><?= form_error('pengairan3'); ?></small>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    </div>
                                  </div>
                                <button type="submit" class="btn btn-kirana float-right ml-2">Tambah Data</button>
                                <a href="<?= base_url('poktantanam'); ?>"><button type="button" class="btn btn-danger float-right">Cancel</button></a>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>




<!-- JS POKTANTANAM -->
<script src="<?= base_url(); ?>assets/js/script_poktantanam.js"></script>
<!-- AKHIR JS POKTANTANAM -->

