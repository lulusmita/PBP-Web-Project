<?php

include 'header.php'; // Mengimpor header

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari request AJAX
    $idbuku = $_POST['idbuku'];
    $noktp = $_POST['noktp'];
    $skor_rating = $_POST['skor_rating'];

    // Membuat koneksi ke database
    $conn = new mysqli("localhost", "username", "password", "nama_database");

    // Periksa koneksi database
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Periksa apakah anggota telah memberikan rating sebelumnya
    $query = "SELECT * FROM rating_buku WHERE idbuku = ? AND noktp = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $idbuku, $noktp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Anggota belum memberikan rating, jadi simpan rating baru
        $insert_query = "INSERT INTO rating_buku (idbuku, noktp, skor_rating, tgl_rating) VALUES (?, ?, ?, CURDATE())";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iii", $idbuku, $noktp, $skor_rating);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Rating berhasil disimpan!"]);
        } else {
            echo json_encode(["error" => "Gagal menyimpan rating."]);
        }
    } else {
        echo json_encode(["message" => "Anda sudah memberikan rating sebelumnya."]);
    }

    $stmt->close();
    $conn->close();
}

include 'footer.php'; // Mengimpor footer

?>
