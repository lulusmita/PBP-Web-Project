<?php
// File: detail_books.php
// Deskripsi: Halaman untuk menampilkan detail data buku beserta review buku.

require_once('db_login.php');

// Include header
include('header.php');

// Cek apakah parameter 'idbuku' telah diberikan melalui URL
if (isset($_GET['id'])) {
    // Ambil nilai idbuku dari parameter URL
    $idbuku = $_GET['id'];
    // Query untuk mengambil detail data buku dan review
    $query = "SELECT b.isbn, b.judul, k.nama, b.pengarang, b.stok_tersedia, b.file_gambar
              FROM buku b, kategori k
              WHERE b.idkategori = k.idkategori AND
                b.idbuku = '$idbuku'";
    ;

    // query untuk mengambil rating buku
    $query2 = "SELECT AVG(skor_rating) AS rating
               FROM rating_buku
               WHERE idbuku = '$idbuku'";

    // query untukmengambil review buku
    $query3 = "SELECT * FROM kometar_buku WHERE idbuku = '$idbuku'";

    // Eksekusi query
    try {
        $result = $db->query($query);
        $result2 = $db->query($query2);
        $result3 = $db->query($query3);

    } catch (\Throwable $th) {
        die("Could not query the database: <br />" . $db->error . "<br>Query: " . $query);
    }


    // Menampilkan detail data buku
    echo '<div class="card mt-5">';
    echo '<div class="card-header">Detail Buku</div>';
    echo '<div class="card-body">';

    while ($row = $result->fetch_object()) {
        echo '<img style="" src="images/' . $row->file_gambar . '" width="200" height="300" alt="Gambar buku">';
        echo '<h4>ISBN: ' . $row->isbn . '</h4>';
        echo '<p>judul: ' . $row->judul . '</p>';
        echo '<p>kategori: ' . $row->nama . '</p>';
        echo '<p>pengarang: ' . $row->pengarang . '</p>';
        echo '<p>jumlah tersedia: ' . $row->stok_tersedia . '</p>';
        if ($result2->num_rows == 0) {
            echo '<p>RATING: Belum ada rating</p>';
        }
        while ($row2 = $result2->fetch_object()) {
            echo '<p>RATING: ' . round($row2->rating, 2) . '</p>';
        }

        // Menampilkan review buku
        echo '<h5>Komentar:</h5>';
        if ($result3->num_rows == 0) {
            echo 'Belum ada komentar';
        }
        while ($row3 = $result3->fetch_object()) {
            echo '<p>-' . $row3->komentar . '</p>';
        }
    }

    echo '</div>';
    echo '</div>';

    // Include footer
    include('./footer.php');
} else {
    die("Id buku tidak ditemukan.");
}
?>