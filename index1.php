<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ESP32CAM Gallery Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  
 </head>
  <body>
   <div class="container" style="padding-top:30px;">
    <div class="d-flex justify-content-center" ><h1>ESP32CAM PHOTO Gallery</h1></div>
	<hr class="mt-2 mb-5">
<?php
  // Image extensions
  $image_extensions = array("png","jpg","jpeg","gif");

  // Check delete HTTP GET request - remove images
  if(isset($_GET["delete"])){
	$imageFileType = strtolower(pathinfo($_GET["delete"],PATHINFO_EXTENSION));
	if (file_exists($_GET["delete"]) && ($imageFileType == "jpg" ||  $imageFileType == "png" ||  $imageFileType == "jpeg") ) {
	  unlink($_GET["delete"]);
	  echo "<script>
			   $(document).ready(function(){
					$('#myModalOK').modal('show');
				});
				
			 </script>";
	}
	else {
	  echo 'File not found - <a href="galeria.php">refresh</a>';
	}
  }
  // Target directory
  $dir = 'captured_images/';
  if (is_dir($dir)){
	?>
	<div class="row text-center text-lg-start">
	<?php
	$count = 1;
	$files = scandir($dir);
	rsort($files);
	foreach ($files as $file) {
	if ($file != '.' && $file != '..') {?>
		<div class="col-lg-3 col-md-4 col-6" style="padding-bottom:30px;">
		 <div class="row">
		   <a href="<?php echo $dir . $file; ?>" class="d-block mb-4 h-100">
			<img class="img-fluid img-thumbnail" src="<?php echo $dir . $file; ?>" alt="">
		   </a>
		  </div>
		  <div class="row justify-content-end">
			<div class="col md-8">
			  <p><?php echo $file; ?></p>
			</div>
			<div class="col md-4">
			  <a href="index.php?delete=<?php echo $dir . $file; ?>" class="btn btn-danger btn-sm">Delete</a>
			</div>
		   
		  </div>
		</div>
	<?php
		   $count++;
		  }
		}
	   if($count==1) { echo "<p>No images found</p>"; } 
	  }
	  
	?>
	</div>
	
	<!-- Modal Delete OK-->
	<div class="modal fade" id="myModalOK" tabindex="-1" aria-labelledby="myModalOKLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		  <div class="modal-header" style="background-color:#2cc791;">
			<h5 class="modal-title" id="exampleModalLabel" style="color:white;">Success</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			Successfully delete image file <b><?php $path_parts = pathinfo($_GET["delete"],PATHINFO_BASENAME) ; echo $path_parts; ?> </b>
		  </div>
		  <div class="modal-footer">
			<a class="btn btn-primary" href="index.php" role="button">OK</a>
		  </div>
		</div>
	  </div>
	</div>
	
	<!-- Modal Delete Not OK-->
	<div class="modal fade" id="myModalOK" tabindex="-1" aria-labelledby="myModalOKLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		  <div class="modal-header" style="background-color:#fc8403;">
			<h5 class="modal-title" id="exampleModalLabel" style="color:white;">Success</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
			Something wrong while deleting file <?php $path_parts = pathinfo($_GET["delete"],PATHINFO_BASENAME) ; echo $path_parts; ?>
		  </div>
		  <div class="modal-footer">
			<a class="btn btn-secondary" href="galeria.php" role="button">OK</a>
		  </div>
		</div>
	  </div>
	</div>
  <div>
  </body>
</html>