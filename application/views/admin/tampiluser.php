<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
    <div class="row">
        <div class="col-lg-8">
          <h1 class="h3 text-gray-800" style="margin-bottom: 17px;"><?= $title; ?></h1>
          <div class="card border-top-kirana shadow py-2">
            <div class="card-body">
               <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
               <table class="table table-striped table-responsive shadow" id="userdong">
                <thead>
                  <tr class="bar-table">
                    <th>No</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Nama Plant</th>
                    <th scope="col">Aktif</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($get_user as $row) :?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td class="min-width-150"><?= $row['fullname']; ?></td>
                    <td class="min-width-120"><?= $row['username']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['nama_role']; ?></td>

                    <td class="min-width-120">
                        <?php foreach($akses_semua as $r) : ?>
                          <?php if($row['id']==$r['id_user']) : ?>
                            <?= $r['nama_cabang']; ?><br>
                          <?php endif; ?>
                        <?php endforeach;?>
                    </td>
                    <td>
                      <?php if($row['aktif'] == 1): ?>
                        <i class="fas fa-check-circle icon-check"></i>
                      <?php else:?>
                        <i class="fas fa-times-circle icon-uncheck"></i>
                      <?php endif; ?>
                    </td>
                    <td class="min-width-btn text-center">
                      <button class="btn btn-success btn-sm btn-ubah" id="btn-ubah" type="button" onclick="pilihData('<?= $row['id']; ?>');">Edit</button> 
                      <?php if($row['aktif'] == 1): ?>
                        <a class="tombol-hapus" href="<?= base_url('admin/hapususer') ?>/<?=$row['id']?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                      <?php else: ?>
                        <a class="" href="<?= base_url('admin/aktifuser') ?>/<?=$row['id']?>"><button class="btn btn-primary btn-sm min-width-btn-59">Aktif</button></a>
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
            <span id="txt-tambah-user">Tambah Data User</span>
            <span id="txt-ubah-user">Ubah Data User</span>
          </div>
          <div class="card border-top-kirana shadow h-100 py-2">
            <div class="card-body">
              <form id="ubah_form" action="<?= base_url('admin/tambahUser') ?>" method="post"> 
                <label>Role : </label>
                  <div class="form-group">
                    <select name="id_role" id="id_role" class="form-control custom-select select2" data-placeholder="Pilih Role" data-multiple="false">
                      <option value="">Pilih Role</option>
                        <?php foreach($getrole as $row2) : ?>
                          <option value="<?= $row2['id']; ?>" data-multiplant="<?= $row2['multiplant']?>" <?php echo set_select('id_role',$row2['id']); ?>><?= $row2['nama_role']; ?></option>
                        <?php endforeach; ?>
                    </select>
                      <small class="form-text text-danger"><?= form_error('id_role'); ?></small>
                  </div>
                  <label>Plant : </label>

                  <script>

                  </script>

                  <div class="form-group">

                    <select name="id_plant_cabang[]" id="id_plant_cabang"  class="form-control custom-select select2" data-placeholder="Pilih Plant Cabang" data-multiple="true" multiple>


                        <?php foreach($plant as $row4) : ?>
                          <option disabled <?php echo set_select('id_plant',$row4['id']); ?>><b><?= $row4['nama_plant']; ?></b></option>
                        <?php foreach($cabang as $row3) : ?>
                          <?php if($row3['id_plant']==$row4['id']) : ?>
                          <option value="<?= $row3['id']; ?>" data-parent="<?= $row4['id']; ?>" <?php echo set_select('id_plant_cabang',$row3['id']); ?>>&nbsp;&nbsp;&nbsp;<?= $row3['nama_cabang']; ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </select>


                   
                      <small class="form-text text-danger"><?= form_error('id_plant_cabang'); ?></small>
                  </div>
                    <label>Username : </label>
                      <div class="form-group">
                        <input class="form-control" type="text" id="username" name="username" value="<?= set_value('username'); ?>">
                        <small class="form-text text-danger"><?= form_error('username'); ?></small>
                      </div>
                    <label>Fullname : </label>
                      <div class="form-group">
                        <input class="form-control" type="text" id="fullname" name="fullname" id="fullname" value="<?= set_value('fullname'); ?>">
                        <small class="form-text text-danger"><?= form_error('fullname'); ?></small>
                      </div>
                    <label>Password : </label>
                      <div class="form-group">
                        <input class="form-control" id="pass" type="password" name="pass" placeholder="">
                        <small class="form-text text-danger"><?= form_error('pass'); ?></small>
                      </div>
                    <label>Confirm Password : </label>
                      <div class="form-group">
                        <input class="form-control" type="password" name="pass2" id="pass2" placeholder="">
                        <small class="form-text text-danger"><?= form_error('pass2'); ?></small>
                      </div>
                      <input type="hidden" name="pass_bp" id="pass_bp">
                    <label>Email : </label>
                      <div class="form-group">
                        <input class="form-control" id="email" type="text" name="email" value="<?= set_value('email'); ?>">
                        <small class="form-text text-danger"><?= form_error('email'); ?></small>  
                     </div>
                      <input class="form-control" id="in_date" type="hidden" name="in_date" value="<?= date("Y-m-d h:i:s") ?>">
                      <input class="form-control" id="in_by" type="hidden" name="in_by" value="<?= $user['id']; ?>">
                      <input class="form-control" id="edit_date" type="hidden" name="edit_date" value="<?= date("Y-m-d h:i:s") ?>">
                      <input class="form-control" id="edit_by" type="hidden" name="edit_by" value="<?= $user['id']; ?>">
                        <div class="status_user">
                          <label>Status : </label>
                            <div class="form-group">
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="aktif" id="aktif" name="aktif" class="custom-control-input" value="1" checked>
                                  <label class="custom-control-label" for="aktif">Aktif</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="nonaktif" name="aktif" class="custom-control-input" value="0">
                                    <label class="custom-control-label" for="nonaktif">Tidak Aktif</label>
                                </div>          
                            </div>
                          </div>
                        <input type="hidden" id="id_user" name="id_user" value="">
                      <button type="submit" id="ubahuser" class="float-right btn btn-kirana">Ubah User</button>
                  <button type="button" id="canceluser" class="float-right btn btn-danger mr-2">Cancel</button>       
                <button type="submit" id="tambahuser" class="float-right btn btn-kirana">Tambah User</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->


</div>
</div>
</div>

<!-- JS USER -->
<script src="<?= base_url(); ?>assets/js/script_user.js"></script>
<!-- AKHIR JS USER -->

