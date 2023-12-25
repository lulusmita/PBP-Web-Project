<?php
require_once('db_login.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $query = "SELECT * FROM anggota WHERE email = '$email'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        echo '<br><div class="alert alert-danger">Email is already registered. Please <a href="login.php">log in</a>.</div>';
    } else {
        echo '<br><div class="alert alert-success">Email is available.</div>';
    }
}
