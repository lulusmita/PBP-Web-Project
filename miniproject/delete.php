<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: loginp.php');
    exit; 
}

require_once('db_login.php');

if (isset($_GET['id'])) {
    $no = $_GET['id'];

    $sql = "DELETE FROM anggota WHERE noktp = ?";
    $stmt = $db->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $no); 
        if ($stmt->execute()) {
            header('Location: verifikasi.php');
            exit; 
        } else {
            echo '<script>alert("Error: ' . $stmt->error . '");</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("Error in preparing the statement.");</script>';
    }
} else {
    echo '<script>alert("Nomor KTP not found.");</script>';
}
$db->close();
?>
