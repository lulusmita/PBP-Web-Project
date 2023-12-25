<?php

require_once('db_login.php');

$bookTitle = $_GET['title'];
// TODO 2: Tuliskan dan eksekusi query untuk mendapatkan informasi customer
$query = "SELECT DISTINCT b.idbuku, b.isbn, b.judul, k.nama, b.pengarang, b.penerbit, b.kota_terbit, b.stok_tersedia
FROM buku b, kategori k
WHERE b.idkategori = k.idkategori AND
    (k.nama LIKE '%$bookTitle%' OR b.judul LIKE '%$bookTitle%' OR b.pengarang LIKE '%$bookTitle%' OR b.penerbit LIKE '%$bookTitle%' OR b.isbn LIKE '%$bookTitle%')
GROUP BY b.idbuku;";
try {
    $result = $db->query($query);
} catch (\Throwable $th) {
    echo "" . $th->getMessage() . "";
}

if (!$result) {
    die("Could not query the database: <br>" . $db->error);
}

// TODO 3: Tuliskan response
echo '<table class="table table-hover">';
echo '<tr class="table-primary">';
echo '<th>isbn</th>';
echo '<th>judul</th>';
echo '<th>pengarang</th>';
echo '<th>penerbit</th>';
echo '<th>kategori</th>';
echo '<th>stok tersedia</th>';
echo '<th>Review</th>';
echo '<th>Komentar</th>';
echo '</tr>';

while ($row = $result->fetch_object()) {
    echo '<tr>';
    echo '<td>' . $row->isbn . '</td>';
    echo '<td>' . $row->judul . '</td>';
    echo '<td>' . $row->pengarang . '</td>';
    echo '<td>' . $row->penerbit . '</td>';
    echo '<td>' . $row->nama . '</td>';
    echo '<td>' . $row->stok_tersedia . '</td>';
    echo '<td><a class="btn btn-primary btn-sm" href="view_rating.php?id=' . $row->idbuku . '">Beri Rating</a>&nbsp;</td>';
    echo '<td><a class="btn btn-primary btn-sm" href="view_comment.php?id=' . $row->idbuku . '">Beri Komentar</a>&nbsp;</td>';
    echo '</tr>';
}
echo '</table>';

// TODO 4: Dealokasi variabel dan tutup koneksi database
$result->free();
$db->close();
?>