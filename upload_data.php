<?php

var_dump($_POST);

$target_dir = "greensense/CekKondisi/"; // folder untuk menyimpan gambar
$target_filename = "gambar.jpg"; // set the constant filename without an extension
$target_file = $target_dir . $target_filename;
$uploadOk = 1;

$imageFileType = strtolower(pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION));
$file_name = pathinfo($_FILES["imageFile"]["name"], PATHINFO_BASENAME);

// Debugging: Print entire POST data
var_dump($_POST);

// ... (your existing code)

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
        echo "Photo berhasil dipuload di server dengan nama " . $file_name;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "greensen_iq";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $temperature = isset($_POST["suhu"]) ? mysqli_real_escape_string($conn, $_POST["suhu"]) : "";
        $humidity = isset($_POST["kelembaban"]) ? mysqli_real_escape_string($conn, $_POST["kelembaban"]) : "";
        $tanah = isset($_POST["tanah"]) ? mysqli_real_escape_string($conn, $_POST["tanah"]) : "";
        $pompa = isset($_POST["pompa"]) ? mysqli_real_escape_string($conn, $_POST["pompa"]) : "";

        // Debugging: Print SQL query
        $stmt = $conn->prepare("INSERT INTO data_monitoring (gambar, suhu, status_tanah, kelembapan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $file_name, $temperature, $tanah, $humidity);

        if ($stmt->execute()) {
            echo "Data berhasil dimasukkan ke database. Temperature: " . $temperature . "tanah" . $tanah;
            
            $stmt2 = $conn->prepare("INSERT INTO data_penyiraman (kategori_pompa) VALUES (?)");
            $stmt2->bind_param("s", $pompa);
            
            if ($stmt2->execute()) {
                echo "Data Pompa berhasil dimasukkan ke database";
            } else {
                echo "Error: " . $stmt2->error;
            }

            $stmt2->close();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Sorry, Ada error dalam proses upload photo.";
    }
}
?>