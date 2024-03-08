<?php
 	session_start();
	$timeout = 1; // setting timeout dalam menit
	$logout = "index.php"; // redirect halaman logout

	$timeout = $timeout * 300; // menit ke detik
	if(isset($_SESSION['start_session'])){
		$elapsed_time = time()-$_SESSION['start_session'];
		if($elapsed_time >= $timeout){
			session_destroy();
			echo "<script type='text/javascript'>alert('Sesi telah berakhir');window.location='$logout'</script>";
		}
	}

	$_SESSION['start_session']=time();

	include('config.php');
	if($_SESSION['status_login'] != true){
		echo '<script>window.location="index.php"</script>';
	}

  $query = mysqli_query($conn, "SELECT * FROM users WHERE idUser = '".$_SESSION['idUser']."' ");
	$d = mysqli_fetch_object($query);
?>
<script>
    setTimeout(function () {
        location.reload(); // Halaman akan diperbarui
    }, 5000); // Refresh setiap 5 detik (5000 milidetik)
</script>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - <?php echo $d->kelompok ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<script src="dist/sweetalert2.all.min.js"></script>

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block"><?php echo $d->kelompok ?></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/<?php echo $d->foto ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $d->nama ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $d->nama ?></h6>
              <!-- <span>Web Designer</span> -->
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profil.php">
                <i class="bi bi-person"></i>
                <span>Profilku</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profil.php">
                <i class="bi bi-gear"></i>
                <span>Pengaturan Akun</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="https://wa.wizard.id/c5da7d">
                <i class="bi bi-question-circle"></i>
                <span>Butuh Bantuan?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php" id="logout" >
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->

        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item active">
        <a class="nav-link " href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      
      <li class="nav-item active">
        <a class="nav-link collapsed" href="espcam.php">
          <i class="bi bi-image"></i>
          <span>Foto Monitoring</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="profil.php">
          <i class="bi bi-person"></i>
          <span>Profil</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Riwayat</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="history.php" class="">
              <i class="bi bi-circle"></i><span>Data Monitoring</span>
            </a>
          </li>
          <li>
            <a href="history2.php">
              <i class="bi bi-circle"></i><span>Penyiraman</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" id="logout" href="logout.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Keluar</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
      
            <!-- Sales Card -->
<div class="col-xxl-4 col-md-6">
  <div class="card info-card sales-card">
    <?php
    $cek1 = mysqli_query($conn,"SELECT * FROM data_monitoring ORDER BY tanggal DESC LIMIT 1");
    while($tampil1 = mysqli_fetch_assoc($cek1)){		
      $no = $tampil1['no'];
      $tanggal = $tampil1['tanggal'];
      $suhu = $tampil1['suhu'];
    ?>
      <?php
      // Jika suhu NaN, ambil data terakhir dengan suhu yang valid
      $last_valid_suhu_query = mysqli_query($conn, "SELECT suhu FROM data_monitoring WHERE NOT suhu = 'nan' ORDER BY tanggal DESC LIMIT 1");
      $last_valid_suhu_row = mysqli_fetch_assoc($last_valid_suhu_query);
      $last_valid_suhu = $last_valid_suhu_row['suhu'];
      if($suhu < 35 && !is_nan($suhu)){
      ?>
        <div class="card-body">
          <h5 class="card-title text-primary">Suhu Aman <span>| Terbaru</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-thermometer-half"></i>
            </div>
            <div class="ps-3">
              <h6><?php echo $suhu ?></h6>
            </div>
          </div>
        </div>
      <?php 
      } else {
        // Jika suhu NaN, ambil data terakhir dengan suhu yang valid
        $last_valid_suhu_query = mysqli_query($conn, "SELECT suhu FROM data_monitoring WHERE NOT suhu = 'nan' ORDER BY tanggal DESC LIMIT 1");
        $last_valid_suhu_row = mysqli_fetch_assoc($last_valid_suhu_query);
        $last_valid_suhu = $last_valid_suhu_row['suhu'];
      ?>
        <div class="card-body">
          <h5 class="card-title text-danger">Suhu terlalu tinggi <span>| Terbaru</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center text-danger">
              <i class="bi bi-thermometer-half "></i>
            </div>
            <div class="ps-3">
              <h6><?php echo $last_valid_suhu ?></h6>
            </div>
          </div>
        </div>
      <?php 
      } 
      ?>
    <?php 
    } 
    ?>
  </div>
