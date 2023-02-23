<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-top-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Petani</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">260 Orang</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-top-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Poktan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">16 Poktan</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-top-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tanam</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">6 Tanam</div>
                </div>
                <div class="col">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-top-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Kunjungan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">2 Kunjungan</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow">
              <div class="card-header m-0 font-weight-bold text-info">
                Lahan Pertanian PT. Sumber Energi Pangan (SEP)
              </div>
              
              <div class="card-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  </ol>
                  
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <img class="d-block w-100" src="<?= base_url('assets/img/bg2.jpg') ?>" alt="First slide">
                    </div>
                    
                    <div class="carousel-item">
                      <img class="d-block w-100" src="<?= base_url('assets/img/g2.png') ?>" alt="Second slide">
                    </div>
                    
                    <div class="carousel-item">
                      <img class="d-block w-100" src="<?= base_url('assets/img/g1.jpg') ?>" alt="Third slide">
                    </div>
                  </div>

                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>

                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
          </div>
      </div>

<div class="col-lg-3">
  <div class="card shadow">
    <div class="card-header m-0 font-weight-bold text-info">
      Latest News
    </div>
    
    <div class="card-body">
      <div class="recent-post">
        <table class="w-100">
          <tbody>
            <tr>
              <td>
                <img src="https://apollo-singapore.akamaized.net/v1/files/wiqu71nrrjqe-ID/image;s=966x691;olx-st/_1_.jpg">
                <a href="">
                <h1>Lahan E4</h1>
                <p>300 Hektar</p>
                </a>
              </td>
            </tr>
          <tr>
          <td>
            <img src="<?= base_url('assets/img/g0.jpg') ?>">
            <a href="">
            <h1>Lahan T6</h1>
            <p>160 Hektar</p>
            </a>
          </td>
        </tr>
        
        <tr>
           <td>
              <img src="https://apollo-singapore.akamaized.net/v1/files/wiqu71nrrjqe-ID/image;s=966x691;olx-st/_1_.jpg">
              <a href="">
              <h1>Lahan E4</h1>
              <p>300 Hektar</p>
              </a>
          </td>
         </tr>
        
        </div>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

     