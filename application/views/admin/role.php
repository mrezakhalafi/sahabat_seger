<!-- Begin Page Content -->
  <div class="container-fluid">
  <!-- Page Heading -->
    
      <div class="row">
        <div class="col-lg-8">
          <h1 class="h3 text-gray-800" style="margin-bottom: 17px;"><?= $title; ?></h1>
            <div class="card border-top-kirana shadow py-2">
              <div class="card-body">
                <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('message'); ?>"></div>
                  <table class="table table-striped shadow" id="tb_role">
                    <thead>
                      <tr class="bar-table">
                        <th>No</th>
                        <th scope="col">Role</th>
                        <th scope="col">Multiplant</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; ?>
                      <?php foreach ($tampilrole as $r) :?>
                      <tr> 
                        <td><?= $i; ?></td>
                        <td><?= $r['nama_role']; ?></td>
                        <td class="text-center"><?php if ($r['multiplant'] == 1): ?>
                          <i class="fas fa-check-circle icon-check"></i>
                        <?php else: ?>
                          <i class="fas fa-times-circle icon-uncheck"></i>
                        <?php endif ?></td>
                        <td class="text-center">
                          <?php if($r['aktif'] == 1): ?>
                            <i class="fas fa-check-circle icon-check"></i>
                          <?php else:?>
                            <i class="fas fa-times-circle icon-uncheck"></i>
                          <?php endif; ?>
                        </td>
                        <td class="min-width-btn text-center">
                          <a href="<?= base_url('admin/direct') ?>/<?=$r['id']?>"><button class="btn btn-info btn-sm">Akses</button></a>
                          <button class="btn btn-success btn-sm btn-ubah" id="btn-ubah" type="button" onclick="pilihdataRole('<?= $r['id']; ?>');">Edit</button> 
                          <?php if($r['aktif'] == 1): ?>
                            <a class="tombol-hapus" href="<?= base_url('admin/hapusRole') ?>/<?=$r['id']?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                          <?php else: ?>
                            <a class="" href="<?= base_url('admin/aktifRole') ?>/<?=$r['id']?>"><button class="btn btn-primary btn-sm min-width-btn-59">Aktif</button></a>
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
          <span id="txt-tambah-role">Tambah Data Role</span>
          <span id="txt-ubah-role">Ubah Data Role</span>
        </div>
      <div class="card border-top-kirana shadow h-100 py-2">
        <div class="card-body">
          <form id="ubah_form_role" action="<?= base_url('admin/tambahrole') ?>" method="post"> 
            <label>Role : </label>
              <div class="form-group">
                <input class="form-control" id="role" type="text" name="nama_role">
                <small class="form-text text-danger"><?= form_error('nama_role'); ?></small>  
              </div>
            <label>Multiplant : </label>
              <div class="form-group">
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="yesmultiplant" name="multiplant" class="custom-control-input" value="1" checked>
                  <label class="custom-control-label" for="yesmultiplant">Ya</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="nomultiplant" name="multiplant" class="custom-control-input" value="0">
                  <label class="custom-control-label" for="nomultiplant">Tidak</label>
                </div>          
              </div>
              <div class="status_role">
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
              <input type="hidden" id="id_role" name="id_role" value="">
              <a href="<?= base_url('admin/ubahrole') ?>/<?= $r['id']?>"><button type="submit" id="ubahrole" class="float-right btn btn-kirana">Ubah Role</button></a>
              <button type="button" id="cancelrole" class="float-right btn btn-danger mr-2">Cancel</button>       
              <button type="submit" id="tambahrole" class="float-right btn btn-kirana">Tambah Role</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="aksesModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newRoleModalLabel">Access Role <?= $role['nama_role'] ?></h5>
          <button type="button" class="close close1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Menu</th>
            <th scope="col">Access</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1 ;?>
          <?php foreach($menu_kategori as $mk): ?>
            <?php if($mk['aktif']==1) : ?> 
              <tr>
                  <th scope="row"><?= $i; ?></th>
                  <td><b><?= $mk['kategori_menu']; ?></b></td>
                  <td></td>
              </tr>
            <?php endif; ?>
                <?php foreach ($menu as $m): ?>
                <?php if($m['parent']==$mk['id']) : ?>
                    <?php if($m['aktif']==1) : ?> 
                    <tr>
                      <th scope="row"></th>
                      <td><i class="<?= $m['icon'] ?>"></i>&nbsp; <?= $m['title']; ?></td>
                      <td>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input akses" id="<?= $m['id']; ?>" <?= check_access($role['id'], $m['id'], $mk['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>" data-parent="<?= $mk['id']; ?>">
                          <label class="custom-control-label" for="<?= $m['id']; ?>"></label>
                        </div>
                      </td>
                    </tr>
                  <?php endif; ?>
                <?php endif; ?>
                <?php endforeach; ?>
          <?php $i++; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-kirana close1" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- JS ROLE -->
<script src="<?= base_url(); ?>assets/js/script_role.js"></script>
<!-- AKHIR JS ROLE -->

