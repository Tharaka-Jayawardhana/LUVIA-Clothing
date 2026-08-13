<?php
include 'db.php';

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>