<!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
  <div class="row">
    <div class="col-lg-8">
      <div class="float-left">
        <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="float-right mb-3">  
        <a href="<?= base_url('poktan/tambah'); ?>"><button class="btn btn-kirana"><i class="fas fa-user-plus"></i> Tambah Data Poktan</button></a>
      </div>
    </div>
  </div>
      <div class="row" style="clear: both">
        <div class="col-lg-12">
          <div class="card border-top-kirana shadow h-100 py-2">
            <div class="card-body">
              <div class="row">
                <div class="col-3">
                  <div class="form-group">
                    <label><strong>Plant</strong></label>
                    <select class="form-control custom-select select2" name="id_plant_cabang" id="id_plant_cabang_poktanam" data-placeholder="Pilih Plant" data-multiple="true" multiple>
                     
                      <?php $old = null; ?>
                      <?php foreach ($cabang as $row1): ?>
                        <?php if ($row1['nama_cabang']!=$old) : ?>
                        <option value="<?= $row1['id'] ?>" <?php echo set_select('id_plant_cabang_poktanam',$row1['id']); ?>><?= $row1['nama_cabang'] ?></option>
                        <?php $old = $row1['nama_cabang'] ?>
                        <?php else: endif; ?>
                      <?php endforeach; ?>

                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label><strong>Staff</strong></label>
                    <select class="form-control custom-select select2" name="id_staff" id="id_staff_poktanam" data-placeholder="Pilih Staff" data-multiple="true" multiple>
                      <option value="">Pilih Staff</option>

                      <?php $old = null; ?>
                      <?php foreach ($staff as $row4): ?>
                        <?php if ($row4['fullname']!=$old) : ?>
                        <option value="<?= $row4['id'] ?>" <?php echo set_select('id_staff_poktanam',$row4['id']); ?>><?= $row4['fullname'] ?></option>
                        <?php $old = $row4['fullname'] ?>
                        <?php else: endif; ?>
                      <?php endforeach; ?>  

                    </select>
                  </div>
                </div>          
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                </div>
              </div>
              <table class="table table-striped table-responsive" id="tb_poktan">
    	          <thead class="bar-table">
                  <th>No</th>
                  <th class="min-width-120">Nama Poktan</th>
                  <th>Alamat</th>
                  <th>Email</th>
                  <th>Ketua</th>          
                  <th>Sekretaris</th>
                  <th>Bendahara</th>
                  <th>Staff</th>
                  <th class="min-width-120">Jenis Mitra</th>
                  <th>Komuditi</th>
                  <th>Provinsi</th>
                  <th>Kabupaten</th>        
                  <th>Kecamatan</th>
                  <th>Desa</th>
                  <th class="min-width-120">Rekening Bank</th>
                  <th class="min-width-150">Rekening Cabang</th>
                  <th class="min-width-120">Nama Rekening</th>
                  <th>No.Rekening</th>            
                  <th>Telepon</th>  
                  <th>Plant</th>          
              		<th>Aktif</th>
              		<th>Action</th>
    	          </thead>
              <tbody>
              <?php $i = 1; ?>
              <?php foreach ($tampil as $row): ?>
    	          <tr>   
                  <td><?= $i; ?></td>
                  <td class="min-width-150"><?= $row['nama_poktan']?></td>
                  <td class="min-width-150"><?= $row['alamat']?></td>
                  <td><?= $row['email']?></td>
                  <td class="min-width-150"><?= $row['ketua']?></td>
                  <td><?= $row['sekretaris']?></td>
                  <td><?= $row['bendahara']?></td>
                  <td class="min-width-150"><?= $row['fullname']?></td>
                  <td class="min-width-120"><?= $row['jenis_mitra']?></td>
                  <td class="min-width-120"><?= $row['nama_komuditi']?></td>
                  <td class="min-width-120"><?= $row['nama_prov']?></td>
                  <td class="min-width-120"><?= $row['nama_kab']?></td>
                  <td class="min-width-120"><?= $row['nama_kec']?></td>
                  <td class="min-width-120"><?= $row['nama_desa']?></td>
                  <td class="min-width-150"><?= $row['nama_bank']?></td>
                  <td class="min-width-150"><?= $row['rek_cabang']?></td>
                  <td class="min-width-150"><?= $row['rek_nama']?></td>
                  <td><?= $row['rek_no']?></td>
                  <td><?= $row['tlp']?></td>
                  <td class="">
                    <?php foreach($tampil2 as $row2) : ?>
                    <?php if($row2['id_user'] == $row['id_staff']) : ?>
                    <?= $row2['nama_cabang']?><br/>
                  <?php endif; endforeach; ?></td>  
                  <td>
                    <?php if($row['aktif'] == 1): ?>
                      <i class="fas fa-check-circle icon-check"></i>
                    <?php else: ?>
                      <i class="fas fa-times-circle icon-uncheck"></i>
                    <?php endif; ?>
                  </td>
                  <td class="min-width-btn text-center"><a href="<?= base_url('poktan/ubah') ?>?id=<?=$row['id']?>"><button class="btn btn-success btn-sm">Edit</button></a> 
                  <?php if($row['aktif'] == 1): ?>
                    <a class="tombol-hapus" href="<?= base_url('poktan/delete') ?>/<?=$row['id']?>"><button class="btn btn-danger btn-sm">Delete</button></a>
                  <?php else: ?>
                    <a href="<?= base_url('poktan/aktif') ?>/<?=$row['id']?>"><button class="btn min-width-btn-59 btn-primary btn-sm">Aktif</button></a>
                  <?php endif; ?>
                  </td>
                </tr>
              <?php $i++ ?>  	
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- JS POKTAN -->
<script src="<?= base_url(); ?>assets/js/script_poktan.js"></script>
<!-- AKHIR JS POKTAN