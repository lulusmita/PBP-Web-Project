<?php
// File : logout.php
// Deskripsi : Untuk logout (menghapus session yang dibuat saat login)
session_start();
session_destroy();
header('Location: loginp.php');
?>

