<?php
session_start();
require_once('db_login.php');

if (isset($_POST['submit'])) {
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = 'Email is required';
    }

    if (empty($password)) {
        $error_password = 'Password is required';
    }

    if (!isset($error_email) && !isset($error_password)) {
        $query = "SELECT * FROM anggota WHERE email = '$email' AND password = '" . md5($password) . "'";
        $result = $db->query($query);

        if (!$result) {
            $error_message = "Could not query the database: " . $db->error . "<br>Query: " . $query;
        } else {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $status = $row['status'];

                if ($status === null) {
                    $error_message = "Pengajuan member belum diverifikasi petugas.";
                } elseif ($status == 0) {
                    $error_message = "Pengajuan member ditolak. Silahkan hubungi petugas.";
                } else {
                    $_SESSION['ktp'] = $row['noktp'];
                    header('Location: view_customer.php');
                    exit;
                }
            } else {
                $error_message = "Combination of email and password is not correct.";
            }
        }
    }
}

include('header.php');
?>

<br>
<style>
    .error {
        color: red;
    }
</style>
<a href="index.php" class="btn btn-primary" style="margin-right: 5pt;">Home</a>
<div class="card mt-4">
    <div class="card-header">Login Form</div>
    <div class="card-body">
        <form method="POST" autocomplete="on" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= isset($email) ? $email : '' ?>">
                <div class="error">
                    <?= isset($error_email) ? $error_email : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for "password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="">
                <div class="error">
                    <?= isset($error_password) ? $error_password : '' ?>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Login</button>
            <a href="registrasi.php" class="btn btn-secondary">Cancel</a>
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

<?php include('footer.php'); ?>
