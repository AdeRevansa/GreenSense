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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profil - <?php echo $d->kelompok ?></title>
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
              <a class="dropdown-item d-flex align-items-center" id="logout" href="logout.php">
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

    <li class="nav-item">
        <a class="nav-link collapsed" href="dashboard.php">
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

      <li class="nav-item ">
        <a class="nav-link " href="profil.php">
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
            <a href=history2.php">
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
      <h1>Profil</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
          <li class="breadcrumb-item active">Profil</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <img src="assets/img/<?php echo $d->foto ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $d->nama ?></h2>
              <div class="social-links mt-2">
                <a href="<?php echo $d->ig ?>" class="instagram"><i class="bi bi-instagram"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Ringkasan</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Ubah Profil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Password</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-logo">Ubah Logo</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
  
                  <h5 class="card-title">Tentang</h5>
                  <p class="small fst-italic"><?php echo $d->tentang ?></p>

                  <h5 class="card-title">Detail Profil</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nama</div>
                    <div class="col-lg-9 col-md-8"><?php echo $d->nama ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Nama TIM</div>
                    <div class="col-lg-9 col-md-8"><?php echo $d->kelompok ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                    <div class="col-lg-9 col-md-8"><?php echo $d->alamat ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">No. Telp</div>
                    <div class="col-lg-9 col-md-8"><?php echo $d->telp ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $d->email ?></div>
                  </div>
                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <?php if(isset($_POST['simpan']) ){
										$conn->autocommit(false);
										try{
											$foto_tmp = $_FILES['foto']['tmp_name'];
											$nama_foto = $_FILES['foto']['name'];
				
											$nama = addslashes($_POST['nama']);
											$about = addslashes($_POST['tentang']);
											$kel = addslashes($_POST['kelompok']);
											$foto = $nama_foto;
											$fotolawas = addslashes($_POST['fotolawas']);
											$alamat = addslashes($_POST['alamat']);
											$telp = addslashes($_POST['telp']);
											$email = addslashes($_POST['email']);
											$ig = addslashes($_POST['ig']);
											
											if($nama_foto==""){
												mysqli_query($conn, "UPDATE users SET `foto` = '".$fotolawas."', `nama` = '".$nama."', `tentang` = '".$about."', `kelompok` = '".$kel."',  `alamat` = '".$alamat."', `telp` = '".$telp."', `email` = '".$email."', `ig` = '".$ig."' ");
												$conn->commit();
												?>
												<script>
												Swal.fire({
													title: 'Berhasil!',
													text: 'Edit Profil Berhasil.',
													icon: 'success'
												}).then((result) => {
													window.location="profil.php";
												})
												</script>
												<?php
											}else{
												mysqli_query($conn, "UPDATE users SET `foto` = '".$foto."', `nama` = '".$nama."', `tentang` = '".$about."', `kelompok` = '".$kel."',  `alamat` = '".$alamat."', `telp` = '".$telp."', `email` = '".$email."', `ig` = '".$ig."' ");
												$check_upload = move_uploaded_file($foto_tmp, './assets/img/' . $nama_foto);
												$conn->commit();
												?>
												<script>
												Swal.fire({
													title: 'Berhasil!',
													text: 'Edit Profil Berhasil. ',
													icon: 'success'
												}).then((result) => {
													window.location="profil.php";
												})
												</script>
												<?php
											}
										}catch(Exception $e){
											$conn->rollback();
											$response['message'] = $e->getMessage();
											echo "<script>
											alert('Ubah Profil Gagal!'); 
											</script>";
										}
									}
                
                  ?>
                  <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profil</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="assets/img/<?php echo $d->foto ?>"  alt="Profile">
                        <div class="pt-2">
                          <a><input type="file" name="foto"></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fotolawas" class="col-md-4 col-lg-3 col-form-label">Foto</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fotolawas" type="text" Readonly class="form-control" id="fotolawas" value="<?php echo $d->foto ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nama" type="text" class="form-control" id="nama" value="<?php echo $d->nama ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="tentang" class="col-md-4 col-lg-3 col-form-label">Tentang</label>
                      <div class="col-md-8 col-lg-9">
                        <textarea name="tentang" class="form-control" id="tentang" style="height: 100px"><?php echo $d->tentang ?></textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="kelompok" class="col-md-4 col-lg-3 col-form-label">Nama TIM</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="kelompok" type="text" class="form-control" id="kelompok" value="<?php echo $d->kelompok ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="alamat" type="text" class="form-control" id="alamat" value="<?php echo $d->alamat ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="telp" class="col-md-4 col-lg-3 col-form-label">No. Telp</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="telp" type="text" class="form-control" id="telp" value="<?php echo $d->telp ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="<?php echo $d->email ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="ig" class="col-md-4 col-lg-3 col-form-label">Instagram</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="ig" type="text" class="form-control" id="ig" value="<?php echo $d->ig ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                  </form><!-- End Profile Edit Form -->
                </div>

  <div class="tab-pane fade pt-3" id="profile-change-password">
    <!-- Change Password Form -->
    <form action="" method="POST">

        <div class="row mb-3">
            <label for="pass1" class="col-md-4 col-lg-3 col-form-label">Kata Sandi Baru</label>
            <div class="col-md-8 col-lg-9">
                <div class="input-group">
                    <input name="pass1" type="password" class="form-control" id="pass1" required>
                    <!-- Tambahkan icon mata untuk menampilkan/menyembunyikan kata sandi -->
                    <span class="input-group-text" id="pass1Toggle" onclick="togglePassword('pass1')">
                        <i class="bi bi-eye" id="pass1Icon"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="pass2" class="col-md-4 col-lg-3 col-form-label">Konfirmasi Kata Sandi Baru</label>
            <div class="col-md-8 col-lg-9">
                <div class="input-group">
                    <input name="pass2" type="password" class="form-control" id="pass2" required>
                    <!-- Tambahkan icon mata untuk menampilkan/menyembunyikan kata sandi -->
                    <span class="input-group-text" id="pass2Toggle" onclick="togglePassword('pass2')">
                        <i class="bi bi-eye" id="pass2Icon"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" name="ubah_password" class="btn btn-primary">Simpan</button>
        </div>
    </form><!-- End Change Password Form -->

    <?php
    if (isset($_POST['ubah_password'])) {
        $pass1  = $_POST['pass1'];
        $pass2  = $_POST['pass2'];

        if ($pass2 != $pass1) {
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Konfirmasi Kata sandi Baru Tidak Sesuai!',
                })
            </script>
        <?php
    } else {
        $u_pass = mysqli_query($conn, "UPDATE users SET
                            password = '" . MD5($pass1) . "'
                            WHERE idUser = '" . $d->idUser . "'");
        if ($u_pass) {
            ?>
                <script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Ubah Kata sandi Berhasil!',
                        icon: 'success'
                    }).then((result) => {
                        window.location = "profil.php";
                    })
                </script>
            <?php
        } else {
            ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'gagal'
                    }).then((result) => {
                        window.location = "profil.php";
                    })
                </script>
    <?php
      }
      }
      }
      ?>
      </div>

      <script>
          function togglePassword(passId) {
              var pass = document.getElementById(passId);
              var icon = document.getElementById(passId + 'Icon');

              if (pass.type === "password") {
                  pass.type = "text";
                  icon.classList.remove('bi-eye');
                  icon.classList.add('bi-eye-slash');
              } else {
                  pass.type = "password";
                  icon.classList.remove('bi-eye-slash');
                  icon.classList.add('bi-eye');
              }
          }
      </script>


                <div class="tab-pane fade profile-change-logo pt-3" id="profile-change-logo">
                  <!-- Profile Edit Form -->
                  <?php if(isset($_POST['simpan2']) ){
										$conn->autocommit(false);
										try{
											$foto_tmp = $_FILES['foto']['tmp_name'];
											$nama_logo = $_FILES['foto']['name'];
				
											$logo = $nama_logo;
											$logolawas = addslashes($_POST['logolawas']);
											if($nama_logo==""){
												mysqli_query($conn, "UPDATE users SET `logo` = '".$logolawas."' ");
												$conn->commit();
												?>
												<script>
												Swal.fire({
													title: 'Berhasil!',
													text: 'Edit Logo Berhasil.',
													icon: 'success'
												}).then((result) => {
													window.location="profil.php";
												})
												</script>
												<?php
											}else{
												mysqli_query($conn, "UPDATE users SET `logo` = '".$logo."' ");
												$check_upload = move_uploaded_file($foto_tmp, './assets/img/' . $nama_logo);
												$conn->commit();
												?>
												<script>
												Swal.fire({
													title: 'Berhasil!',
													text: 'Edit Logo Berhasil. ',
													icon: 'success'
												}).then((result) => {
													window.location="profil.php";
												})
												</script>
												<?php
											}
										}catch(Exception $e){
											$conn->rollback();
											$response['message'] = $e->getMessage();
											echo "<script>
											alert('Ubah Logo Gagal!'); 
											</script>";
										}
									}
                
                  ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="logoImage" class="col-md-4 col-lg-3 col-form-label">Logo</label>
                      <div class="col-md-8 col-lg-9" width="150px" height="150px">
                        <img src="assets/img/<?php echo $d->logo ?>"  alt="Logo">
                        <div class="pt-2">
                          <a><input type="file" name="logo"></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="logolawas" class="col-md-4 col-lg-3 col-form-label">Nama Logo</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="logolawas" type="text" Readonly class="form-control" id="logolawas" value="<?php echo $d->logo ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" name="simpan2" class="btn btn-primary">Simpan</button>
                  </div>
                </form>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
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