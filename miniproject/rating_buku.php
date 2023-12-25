<?php
  session_start();
  if (!isset($_SESSION['ktp'])) {
      header('Location: login.php');
      exit;
  
  
  }?>
<?php include("header.php"); ?>

<div class="row w-1000 mx-auto mt-5">
    <div class="col">
        <div class="card">
            <div class="card-header">Cari Buku Untuk Di Rating atau Review <a href="logoutp.php" class="btn btn-danger float-right">Logout</a></div>
            <div class="card-body">
                <input type="text" class="form-control" id="title"
                    placeholder="Masukkan kategori/judul/nama pengarang/penerbit/ISBN" onkeyup="showBooksForAndre(this.value)">

                <br>
                <div id="detail_books">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include("footer.php");
?>
