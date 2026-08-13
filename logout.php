<?php
session_start();
session_destroy();

header("Location: ../pages/home/home.php");
exit();
?>