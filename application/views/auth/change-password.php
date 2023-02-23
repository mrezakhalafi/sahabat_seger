<div class="container" >
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#"><img class="" style="width: 160px; height: auto;" src="<?= base_url('assets/img/sep.png') ?>"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a href="<?= base_url(); ?>auth" class="nav-link">
            <i class="fas fa-unlock" style="margin-right: 6px;"></i>Ubah Password
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="row justify-content-center">
    <div class="col-lg-5">
      <div class="card o-hidden border-0 shadow-lg my-5" id="form">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg">
              <div class="pl-5 pr-5 pb-3 pt-4">
                <div class="text-center">
                  <h1 class="h4 text-gray-900">Ubah Password</h1>
                  <h5 class=""><?= $this->session->userdata('reset_email'); ?></h5>
                </div>
                <?= $this->session->flashdata('message'); ?>
                <form class="user" action="<?= base_url('auth/changepassword'); ?>" method="post">
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Masukan password baru" value="">
                     <?= form_error('password1','<small class="text-danger pl-3">','</small>'); ?> 
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Ulangi password..." value="">
                     <?= form_error('password2','<small class="text-danger pl-3">','</small>'); ?> 
                  </div>
                  <button type="submit" class="btn btn-kirana btn-user btn-block">
                    Ubah Password
                  </button>
                </form>
                <hr>
                <div class="text-center">
                  <a class="small" href="<?= base_url('auth'); ?>">Kembali ke halaman login</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  
