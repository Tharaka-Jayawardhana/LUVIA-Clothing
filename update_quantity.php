<?php
include 'db.php';

$cart_id = $_GET['id'];
$action = $_GET['action'];

if($action == "increase"){
    $sql = "UPDATE cart
            SET quantity = quantity + 1
            WHERE cart_id='$cart_id'";
}
elseif($action == "decrease"){

    // current quantity ගන්න
    $result = mysqli_query($conn,
    "SELECT quantity FROM cart WHERE cart_id='$cart_id'");

    $row = mysqli_fetch_assoc($result);

    if($row['quantity'] > 1){
        $sql = "UPDATE cart
                SET quantity = quantity - 1
                WHERE cart_id='$cart_id'";
    }
    else{
        $sql = "DELETE FROM cart
                WHERE cart_id='$cart_id'";
    }
}

mysqli_query($conn, $sql);

header("Location: ../Pages/cart/cart.php");
?>