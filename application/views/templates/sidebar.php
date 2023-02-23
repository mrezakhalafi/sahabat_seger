<!-- Sidebar -->
<ul class="navbar-nav bg-optional sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
    <div class="sidebar-brand-icon rotate-n-15">
    </div>
    <div class="sidebar-brand-text mx-3" style="font-size:18px ;"> <?= $trole['nama_role'] ?></div>
  </a>

<!--   <hr class="sidebar-divider">  -->   
</form>

<!-- Divider -->
<!-- <div class="">
  <?php 
  $link ='<script>location.pathname == base_url+"admin/index"</script>';
  $link_salah ='<script>location.pathname == base_url+"admin/tampildatauser"</script>';
  ?>
  <?php if ($link): ?>
    <li class="nav-item">
  <?php elseif ($link_salah): ?>
    <li class="nav-item">
  <?php endif; ?>
     <a class="nav-link pb-0 pt-0" href="<?= base_url('admin') ?>">
     <i class="fas fa-home"></i>
     <span>Home</span></a>
    </li>    
  </div> -->
  
  <hr class="sidebar-divider">
  <!-- Query menu -->
  <?php 
  $id_role = $this->session->userdata('id_role');
      $queryMenu = "SELECT tb_kategori_menu.* 
                      FROM `tb_kategori_menu`
                     WHERE `aktif` = 1
                       AND (SELECT count(user_access_menu.id)
                              FROM user_access_menu
                             INNER JOIN tb_menu ON tb_menu.id = user_access_menu.id_menu
                             WHERE user_access_menu.id_role = ".$id_role."
                               AND tb_menu.aktif = 1
                               AND user_access_menu.id_kategori = tb_kategori_menu.id) > 0
      ";

      $menu = $this->db->query($queryMenu)->result_array();   
  ?>

 <!-- LOOPING MENU -->
 <?php foreach ($menu as $m): ?>
  <div class="sidebar-heading">
    <?= $m['kategori_menu']; ?>
  </div>
<?php ?>

  <!-- SIAPKAN SUBMENU SESUAI MENU -->
  <?php
  $menuId = $m['id'];
    $querySubMenu = "SELECT * FROM `tb_menu` JOIN `user_access_menu` ON `tb_menu`.`id` = `user_access_menu`.`id_menu` WHERE `user_access_menu`.`id_role` = $id_role AND `parent` = $menuId AND `aktif` = 1 ORDER BY `tb_menu`.`no_urut` ASC
      ";
  $subMenu = $this->db->query($querySubMenu)->result_array();
  ?>

  <?php foreach($subMenu as $sm):?>
    <!-- Nav Item - Dashboard -->
    <?php if ($title == $sm['title']): ?>
      <li class="nav-item active">
    <?php else: ?>
      <li class="nav-item">
    <?php endif; ?>
    <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
      <i class="<?= $sm['icon']; ?>"></i>
      <span><?= $sm['title']; ?></span>
    </a>
  </li>
  
  <?php endforeach; ?>

<!-- Divider -->
<hr class="sidebar-divider mt-3">
<?php endforeach; ?>
 <!-- Nav Item - Charts -->
<!--   <li class="nav-item">
    <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
      <i class="fas fa-fw fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li> -->
  <!-- Divider -->
<!--   <hr class="sidebar-divider d-none d-md-block"> -->
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
<!-- End of Sidebar -->