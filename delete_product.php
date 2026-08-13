<?php

session_start();

include '../../php/db.php';


// Admin check

if(!isset($_SESSION['admin_id'])){

    header("Location: admin_login.php");
    exit();

}



if(isset($_GET['id'])){


    $product_id = $_GET['id'];



    // Get image name before delete

    $result = mysqli_query($conn,
    "SELECT image FROM products 
     WHERE product_id='$product_id'");


    $product = mysqli_fetch_assoc($result);



    // Delete database record

    mysqli_query($conn,
    "DELETE FROM products 
     WHERE product_id='$product_id'");






}


header("Location: manage_product.php");

exit();


?>