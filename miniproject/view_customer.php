  <?php
  session_start();
  if (!isset($_SESSION['ktp'])) {
      header('Location: login.php');
      exit;
  
  
  }?>
  <?php include("header.php"); ?>

  <h3>Anggota Bisa:</h3>
    <ul>
      <li>
        <a href="rating_buku.php">Memberi rating dan komentar pada buku</a><br />
      </li>
      <li>
        <a href="riwayat_transaksi.php">Melihat riwayat peminjaman</a><br />
      </li>
      
    </ul>

  <?php include("footer.php"); ?>