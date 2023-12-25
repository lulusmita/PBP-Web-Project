<?php
session_start();
require_once('db_login.php');


if (isset($_POST['submit'])) {
    $valid = TRUE;


    $email = test_input($_POST['email']);
    if ($email == '') {
        $error_email = 'Email is required';
        $valid = FALSE;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = 'Invalid email format';
        $valid = FALSE;
    }

    require_once('db_login.php');
    $password = test_input($_POST['password']);
    if ($password == '') {
        $error_password = 'Password is required';
        $valid = FALSE;
    }


    if ($valid) {

        $query = "SELECT * FROM petugas WHERE email = '" . $email . "' AND password = '" . md5($password) . "'";
        $result = $db->query($query);
        if (!$result) {
            $error_message = "Could not query the database: " . $db->error . "<br>Query: " . $query;
        } else {
            if ($result->num_rows > 0) {
                $_SESSION['username'] = $email;
                header('Location: verifikasi.php');
                exit;
            } else {
                $error_message = "Combination of email and password is not correct.";
            }
        }

        $db->close();
    }
}
?>
<?php include('header.php') ?>
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
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php if (isset($email))
                        echo $email; ?>">
                <div class="error">
                    <?php if (isset($error_email))
                        echo $error_email ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="">
                    <div class="error">
                    <?php if (isset($error_password))
                        echo $error_password ?>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Login</button>
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
<?php include('footer.php') ?>