<!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
      <div class="float-left">
        <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
      </div>
      <div class="row float-right mb-3">  
        <div class="col">
          <a href="<?= base_url('poktantanam/tambah'); ?>"><button class="btn btn-kirana tanamstaff"><i class="fas fa-user-plus"></i> Tambah Data Poktan Tanam</button></a>
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
                <div class="col-3">
                  <div class="form-group">
                    <label><strong>Poktan</strong></label>
                    <select class="form-control custom-select select2" name="id_poktan" id="id_poktan_poktanam" data-placeholder="Pilih Poktan" data-multiple="true" multiple>
                      <option value="">Pilih Poktan</option> 
                     
                      <?php foreach ($poktan as $row3): ?>
                      <?php if ($row3['nama_poktan']!=$old) : ?>
                      <option value="<?= $row3['id'] ?>" <?php echo set_select('id_poktan_poktanam',$row3['id']); ?>><?= $row3['nama_poktan'] ?></option>
                      <?php $old = $row3['nama_poktan'] ?>
                      <?php else: endif; ?>
                    <?php endforeach; ?>

                    </select>
                  </div>
                </div>
    
                
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                </div>
              </div>
              <table class="table table-striped table-responsive" id="tb_poktantanam">
                <thead class="bar-table">
                  <th>No</th>
                  <th class="min-width-120">Tanggal Tanam</th>
                  <th class="min-width-120">Tanggal Panen</th>
                  <th class="min-width-150">Nama Poktan</th>
                  <th class="min-width-120">Nama Staff</th>
                  <th class="min-width-120">Nama Plant</th>
                  <th class="min-width-150">Status</th>                    
                  <th class="">Aktif</th>
                  <th class="min-width-150">Action</th>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($tampil as $row): ?>
                  <tr>   
                    <td><?= $i; ?></td>         
                    <?php $timestamp = strtotime($row['tgl_tanam']); ?>
                    <?php $timestamp2 = strtotime($row['tgl_panen']); ?>
                    
                    <?php $date1 = $row['tgl_tanam'];
                          $date2 = date('y-m-d');
                          $diff = strtotime($date2) - strtotime($date1);
                          $days = floor($diff/ (60*60*24));
                          $hasil = $days/120*100;
                    ?>
                    <td class="min-width-120"><?= date('d-m-Y', $timestamp); ?></td>
                    <td class="min-width-120"><?= date('d-m-Y', $timestamp2); ?></td>
                    <td class="min-width-150"><?= $row['nama_poktan']?></td>
                    <td class=""><?= $row['fullname']?></td>

                    <td class="">

                    <?php foreach($tampil2 as $row2) : ?>
                    <?php if($row2['id_user'] == $row['staff']) : ?>
                    <?= $row2['nama_cabang']?><br/>
                    
                  <?php endif; endforeach; ?></td>  
                    <td class="min-width">
                      <div class="progress progress-bar mr-2">
                        <div class="progress-bar bg-<?php if($hasil>=50&&$hasil<=99){ ?>success<?php }elseif($hasil<=50&&$hasil>=0){ ?>warning<?php }elseif($hasil<0){?><?php }elseif($hasil>100){ ?>primary <?php } ?> prosesbar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?= $hasil ?>%">
                        </div>
                      </div><small><?php if($days>=120): ?>
                        120
                        <?php elseif($days<0): ?>
                          0
                        <?php else: ?>
                        <?= $days ?>
                        <?php endif; ?>
                        /120 hari (
                        <?php if($hasil>=100): ?>
                        100% )
                        <?php elseif($hasil<0): ?>
                        0% )
                        <?php else: ?>
                          <?=round($hasil)?>% )
                          <?php endif; ?></small>
                        
                    </td>  
                    <td class="text-center">
                    <?php if($row['aktif'] == 1): ?>
                      <i class="fas fa-check-circle icon-check"></i>
                    <?php else: ?>
                      <i class="fas fa-times-circle icon-uncheck"></i>
                    <?php endif; ?>
                    </td>
                    <td class="min-width-btn text-center">

                      <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <?php if($days>=120): ?>
                          <a class="dropdown-item" href="#" onclick="showmodalpoktantanam120('<?= $row['id']; ?>');">Detail</a>
                          <?php else: ?>
                          <a class="dropdown-item" href="#" onclick="showmodalpoktantanam('<?= $row['id']; ?>');">Detail</a>
                          <?php endif; ?> 
                          <a class="dropdown-item" href="<?= base_url('poktantanam/ubahpoktanTanam') ?>?id=<?=$row['id']?>" onclick="pilihdatapoktanTanam('<?= $row['id']; ?>');">Edit</a>
                          <?php if($row['aktif'] == 1): ?>
                          <a class="dropdown-item tombol-hapus" href="<?= base_url('poktantanam/delete') ?>/<?=$row['id']?>">Delete</a>
                          <?php else: ?>
                          <a class="dropdown-item" href="<?= base_url('poktantanam/aktif') ?>/<?=$row['id']?>">Aktif</a>
                          <?php endif; ?>

                          <?php if($days>=120): ?>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#" onclick="showmodalhasil('<?= $row['id']; ?>');">Tambah Hasil</a>
                          <a class="dropdown-item" href="#" onclick="showmodalhasiledit('<?= $row['id']; ?>');">Edit Hasil</a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php $i++ ?>   
                <?php endforeach; ?>
              </tbody>
            </table>
            </div>
              <div class="col-lg-3" style="margin-left: 20px">
                <div class="wrapper-info">
                  <div class="row">
                    <h6><strong>Keterangan :</strong></h6>
                  </div>
                                    <div class="row">
                    <div class="circular-info bg-warning mr-2"></div><p style="margin-top: -4px">On Progress (<50%)</p>
                  </div>
                  <div class="row mt-1">
                    <div class="circular-info bg-success mr-2"></div><p style="margin-top: -4px">On Progress (>50%)</p>
                  </div>
                   <div class="row mt-1">
                    <div class="circular-info bg-primary mr-2"></div><p style="margin-top: -4px">Selesai (100%)</p>
                  </div>


       <!--            <div class="row">
                    <div class="circular-info bg-danger mr-2"></div><p style="margin-top: -4px">Belum mulai</p>
                  </div> -->
                </div>
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Modal POKTAN TANAM -->
<div class="modal fade" id="modalpoktantanam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Poktan Tanam</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <table>
          <tbody>
            <tr>
              <td><strong>Tanggal Tanam</strong></td>
              <td>:</td>
              <td><span id="tgl_tanam_p"></span></td>
            </tr>
            <tr>
              <td><strong>Tanggal Panen</strong></td>
              <td>:</td>
              <td><span id="tgl_panen"></span></td>
            </tr>
            <tr>
              <td><strong>Luas Tanam</strong></td>
              <td>:</td>
              <td><span id="luas_tanam"></span></td>
            </tr>
            <tr>
              <td><strong>Pengairan 1</strong></td>
              <td>:</td>
              <td><span id="pengairan1"></span></td>
            </tr>
            <tr>
              <td><strong>Pemupukan 1</strong></td>
              <td>:</td>
              <td><span id="pemupukan1"></span></td>
            </tr>
            <tr>
              <td><strong>Penjarangan:</strong></td>
              <td>:</td>
              <td><span id="penjarangan"></span></td>
            </tr>
            <tr>
              <td><strong>Penyiangan</strong></td>
              <td>:</td>
              <td><span id="penyiangan"></span></td>
            </tr>
            <tr>
              <td><strong>Penyakit</strong></td>
              <td>:</td>
              <td><span id="penyakit"></span></td>
            </tr>
            <tr>
              <td><strong>Deskripsi Penyakit</strong></td>
              <td>:</td>
              <td><span id="penyakit_description"></span></td>
            </tr>
            <tr>
              <td><strong>Pengairan 2</strong></td>
              <td>:</td>
              <td><span id="pengairan2"></span></td>
            </tr>
            <tr>
              <td><strong>Pemupukan 2</strong></td>
              <td>:</td>
              <td><span id="pemupukan2"></span></td>
            </tr>
            <tr>
              <td><strong>Pengairan 3</strong></td>
              <td>:</td>
              <td><span id="pengairan3"></span></td>
            </tr>
            <tr>
              <td><strong>Prediksi Tonase</strong></td>
              <td>:</td>
              <td><span id="prediksi_tonase"></span></td>
            </tr> 
            <tr>
              <td><strong>Hasil Panen</strong></td>
              <td>:</td>
              <td><span id="hasil_panen"></span></td>
            </tr>
            <tr>
              <td><strong>Kadar Air</strong></td>
              <td>:</td>
              <td><span id="kadar_air"></span></td>
            </tr>
            </div> 
          </tbody>
        </table>
     
        <table>
          <tbody>
            
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- AKHIR Modal POKTAN TANAM -->

