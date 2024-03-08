<?php
$servername = "localhost";
$username = "root"; // Isi dengan nama pengguna database Anda jika Anda telah menentukannya
$password = ""; // Isi dengan kata sandi database Anda jika Anda telah menentukannya
$dbname = "greensen_iq";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "SELECT kategori FROM deteksi ORDER BY id_deteksi Desc LIMIT 1";
$result = $conn->query($sql1);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $kategori = $row["kategori"];
    echo $kategori;
} else {
    echo "0";
}


?>