</div><!-- End Sales Card -->

           <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
              <?php
                  $cek1 = mysqli_query($conn,"SELECT * FROM data_monitoring ORDER BY tanggal DESC LIMIT 1");
                  $cek2 = mysqli_query($conn,"SELECT AVG(kelembapan) FROM data_monitoring;");
                  while($tampil1 = mysqli_fetch_assoc($cek1)){		
                    $no = $tampil1['no'];
                    $tanggal = $tampil1['tanggal'];
                    $temp = $tampil1['kelembapan'];
                ?>
                <?php
                // Jika suhu NaN, ambil data terakhir dengan suhu yang valid
                $last_valid_lembap_query = mysqli_query($conn, "SELECT kelembapan FROM data_monitoring WHERE NOT kelembapan = 'nan' ORDER BY tanggal DESC LIMIT 1");
                $last_valid_lembap_row = mysqli_fetch_assoc($last_valid_lembap_query);
                $last_valid_lembap = $last_valid_lembap_row['kelembapan'];
                  if($temp < 70 && !is_nan($temp)){
                ?>
                <div class="card-body">
                  <h5 class="card-title text-primary">Kelembapan Terjaga <span>| Terbaru</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle text-primary d-flex align-items-center justify-content-center">
                      <i class="bi bi-thermometer-half text-primary"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $last_valid_lembap ?></h6>
                    </div>
                  </div>
                </div>
                <?php
                  }else{
                    // Jika suhu NaN, ambil data terakhir dengan suhu yang valid
                $last_valid_lembap_query = mysqli_query($conn, "SELECT kelembapan FROM data_monitoring WHERE NOT kelembapan = 'nan' ORDER BY tanggal DESC LIMIT 1");
                $last_valid_lembap_row = mysqli_fetch_assoc($last_valid_lembap_query);
                $last_valid_lembap = $last_valid_lembap_row['kelembapan'];
                    ?>
                    <div class="card-body">
                  <h5 class="card-title text-danger">Kelembapan terlalu tinggi <span>| Terbaru</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle text-danger d-flex align-items-center justify-content-center">
                      <i class="bi bi-thermometer-half text-danger"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $last_valid_lembap ?></h6>
                    </div>
                  </div>
                </div>
                <?php
                  }
                ?>
                <?php } ?>
              </div>
            </div><!-- End Revenue Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
              <?php
                  $cek1 = mysqli_query($conn,"SELECT * FROM data_monitoring ORDER BY tanggal DESC LIMIT 1");
                  while($tampil1 = mysqli_fetch_assoc($cek1)){		
                    $no = $tampil1['no'];
                    $tanggal = $tampil1['tanggal'];
                    $ph = $tampil1['status_tanah'];
                ?>
                <?php
                  if($ph > 85){
                ?>
                <div class="card-body">
                  <h5 class="card-title text-primary">Tanah Basah <span>| Terbaru</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle text-primary d-flex align-items-center justify-content-center">
                      <i class="bi bi-thermometer-half text-primary"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $ph ?></h6>
                      <span class="text-success small pt-1 fw-bold">
                    </div>
                  </div>
                </div>
                <?php
                  }else{
                    ?>
                    <div class="card-body">
                  <h5 class="card-title text-danger">Tanah Kering <span>| Terbaru</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle text-danger d-flex align-items-center justify-content-center">
                      <i class="bi bi-thermometer-half text-danger"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $ph ?></h6>
                      <span class="text-success small pt-1 fw-bold">
                    </div>
                  </div>
                </div>
                <?php
                  }
                ?>
                <?php } ?>
              </div>
            </div><!-- End Revenue Card -->

            <?php
            $cek = mysqli_query($conn,"SELECT * FROM deteksi ORDER BY tanggal DESC LIMIT 1");
            while($tampil1 = mysqli_fetch_assoc($cek)){		
              $kategori = $tampil1['kategori'];
            if($kategori == "mati"){    
              ?>
            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
              
                <div class="card-body">
                  <h5 class="card-title text-primary">Lampu Mati <span>| Terbaru</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle text-primary d-flex align-items-center justify-content-center">
                      <i class="bi bi-lightbulb-off text-primary"></i>
                    </div>
                    <div class="ps-3">
                      <h6>Lampu Mati</h6>
                    </div>
                  </div>
                </div>
                
              </div>
            </div><!-- End Revenue Card -->
            <?php 
            }else{
              ?>
            <div class="col-xl col-md-6">
              <div class="card info-card revenue-card">
              
                <div class="card-body">
                  <h5 class="card-title text-danger">Lampu Menyala <span>| Terbaru</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle text-danger d-flex align-items-center justify-content-center">
                      <i class="bi bi-lightbulb-fill text-danger"></i>
                    </div>
                    <div class="ps-3">
                      <h6>Lampu Menyala</h6>
                    </div>
                  </div>
                </div>
                
              </div>
            </div><!-- End Revenue Card -->
            <?php } ?>
            <?php } 
            ?>

            <?php
            $cek = mysqli_query($conn,"SELECT * FROM data_penyiraman ORDER BY tanggal DESC LIMIT 1");
            while($tampil1 = mysqli_fetch_assoc($cek)){		
              $kategori = $tampil1['kategori_pompa'];
            if($kategori == "Pompa Mati"){    
              ?>
            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
              
                <div class="card-body">
                  <h5 class="card-title text-primary">Pompa Mati <span>| Terbaru</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle text-primary d-flex align-items-center justify-content-center">
                      <i class="bi bi-lightbulb-off text-primary"></i>
                    </div>
                    <div class="ps-3">
                      <h6>Pompa Mati</h6>
                    </div>
                  </div>
                </div>
                
              </div>
            </div><!-- End Revenue Card -->
            <?php 
            }else{
              ?>
            <div class="col-xl col-md-6">
              <div class="card info-card revenue-card">
              
                <div class="card-body">
                  <h5 class="card-title text-danger">Pompa Menyala <span>| Terbaru</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle text-danger d-flex align-items-center justify-content-center">
                      <i class="bi bi-lightbulb-fill text-danger"></i>
                    </div>
                    <div class="ps-3">
                      <h6>Pompa Menyala</h6>
                    </div>
                  </div>
                </div>
                
              </div>
            </div><!-- End Revenue Card -->
            <?php }}?>
      </div>
    </section>

    

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>GreenSense</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="jquery.js"></script>
    <script>
      $(document).on('click', '#logout', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Anda akan Keluar!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Keluar Saja!',
          cancelButtonText: 'Batal'
          }).then((result) => {
          if (result.isConfirmed) {
            window.location ='index.php';				
          }
        })
      })
    </script>
  
</body>
</html>