<?php
session_start();
require_once('db_login.php');


if (isset($_POST['submit'])) {
    $valid = TRUE;

    $noktp = test_input($_POST['noktp']);
    if ($noktp == '') {
        $error_noktp = 'NIK is required';
        $valid = FALSE;
    } elseif (!preg_match("/^\d{16}$/", $noktp)) {
        $error_noktp = 'Invalid NIK format (must be 16 digits)';
        $valid = FALSE;
    }
    $email = test_input($_POST['email']);
    if ($email == '') {
        $error_email = 'Email is required';
        $valid = FALSE;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = 'Invalid email format';
        $valid = FALSE;
    }

    $password = test_input($_POST['password']);
    if ($password == '') {
        $error_password = 'Password is required';
        $valid = FALSE;
    } else {
        $hashed_password = md5($password);
    }

    $nama = test_input($_POST['nama']);
    if ($nama == '') {
        $error_nama = 'Name is required';
        $valid = FALSE;
    }

    $alamat = test_input($_POST['alamat']);
    if ($alamat == '') {
        $error_alamat = 'Address is required';
        $valid = FALSE;
    }

    $kota = test_input($_POST['kota']);
    if ($kota == '') {
        $error_kota = 'City is required';
        $valid = FALSE;
    }

    $telp = test_input($_POST['telp']);
    if ($telp == '') {
        $error_telp = 'Phone number is required';
        $valid = FALSE;
    } elseif (!preg_match("/^\d{10,15}$/", $telp)) {
        $error_telp = 'Invalid phone number format (must be 10-15 digits)';
        $valid = FALSE;
    }

    if (isset($_FILES['ktp_scan'])) {
        $ktp_scan = $_FILES['ktp_scan'];
        $uploadDir = 'images/';
        $allowedExtensions = array('png', 'jpg', 'jpeg', 'pdf');
        $fileExtension = pathinfo($ktp_scan['name'], PATHINFO_EXTENSION);

        if (in_array($fileExtension, $allowedExtensions)) {
            $targetFile = $uploadDir . basename($ktp_scan['name']);
            if (move_uploaded_file($ktp_scan['tmp_name'], $targetFile)) {

            } else {
                $error_ktp_scan = 'There is an error for uploading file.';
                $valid = FALSE;
            }
        } else {
            $error_ktp_scan = 'KTP scan is required (.png, .jpg, .jpeg, .pdf allowable).';
            $valid = FALSE;
        }
    }

    $namafile = basename($ktp_scan['name']);



    if ($valid) {
        try {
            $sql = "INSERT INTO anggota (noktp, email, password, nama, alamat, kota, no_telp, file_ktp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssisssss", $noktp, $email, $hashed_password, $nama, $alamat, $kota, $telp, $namafile);
    
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Could not insert data into the database.";
            }
    
            $stmt->close();
        } catch (Exception $e) {
            if ($e->getCode() == 1062) { 
                $error_message = "Duplicate primary key. This Nomor KTP is already registered.";
            } else {
                $error_message = "An error occurred: " . $e->getMessage();
            }
        }
    }
    

}
?>
<?php include('./header.php') ?>
<br>
<style>
    .error {
        color: red;
    }
</style>
<a href="index.php" class="btn btn-primary" style="margin-right: 5pt;">Home</a>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="card mt-4">
    <div class="card-header">Member Registration Form</div>
    <div class="card-body">
        <form method="POST" autocomplete="on" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>"
            enctype="multipart/form-data">
            <div class="form-group">
                <label for="noktp">Nomor KTP:</label>
                <input type="number" class="form-control" id="noktp" name="noktp" value="<?php if (isset($noktp))
                    echo $noktp; ?>">
                <div class="error">
                    <?php if (isset($error_noktp))
                        echo $error_noktp ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($nama))
                        echo $nama; ?>">
                <div class="error">
                    <?php if (isset($error_nama))
                        echo $error_nama ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php if (isset($password))
                        echo $password; ?>">
                <div class="error">
                    <?php if (isset($error_password))
                        echo $error_password ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea class="form-control" id="alamat" name="alamat"><?php if (isset($alamat))
                        echo $alamat; ?></textarea>
                <div class="error">
                    <?php if (isset($error_alamat))
                        echo $error_alamat; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="kota">Kota:</label>
                <input type="text" class="form-control" id="kota" name="kota" value="<?php if (isset($kota))
                    echo $kota; ?>">
                <div class="error">
                    <?php if (isset($error_kota))
                        echo $error_kota ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($email))
                        echo $email; ?>">
                <div class="error">
                    <?php if (isset($error_email))
                        echo $error_email ?>
                    </div>
                    <div id="notification"></div>
                </div>
                <div class="form-group">
                    <label for="telp">Telepon:</label>
                    <input type="number" class="form-control" id="telp" name="telp" value="<?php if (isset($telp))
                        echo $telp; ?>">
                <div class="error">
                    <?php if (isset($error_telp))
                        echo $error_telp ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ktp_scan" class="form-label">File KTP (scan):</label>
                    <input type="file" name="ktp_scan" accept=".jpg, .jpeg, .png, .pdf" id="ktp_scan" class="form-control">
                <?php if (isset($error_ktp_scan)) { ?>
                    <div class="error">
                        <?php echo $error_ktp_scan; ?>
                    </div>
                <?php } ?>
            </div>
            <br>
            <button type="submit" class="btn btn-primary " name="submit" value="submit">Daftar</button>
            <br>
            <br>
            <div>
                <p>Sudah terdaftar member?<a href="login.php">Login</a></p>
            </div>
        </form>
        <br>
        <div id="add_response">
           <?php if (isset($error_message)): ?>
               <div class="alert alert-danger alert-dismissible">
                   <strong>Error!</strong> <?= $error_message ?>
               </div>
           <?php endif; ?>
        </div>
    </div>
</div>
<?php include('./footer.php') ?>