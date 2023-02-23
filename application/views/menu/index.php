<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
<div class="row">
  <div class="col-lg-8">
    <div class="float-left">
      <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="float-right">
      <a href="" class="btn btn-kirana mb-3" data-toggle="modal" data-target="#newMenuModal"><i class="fas fa-plus"></i> Tambah Kategori Menu</a>
    </div>
  </div>
</div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card border-top-kirana shadow h-100 py-2">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
          </div>
        </div>
        <table class="table table-hover" id="menu_tabel">
          <thead>
            <tr class="bar-table">
              <th scope="col">#</th>
              <th scope="col">Menu</th>
              <th>Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1 ;?>
            <?php foreach ($kategori_menu as $m): ?>

            <tr>
              <td scope="row"><?= $i; ?></td>
              <td><?= $m['kategori_menu']; ?></td>
              <td class="text-center">
                <?php if($m['aktif'] == 1): ?>
                 <i class="fas fa-check-circle icon-check"></i>  
                <?php else: ?>
                 <i class="fas fa-times-circle icon-uncheck"></i>
                <?php endif; ?>
              </td>
              <td class="min-width-btn text-center">
                <!-- Example split danger button -->
                <div class="row">
                  <div class="col-lg-12 text-center">
                    <div class="btn-group justify-content-center">
                      <button type="button" class="btn btn-info btn-sm btn-tambahMenu" data-toggle="modal" data-target="#newSubMenuModal" data-id-kategori="<?= $m['id']; ?>">Tambah Menu</button>
                      <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="pilihdatakategorimenu(<?= $m['id']; ?>);" data-toggle="modal" data-target="#editmenuKategori">Ubah Kategori Menu</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item edit_menus" href="#">Ubah Menu</a>
                        <?php if($m['aktif'] == 1): ?>
                          <a class="dropdown-item tombol-hapus" href="<?= base_url('menu/deletekategori') ?>/<?=$m['id']?>">Delete Menu</a>
                        <?php else: ?>
                          <a class="dropdown-item" href="<?= base_url('menu/aktifkategori') ?>/<?=$m['id']?>">Aktif Menu</a>
                        <?php endif; ?>
                        <div class="hide_cancel">
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item cancelUbah" href="#">Cancel</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            
            <?php $i++; ?>

             <?php foreach ($menu as $sm): ?>
             <?php if($sm['parent']==$m['id']) : ?>
              <tr id="menus">
                <td></td>
                <td><i class="<?= $sm['icon']; ?>"></i>&nbsp; &nbsp;<?= $sm['title']; ?></td>
                <td class="text-center">
                  <?php if($sm['aktif'] == 1): ?>
                    <i class="fas fa-check-circle icon-check"></i>
                  <?php else: ?>
                    <i class="fas fa-times-circle icon-uncheck"></i>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <div class="btn_element2">
                    <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editMenu" onclick="pilihdataMenu(<?= $sm['id']; ?>);">Edit</a>
                    <?php if($sm['aktif'] == 1): ?>
                      <a href="<?= base_url('menu/deletemenu') ?>/<?=$sm['id']?>/<?=$sm['parent']?>" class="btn badge-danger btn-sm tombol-hapus">Delete</a>
                    <?php else: ?>
                      <a href="<?= base_url('menu/aktifmenu') ?>/<?=$sm['id']?>/<?=$sm['parent']?>" class="btn badge-primary btn-sm min-width-btn-59">Aktif</a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endif; ?>              
            <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
   
<!-- MODAL TAMBAH KATEGORI-->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Tambah Kategori Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu'); ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="kategori_menu" name="kategori_menu" placeholder="Kategori name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-kirana">Tambah</button>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- AKHIR MODAL TAMBAH KATEGORI-->  

