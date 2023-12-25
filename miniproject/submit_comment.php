<?php

include 'header.php'; // Mengimpor header

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari request AJAX
    $idbuku = $_POST['idbuku'];
    $noktp = $_POST['noktp'];
    $komentar = $_POST['komentar'];

    // Membuat koneksi ke database
    $conn = new mysqli("localhost", "username", "password", "nama_database");

    // Periksa koneksi database
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Simpan komentar ke database dengan prepared statement
    $insert_query = "INSERT INTO komentar_buku (idbuku, noktp, komentar, tgl_komentar) VALUES (?, ?, ?, CURDATE())";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iis", $idbuku, $noktp, $komentar);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Komentar berhasil disimpan!"]);
    } else {
        echo json_encode(["error" => "Gagal menyimpan komentar."]);
    }

    $stmt->close();
    $conn->close();
}

include 'footer.php'; // Mengimpor footer

?>
