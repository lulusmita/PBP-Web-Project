<?php include("header.php"); ?>
<a href="index.php" class="btn btn-primary" style="margin-right: 5pt;">Home</a>
<div class="row w-1000 mx-auto mt-5">
    <div class="col">
        <div class="card">
            <div class="card-header">Tampilkan Buku</div>
            <div class="card-body">
                <input type="text" class="form-control" id="title"
                    placeholder="Masukkan kategori/judul/nama pengarang/penerbit/ISBN" onkeyup="showBooks(this.value)">

                <br>
                <div id="detail_books">
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php");