<!-- MODAL EDIT MENU-->
<div class="modal fade" id="editMenu" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Ubah Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu/ubahmenu'); ?>" method="post">
      <div class="modal-body">
          <div class="form-group">
            <label for="title_edit"><strong>Judul Menu :</strong></label>
            <input type="text" class="form-control" name="title" placeholder="Judul Menu" id="title_edit">
          </div>
          <div class="form-group">
            <label for="parent"><strong>Parent :</strong></label>
            <select name="parent" id="parent" class="form-control custom-select parents">
              <option value="">Pilih Menu</option>
                <?php foreach($kategori_menu as $m): ?>
                  <option value="<?= $m['id']; ?>"><?= $m['kategori_menu']; ?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="url"><strong>Url :</strong></label>
            <input type="text" class="form-control" id="url" name="url" placeholder="Url Menu">
          </div>
          <div class="form-group">
            <label for="icon"><strong>Icon :</strong></label>
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Icon Menu">
          </div>
        <div class="form-group">
            <label for="no_urut"><strong>No. Urut :</strong></label>
            <input type="text" class="form-control" id="no_urut" name="no_urut">
          </div>
          <div class="status_menu">
            <label>Status : </label>
            <div class="form-group">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="aktif_menu" name="aktif" class="custom-control-input" value="1">
                <label class="custom-control-label" for="aktif_menu">Aktif</label>
              </div>

              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="nonaktif_menu" name="aktif" class="custom-control-input" value="0">
                <label class="custom-control-label" for="nonaktif_menu">Tidak Aktif</label>
              </div>
            </div>
          </div>
          <input class="form-control" id="in_date" type="hidden" name="in_date" value="<?= date("Y-m-d h:i:s") ?>">
          <input class="form-control" id="in_by" type="hidden" name="in_by" value="<?= $user['id']; ?>">
          <input class="form-control" id="edit_date" type="hidden" name="edit_date" value="<?= date("Y-m-d h:i:s") ?>">
          <input class="form-control" id="edit_by" type="hidden" name="edit_by" value="<?= $user['id']; ?>">
          <input type="hidden" name="id2" id="id2">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-kirana">Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- AKHIR MODAL EDIT MENU-->  

<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Form Tambah Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?= base_url('menu/tambahmenu'); ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="title_edit"><strong>Judul Menu :</strong></label>
            <input type="text" class="form-control" id="title_edit" name="title">
          </div>
          <div class="form-group">
            <label for="parent"><strong>Parent :</strong></label>
            <select name="parent" id="parent" class="form-control custom-select parents">
              <option value="">Pilih Menu</option>
                <?php foreach($kategori_menu as $m): ?>
                  <option value="<?= $m['id']; ?>"><?= $m['kategori_menu']; ?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="url"><strong>Url :</strong></label>
            <input type="text" class="form-control" id="url" name="url">
          </div>
          <div class="form-group">
            <label for="icon"><strong>Icon :</strong></label>
            <input type="text" class="form-control" id="icon" name="icon">
          </div>
          <div class="form-group">
            <label for="no_urut"><strong>No. Urut :</strong></label>
            <input type="text" class="form-control" id="no_urut" name="no_urut">
          </div>
          <input class="form-control" id="in_date" type="hidden" name="in_date" value="<?= date("Y-m-d h:i:s") ?>">
          <input class="form-control" id="in_by" type="hidden" name="in_by" value="<?= $user['id']; ?>">
          <input class="form-control" id="edit_date" type="hidden" name="edit_date" value="<?= date("Y-m-d h:i:s") ?>">
          <input class="form-control" id="edit_by" type="hidden" name="edit_by" value="<?= $user['id']; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-kirana">Tambah</button>
          </form>
      </div>
    </div>
  </div>
</div> 

<!-- MODAL EDIT KATEGORI MENU-->
<div class="modal fade" id="editmenuKategori" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newMenuModalLabel">Ubah Kategori Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu/ubahkategori'); ?>" method="post">
      <div class="modal-body">
          <div class="form-group">
            <label for="title_edit"><strong>Kategori Menu :</strong></label>
            <input type="text" class="form-control" name="kategori_menu" id="kategori_menu_edit" value="">
            <input type="hidden" name="id2" id="id3">
          </div>
          <div class="status_kategori_menu">
            <label>Status : </label>
            <div class="form-group">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="aktif_kategori_menu" name="aktif" class="custom-control-input" value="1">
                <label class="custom-control-label" for="aktif_kategori_menu">Aktif</label>
              </div>

              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="nonaktif_kategori_menu" name="aktif" class="custom-control-input" value="0">
                <label class="custom-control-label" for="nonaktif_kategori_menu">Tidak Aktif</label>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-kirana">Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>
<!-- AKHIR MODAL EDIT KATEGORI MENU-->  


<!-- JS MENU -->
<script src="<?= base_url(); ?>assets/js/script_menu.js"></script>
<!-- AKHIR JS MENU -->