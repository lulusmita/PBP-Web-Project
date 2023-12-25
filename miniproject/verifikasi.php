<?php include('header.php'); ?>
<?php
  session_start();
  if (!isset($_SESSION['username'])) {
      header('Location: loginp.php');
      exit;
  
  
  }?>
<div class="card mt-5">
    <div class="card-header">
        Members Data
        <a href="logout.php" class="btn btn-danger float-right">Logout</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">

            <tr>
                <th>Nomor KTP</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Email</th>
                <th>No Telepon</th>
                <th>File KTP</th>
                <th>Action</th>
            </tr>

            <?php
            require_once('db_login.php');
            $query = "SELECT noktp AS 'Nomor_KTP', nama AS 'Nama', alamat AS 'Alamat', kota AS 'Kota', email AS 'Email', no_telp AS 'No_Telepon', file_ktp AS 'File_KTP' FROM anggota WHERE status IS NULL ORDER BY noktp";
            $result = $db->query($query);

            if (!$result) {
                die("Could not query the database: <br />" . $db->error . "<br>Query: " . $query);
            }
            while ($row = $result->fetch_object()) {
                echo '<tr>';
                echo '<td>' . $row->Nomor_KTP . '</td>';
                echo '<td>' . $row->Nama . '</td>';
                echo '<td>' . $row->Alamat . '</td>';
                echo '<td>' . $row->Kota . '</td>';
                echo '<td>' . $row->Email . '</td>';
                echo '<td>' . $row->No_Telepon . '</td>';
                if ($row->File_KTP != null) {
                    echo '<td><a href="images/' . $row->File_KTP . '" target="_blank">Lihat File KTP</a></td>';
                } else {
                    echo '<td>Belum ada file KTP</td>';
                }
                echo '<td><a class="btn btn-warning btn-sm form-control" href="addstatus.php?id=' . $row->Nomor_KTP . '">Add Status</a>&nbsp;<a class="btn btn-danger btn-sm form-control" href="delete.php?id=' . $row->Nomor_KTP . '">Delete</a></td>';
                echo '</tr>';
            }
            ?>
        </table>
        <br />
        <?php
        echo 'Total Rows = ' . $result->num_rows;

        $result->free();
        $db->close();
        ?>
    </div>
</div>

<?php include('footer.php'); ?>