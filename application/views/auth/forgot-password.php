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
            <i class="fas fa-unlock" style="margin-right: 6px;"></i>Lupa Password
            </a>
          </li>
        </ul>
      </div>
  </nav>
  <div class="row justify-content-center">
    <div class="col-lg-5">
      <div class="card border-0 shadow-lg my-5" id="form">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg">
              <div class="pl-5 pr-5 pb-3 pt-4">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Lupa Password?</h1>
                </div>
                <?= $this->session->flashdata('message'); ?>
                <form class="user" action="<?= base_url('auth/forgotpassword'); ?>" method="post">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                       <?= form_error('email','<small class="text-danger pl-3">','</small>'); ?> 
                  </div>
                  <button type="submit" class="btn btn-kirana btn-user btn-block">
                  Reset Password
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

  
