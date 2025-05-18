<?php
session_start();
session_destroy();
header("Location: /kurir/autentikasi/login.php");
exit;
?>
