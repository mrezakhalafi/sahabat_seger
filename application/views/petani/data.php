<!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
      <div class="col-lg-12" style="padding: 0">
      <?= $this->session->flashdata('message'); ?>
        <div class="card shadow">
          <div class="card-header m-0 font-weight-bold txt-kirana">
            <?= $title2; ?>
          </div>
            <div class="card-body">
              <div class="col-lg-12">
                <div class="card border-top-kirana shadow h-100 py-2">
                  <div class="card-body">
                    <form action="<?= base_url('petani/tambah') ?>" method="post" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="nama_petani"><strong>Nama Petani :</strong></label>
                              <input type="text" name="nama_petani" class="form-control" id="nama_petani" value="<?= set_value('nama_petani'); ?>">
                              <small class="form-text text-danger"><?= form_error('nama_petani'); ?></small>
                            </div>
                          <div class="form-group">
                            <label for="no_ktp"><strong>No.KTP :</strong></label>
                             <input type="text" name="no_ktp" class="form-control" id="no_ktp" value="<?= set_value('no_ktp'); ?>">
                             <small class="form-text text-danger"><?= form_error('no_ktp'); ?></small>
                          </div>
                          <div class="form-group">
                            <label for="no_kk"><strong>No.KK :</strong></label>
                             <input type="text" name="no_kk" class="form-control" id="no_kk" value="<?= set_value('no_kk'); ?>">
                             <small class="form-text text-danger"><?= form_error('no_kk'); ?></small>
                          </div>
                          <div class="form-group">
                            <label for="jns_kelamin"><strong>Jenis Kelamin :</strong></label><br>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="jns_kelamin" name="jns_kelamin" class="custom-control-input" value="Laki-Laki" <?php echo set_radio('jns_kelamin', 'Laki-Laki'); ?>>
                                <label class="custom-control-label" for="jns_kelamin">Laki - Laki</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="jns_kelamin2" name="jns_kelamin" class="custom-control-input" value="Perempuan" <?php echo set_radio('jns_kelamin', 'Perempuan'); ?>>
                                <label class="custom-control-label" for="jns_kelamin2">Perempuan</label>
                              </div>
                              <small class="form-text text-danger"><?= form_error('jns_kelamin'); ?></small>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col">
                                <label for="nama"><strong>Tempat Lahir :</strong></label>
                                 <input type="text" name="tmpt_lahir" class="form-control" id="tmpt_lahir" value="<?= set_value('tmpt_lahir'); ?>">
                                 <small class="form-text text-danger"><?= form_error('tmpt_lahir'); ?></small>
                              </div>
                              <div class="col">
                                <label for="nama"><strong>Tanggal Lahir :</strong></label>
                                 <input type="text" id="tgl_lahir" placeholder="01/01/1980" name="tgl_lahir" class="form-control" id="tgl_lahir" value="<?= set_value('tgl_lahir'); ?>">
                                 <small class="form-text text-danger"><?= form_error('tgl_lahir'); ?></small>
                              </div>
                            </div>
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
                          <div class="form-group">
                            <div class="row">
                              <div class="col">
                                <label><strong>Provinsi : </strong></label>
                                   <div class="form-group">
                                      <select class="form-control custom-select action_wilayah select2" name="id_prov" id="id_prov" data-placeholder="Pilih Provinsi" data-multiple="false">
                                      <option value="">Pilih Provinsi</option>
                                        <?php foreach ($prov as $row): ?>
                                          <option value="<?= $row['id'] ?>" <?php echo set_select('id_prov',$row['id']); ?>> <?= $row['nama_prov'] ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                      <small class="form-text text-danger"><?= form_error('id_prov'); ?></small>
                                  </div>
                                </div>
                              <div class="col">
                                <label><strong>Kabupaten : </strong></label>
                                  <div class="form-group">
                                    <select class="form-control custom-select action_wilayah select2" name="id_kab" id="id_kab" data-placeholder="Pilih Kabupaten" data-multiple="false">
                                      <option value="">Pilih Kabupaten</option>
                                        <?php foreach ($kab as $row2): ?>
                                          <option value="<?= $row2['id'] ?>" <?php echo set_select('id_kab',$row2['id']); ?> > <?= $row2['nama_kab'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger"><?= form_error('id_kab'); ?></small>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col">
                              <label><strong>Kecamatan : </strong></label>
                                <div class="form-group">
                                  <select class="form-control custom-select action_wilayah select2" name="id_kec" id="id_kec" data-placeholder="Pilih Kecamatan" data-multiple="false">
                                    <option value="">Pilih Kecamatan</option>
                                      <?php foreach ($kec as $row3): ?>
                                        <option value="<?= $row3['id'] ?>" <?php echo set_select('id_kec',$row3['id']); ?> > <?= $row3['nama_kec'] ?></option>
                                      <?php endforeach; ?>
                                  </select>
                                <small class="form-text text-danger"><?= form_error('id_kec'); ?></small>
                              </div>
                            </div>
                          <div class="col">
                            <label><strong>Desa : </strong></label>
                              <div class="form-group">
                                <select class="form-control custom-select action_wilayah select2" name="id_desa" id="id_desa" data-placeholder="Pilih Desa" data-multiple="false">
                                  <option value="">Pilih Desa</option>
                                    <?php foreach ($desa as $row4): ?>
                                      <option value="<?= $row4['id'] ?>" <?php echo set_select('id_desa',$row4['id']); ?> > <?= $row4['nama_desa'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-text text-danger"><?= form_error('id_desa'); ?></small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="nama_pasangan"><strong>Nama Pasangan :</strong></label>
                            <input type="text" name="nama_pasangan" class="form-control" id="nama_pasangan" value="<?= set_value('nama_pasangan'); ?>">
                            <small class="form-text text-danger"><?= form_error('nama_pasangan'); ?></small>
                            <small>* Tidak harus diisi</small>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col">
                              <label><strong>Rekening Bank : </strong></label>
                                <div class="form-group">
                                  <select class="form-control custom-select select2" name="rek_bank" id="rek_bank" data-placeholder="Pilih Rekening" data-multiple="false">
                                    <option value="">Pilih Rekening Bank</option>
                                      <?php foreach ($bank as $row5): ?>
                                        <option value="<?= $row5['id'] ?>" <?php echo set_select('rek_bank',$row5['id']); ?>><?= $row5['nama_bank'] ?></option>
                                      <?php endforeach; ?>
                                  </select>
                                <small class="form-text text-danger"><?= form_error('rek_bank'); ?></small>
                              </div>
                            </div>
                          <div class="col">
                            <label for="rek_cabang"><strong>Rekening Cabang :</strong></label>
                              <input type="text" name="rek_cabang" class="form-control" id="rek_cabang" value="<?= set_value('rek_cabang'); ?>">
                              <small class="form-text text-danger"><?= form_error('rek_cabang'); ?></small>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="rek_nama"><strong>Rekening Nama :</strong></label>
                           <input type="text" name="rek_nama" class="form-control" id="rek_nama" value="<?= set_value('rek_nama'); ?>">
                           <small class="form-text text-danger"><?= form_error('rek_nama'); ?></small>
                        </div>
                        <div class="form-group">
                          <label for="rek_no"><strong>No. Rekening :</strong></label>
                            <input type="text" name="rek_no" class="form-control" id="rek_no" value="<?= set_value('rek_no'); ?>">
                            <small class="form-text text-danger"><?= form_error('rek_no'); ?></small>
                        </div>
                          <input type="hidden" name="in_date" class="form-control" id="in_date" value="<?= date("Y-m-d h:i:s") ?>">
                          <input type="hidden" name="in_by" class="form-control" id="in_by" value="<?= $user['id']; ?>">
                          <input type="hidden" name="edit_date" class="form-control" id="edit_date" value="<?= date("Y-m-d h:i:s") ?>">
                          <input type="hidden" name="edit_by" class="form-control" id="edit_by" value="<?= $user['id']; ?>">
                        <div class="form-group0" style="padding: 0">
                        <div class="row">
                          <div class="col-lg-6">
                            <label for="file_ktp"><strong>File KTP :</strong></label>
                          </div>
                          <div class="col-lg-6">
                            <label for="file_kk"><strong>File KK :</strong></label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="upload-btn-wrapper">
                              <button class="upload">Upload a file</button><div id="txt_upload" style="display: inline;"> <small>No file uploaded.</small></div>
                              <input type="file" name="file_ktp" id="file_ktp">
                            </div>
                            <small class="form-text text-danger"><?= form_error('file_ktp'); ?></small>
                          </div>
                          <div class="col-lg-6">
                            <div class="upload-btn-wrapper">
                                <button class="upload">Upload a file</button><div id="txt_upload2" style="display: inline;"> <small>No file uploaded.</small></div>
                                <input type="file" name="file_kk" class="form-control" id="file_kk">
                              </div>
                              <small class="form-text text-danger"><?= form_error('file_kk'); ?></small>
                          </div>
                        </div>  
                      <small>Dokumen harus berupa format PDF, JPG, PNG, file maksimal 2 MB</small><br><br>
                    </div>
                  <div class="status_petani">
                    <label>Status : </label>
                      <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="aktif" id="aktif" name="aktif" class="custom-control-input" value="1" checked>
                          <label class="custom-control-label" for="aktif">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="nonaktif" name="aktif" class="custom-control-input" value="2">
                          <label class="custom-control-label" for="nonaktif">Tidak Aktif</label>
                        </div>          
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-kirana float-right ml-2">Tambah Data</button>
                <a href="<?= base_url('petani'); ?>"><button type="button" class="btn btn-danger float-right">Cancel</button></a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /.container-fluid -->

<!-- JS PETANI -->
<script src="<?= base_url(); ?>assets/js/script_petani.js"></script>
<!-- AKHIR JS PETANI -->

  