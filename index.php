<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - GreenSense</title>
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

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">GreenSense</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-1">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Masuk ke Akun Anda</h5>
                    <p class="text-center small">Masukkan Nama Pengguna dan Kata Sandi Anda!</p>
                  </div>

                  <form action="" method="POST" class="row g-3 needs-validation" novalidate>
              <div class="input-group has-validation">
                  <div class="col-12">
                      <label for="yourUsername" class="form-label">Nama Pengguna :</label>
                      <input type="text" name="user" id="nama" class="form-control" autocomplete="off" required></br>
                      <div class="invalid-feedback">Silahkan Masukkan Nama Pengguna!.</div>
                  </div>
              </div>

              <div class="col-12">
                  <label for="yourPassword" class="form-label">Kata Sandi :</label>
                  <div class="input-group">
                      <input type="password" name="pass" id="pass" class="form-control" autocomplete="off" required>
                      <!-- Tambahkan icon mata untuk menampilkan/menyembunyikan kata sandi -->
                      <span class="input-group-text" id="passToggle" onclick="togglePassword('pass')">
                          <i class="bi bi-eye" id="passIcon"></i>
                      </span>
                  </div>
                  <div class="invalid-feedback">Silahkan Masukkan Kata Sandi!</div>
              </div>

              <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Lupa Kata Sandi?</a>

              <div class="col-12">
                  <button class="btn btn-primary w-100" name="submit" type="submit">Masuk</button>
              </div>
          </form>

        <script>
          function togglePassword(passId) {
              var pass = document.getElementById(passId);
              var icon = document.getElementById('passIcon');

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
                  <?php
                    if(isset($_POST['submit'])){
                      
                      include 'config.php';
                      
                      $user = $_POST['user'];
                      $pass = $_POST['pass'];

                      $cek = mysqli_query($conn, "SELECT * FROM users WHERE username ='".$user."' AND password = '".MD5($pass)."'");
                      $cek3 = mysqli_query($conn, "SELECT * FROM users WHERE username ='".$user."'");
                      $cek4 = mysqli_query($conn, "SELECT * FROM users WHERE password ='".MD5($pass)."'");
                      if(mysqli_num_rows($cek) > 0){
                        $d = mysqli_fetch_object($cek);
                        $_SESSION['status_login'] = true;
                        $_SESSION['user_global'] = $d;
                        $_SESSION['idUser'] = $d->idUser;
                        ?>
                        <script>
                        Swal.fire({
                          title: 'Berhasil Masuk!',
                          text: 'Selamat Datang <?php echo $_SESSION['user_global']->nama ?>!',
                          icon: 'success'
                        }).then((result) => {
                          window.location="dashboard.php";
                        })
                        </script>
                        <?php
                      }elseif (mysqli_num_rows($cek3) > 0){
                        $d = mysqli_fetch_object($cek);
                        ?>
                        <script>
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Kata Sandi anda salah!',
                          }).then((result) => {
                          window.location="index.php";
                        })
                        </script>
                        <?php
                      }elseif (mysqli_num_rows($cek4) > 0){
                        $d = mysqli_fetch_object($cek);
                        ?>
                        <script>
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Username anda salah!',
                          }).then((result) => {
                          window.location="index.php";
                        })
                        </script>
                        <?php
                      }else{
                        ?>
                        <script>
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Username dan Kata Sandi anda salah!',
                          }).then((result) => {
                          window.location="index.php";
                        })
                        </script>
                        <?php
                      }
                    }
                  ?>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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

</body>
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Lupa Kata sandi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="" method="POST" id="usernameForm">
                    <div class="mb-3">
                        <label for="forgot_user" class="form-label">Masukkan Nama Pengguna Anda:</label>
                        <input type="text" name="forgot_user" id="forgot_user" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary" name="submit2" onclick="checkUsername()">Cek Nama Pengguna</button>
                </form>

                <!-- Second form for changing password inside the modal -->
                <form action="" method="POST" id="passwordChangeForm" style="display: none;" onsubmit="return checkPasswordChange();">
                    <!-- Tambahkan hidden input untuk menyimpan username -->
                    <input type="hidden" readonly name="username" id="change_password_username">

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Kata sandi Baru:</label>
                        <div class="input-group">
                            <!-- Tambahkan input untuk menunjukkan teks biasa -->
                            <input type="hidden" id="pass1Text" name="pass1Text" class="form-control" style="display: none;" >
                            <!-- Tambahkan input untuk menunjukkan password tersembunyi -->
                            <input type="password" id="pass1" name="pass1" class="form-control" required>
                            <!-- Tambahkan icon mata -->
                            <span class="input-group-text" id="pass1Toggle" onclick="togglePassword('pass1', 'pass1Text')">
                                <i class="bi bi-eye" id="pass1Icon"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Kata sandi Baru:</label>
                        <div class="input-group">
                            <!-- Tambahkan input untuk menunjukkan teks biasa -->
                            <input type="hidden" id="pass2Text" name="pass2Text" class="form-control" style="display: none;" >
                            <!-- Tambahkan input untuk menunjukkan password tersembunyi -->
                            <input type="password" id="pass2" name="pass2" class="form-control" required>
                            <!-- Tambahkan icon mata -->
                            <span class="input-group-text" id="pass2Toggle" onclick="togglePassword('pass2', 'pass2Text')">
                                <i class="bi bi-eye" id="pass2Icon"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function checkUsername() {
        var username = document.getElementById('forgot_user').value;

        // Gunakan AJAX untuk mengirim permintaan ke server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    // Username ditemukan di database
                    Swal.fire({
                        title: 'Nama Pengguna Terdeteksi!',
                        text: 'Silahkan ' + response.nama + ' untuk melanjutkan membuat kata sandi baru!',
                        icon: 'success'
                    }).then((result) => {
                        if (result.value) {
                            // Menyimpan username ke input hidden
                            document.getElementById('change_password_username').value = response.username;

                            // Menampilkan form ganti password dan menyembunyikan form username
                            document.getElementById('usernameForm').style.display = 'none';
                            document.getElementById('passwordChangeForm').style.display = 'block';
                        }
                    });
                } else {
                    // Username tidak ada di database
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Nama Pengguna tidak ada!',
                    });
                }
            }
        };

        xhr.open('POST', 'check_username.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('username=' + encodeURIComponent(username));
    }

    function togglePassword(passId, passTextId) {
        var pass = document.getElementById(passId);
        var passText = document.getElementById(passTextId);
        var icon = document.getElementById(passId + 'Icon');

        if (pass.type === "password") {
            pass.type = "text";
            passText.style.display = "block";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            pass.type = "password";
            passText.style.display = "none";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    function checkPasswordChange() {
        var pass1 = document.getElementById('pass1').value;
        var pass2 = document.getElementById('pass2').value;
        var username = document.getElementById('change_password_username').value;

        if (pass1 !== pass2) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Konfirmasi Kata sandi Baru Tidak Sesuai!',
            });
            return false; // Mencegah pengiriman formulir
        }

        // Menggunakan AJAX untuk mengirim permintaan reset password
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Reset Kata Sandi Berhasil!',
                        icon: 'success'
                    }).then((result) => {
                        window.location = "index.php";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal mereset kata sandi!',
                    });
                }
            }
        };

        xhr.open('POST', 'reset_password.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('username=' + encodeURIComponent(username) + '&new_password=' + encodeURIComponent(pass1));

        return false; // Mencegah pengiriman formulir
    }
</script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</html>