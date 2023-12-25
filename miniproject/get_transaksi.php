<?php
require_once('db_login.php');

session_start(); // Start the session

// Assuming you have obtained $noktp during the user login process
$noktp = ''; // Replace with the actual 'noktp' value obtained during login

// Set 'noktp' in the session
$_SESSION['noktp'] = $noktp;

// TODO: Query to get the user's transaction history
$query = "SELECT t.idtransaksi, t.tgl_pinjam, t.idpetugas, dt.tgl_kembali, dt.denda, b.isbn, b.judul
          FROM transaksi t
          INNER JOIN detail_transaksi dt ON t.idtransaksi = dt.idtransaksi
          INNER JOIN buku b ON dt.idbuku = b.idbuku
          WHERE t.noktp = '$noktp'
          ORDER BY t.tgl_pinjam DESC";

try {
    $result = $db->query($query);
} catch (\Throwable $th) {
    echo "" . $th->getMessage() . "";
}

if (!$result) {
    die("Could not query the database: <br>" . $db->error);
}

// Display transaction data with appropriate categories (completed, ongoing, with overdue fines)
echo '<table class="table table-hover">';
echo '<tr class="table-primary">';
echo '<th>ID Transaksi</th>';
echo '<th>Tanggal Pinjam</th>';
echo '<th>ID Petugas</th>';
echo '<th>Tanggal Kembali</th>';
echo '<th>Denda</th>';
echo '<th>ISBN</th>';
echo '<th>Judul Buku</th>';
echo '</tr>';

while ($row = $result->fetch_object()) {
    $status = '';
    if ($row->tgl_kembali == null) {
        $status = 'Belum Dikembalikan';
    } else if (strtotime($row->tgl_kembali) <= strtotime(date("Y-m-d"))) {
        $status = 'Sudah Selesai (Terlambat)';
    } else {
        $status = 'Sudah Selesai';
    }

    echo '<tr>';
    echo '<td>' . $row->idtransaksi . '</td>';
    echo '<td>' . $row->tgl_pinjam . '</td>';
    echo '<td>' . $row->idpetugas . '</td>';
    echo '<td>' . $row->tgl_kembali . '</td>';
    echo '<td>' . $row->denda . '</td>';
    echo '<td>' . $row->isbn . '</td>';
    echo '<td>' . $row->judul . '</td>';
    echo '<td>Status: ' . $status . '</td>';
    echo '</tr>';
}
echo '</table';

// Free the variables and close the database connection
$result->free();
$db->close();
?>
