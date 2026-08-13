<?php
include 'db.php';

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM cart WHERE cart_id='$id'");

header("Location: ../pages/cart/cart.php");
?>