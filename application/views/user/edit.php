<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <div class="row">
    <!-- Earnings (Monthly) Card Example -->
      <div class="col-lg-6 mb-4">
        <div class="card border-top-success shadow h-100 py-2">
          <div class="card-body">
            <?= $this->session->flashdata('message_ava'); ?>
            <?= form_open_multipart('edit/ubahData'); ?>
              <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                  </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Full name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['fullname']; ?>">
                    <?= form_error('name','<small class="text-danger">','</small>'); ?>
                  </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-2">Picture</div>
                  <div class="col-sm-10">
                    <div class="row">
                      <div class="col-sm-4">
                        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                    </div>
                    <div class="col-sm-8">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                    </div>
                 </div>
               </div>
             </div>
              <div class="float-right mt-4">
                <button type="submit" class="btn btn-success">Edit Profile</button>
              </div>
            </form>
        </div>

      </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
         
      <div class="col-lg-6 mb-4">
        <div class="card border-top-success shadow h-100 py-2">
          <div class="card-body">
            <?= $this->session->flashdata('message'); ?>
            <form action="<?= base_url('edit/changepassword');?>" method="post">
              <div class="form-group">
                <label for="current_password">Password Lama</label>
                <input type="password" class="form-control" id="current_password" name="current_password">
                <?= form_error('current_password','<small class="text-danger">','</small>'); ?>
              </div>

              <div class="form-group">
                <label for="new_password1">Password Baru</label>
                <input type="password" class="form-control" id="new_password1" name="new_password1">
                <?= form_error('new_password1','<small class="text-danger">','</small>'); ?>
              </div>

              <div class="form-group">
                <label for="new_password2">Ulangi Password</label>
                <input type="password" class="form-control" id="new_password2" name="new_password2">
                 <?= form_error('new_password2','<small class="text-danger">','</small>'); ?>
              </div>

              <div class="float-right">
                <button type="submit" class="btn btn-success">Change Password</button>
              </div>
            </form>
        </div>
      </div>

    </div>
    </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

     