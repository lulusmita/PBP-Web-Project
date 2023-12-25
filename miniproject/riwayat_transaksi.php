<?php include("header.php"); ?>

<?php
  session_start();
  if (!isset($_SESSION['ktp'])) {
      header('Location: login.php');
      exit;
  
  
  }?>

<div class="container mt-5">
    <h2>Riwayat Transaksi Peminjaman Buku <a href="logoutp.php" class="btn btn-danger float-right">Logout</a></h2>
    <div class="row">
        <div class="col-md-12">
            <?php
            echo '<table>';
            require_once('db_login.php');

            //query untuk mendapatkan data transaksi
            $query = "SELECT t.idtransaksi, t.tgl_pinjam, t.idpetugas, dt.tgl_kembali, dt.denda, b.isbn, b.judul
                      FROM transaksi t
                      INNER JOIN detail_transaksi dt ON t.idtransaksi = dt.idtransaksi
                      INNER JOIN buku b ON dt.idbuku = b.idbuku
                      WHERE t.noktp = '" . $_SESSION['ktp'] . "'
                      ORDER BY t.tgl_pinjam DESC";

             // Eksekusi query
            try {
                $result = $db->query($query);

            } catch (\Throwable $th) {
                die("Could not query the database: <br />" . $db->error . "<br>Query: " . $query);
            }

            //Menampilkan detail transaksi
            echo '<table class="table table-hover">';
            echo '<tr class="table-primary">';
            echo '<th>ID Transaksi</th>';
            echo '<th>Tanggal Pinjam</th>';
            echo '<th>ID Petugas</th>';
            echo '<th>Tanggal Kembali</th>';
            echo '<th>Denda</th>';
            echo '<th>ISBN</th>';
            echo '<th>Judul Buku</th>';
            echo '<th>Status</th>';
            echo '<th>Total Denda</th>';

            while ($row = $result->fetch_object()) {
                echo '<tr>';
                echo '<td>' . $row->idtransaksi . '</td>';
                echo '<td>' . $row->tgl_pinjam . '</td>';
                echo '<td>' . $row->idpetugas . '</td>';
                echo '<td>' . $row->tgl_kembali . '</td>';
                echo '<td>' . $row->denda . '</td>';
                echo '<td>' . $row->isbn . '</td>';
                echo '<td>' . $row->judul . '</td>';
            
                // Menghitung status peminjaman
                $tglSekarang = date('Y-m-d');
                if ($row->tgl_kembali < $tglSekarang) {
                    // Peminjaman melebihi tanggal kembali
                    echo '<td>Belum Dikembalikan</td>';
                    echo '<td>Denda: ' . $row->denda . '</td>';
                } elseif ($row->tgl_kembali == $tglSekarang) {
                    // Peminjaman berakhir hari ini
                    echo '<td>Pengembalian Hari Ini</td>';
                } else {
                    // Peminjaman sudah selesai
                    echo '<td>Sudah Selesai</td>';
                }
                echo '</tr>';
            }

            //Mengecek apabila belum ada transaksi
            if ($result->num_rows == 0) {
                echo '<tr>';
                echo '<td colspan="7">Belum ada transaksi</td>';
                echo '</tr>';
            } else {
                echo '</table>';
            }


            ?>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>