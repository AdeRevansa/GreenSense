<?php
	$hostname = 'localhost';
	$username = 'root';
	$password = '';
	$dbname	  = 'greensen_iq';

	$conn = mysqli_connect($hostname, $username, $password, $dbname) or die ('Gagal terhubung ke database');
?>