<!-- Modal HASIL POKTAN TANAM -->
<div class="modal fade" id="modalhasil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-tambah-hasil" id="exampleModalLabel">Tambah Hasil Panen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <form id="form-tambah-hasil" action="<?= base_url('poktantanam/tambahhasil'); ?>" method="post">
      <div class="modal-body">
            <input type="hidden" name="id_lahan" id="id_lahan">
          <input type="hidden" name="id_tanam" class="id_tanam">
            <div class="form-group">
              <label for="luas_tanam2"><strong>Luas Tanam</strong></label>
              <input type="text" name="luas_tanam2" class="form-control" id="luas_tanam2" readonly>
            </div>
            <div class="form-group">
              <label for="hasil_panen"><strong>Hasil Panen</strong></label>
              <input type="text" name="hasil_panen" class="form-control hasil_panen">
            </div>
            <div class="form-group">
              <label for="kadar_air"><strong>Kadar Air</strong></label>
              <input type="text" name="kadar_air" class="form-control kadar_air">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="check()" type="button" id="btn-tambah" class="btn btn-kirana btn-tambah">Tambah</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- AKHIR Modal HASIL POKTAN TANAM -->

<script>
  localStorage.setItem('luas',"");
</script>


<!-- JS POKTANTANAM -->
<script src="<?= base_url(); ?>assets/js/script_poktantanam.js"></script>
<!-- AKHIR JS POKTANTANAM -->
