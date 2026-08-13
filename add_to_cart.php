<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';


if(!isset($_SESSION['user_id'])){

    header("Location: ../Pages/login/login.html");
    exit();

}


$user_id = $_SESSION['user_id'];


// Get data from product details page

if(isset($_POST['add_cart'])){


    $product_id = $_POST['product_id'];
    $size = $_POST['size'];
    $color = $_POST['color'];



    // Check product

    $check_product = mysqli_query($conn,
        "SELECT * FROM products 
        WHERE product_id='$product_id'"
    );


    if(mysqli_num_rows($check_product)==0){

        die("Product Not Found");

    }



    // Create customization first

    $custom_query = mysqli_query($conn,

        "INSERT INTO customizations
        (custom_text, custom_image, color, size)
        VALUES
        ('','$product_id','$color','$size')"

    );


    $customization_id = mysqli_insert_id($conn);



    // Check cart existing

    $check_cart = mysqli_query($conn,

        "SELECT * FROM cart
        WHERE user_id='$user_id'
        AND product_id='$product_id'
        AND customization_id='$customization_id'"

    );



    if(mysqli_num_rows($check_cart)>0){


        mysqli_query($conn,

        "UPDATE cart
        SET quantity = quantity + 1
        WHERE user_id='$user_id'
        AND product_id='$product_id'
        AND customization_id='$customization_id'"

        );


    }
    else{


        mysqli_query($conn,

        "INSERT INTO cart
        (user_id, product_id, quantity, customization_id)

        VALUES

        ('$user_id','$product_id','1','$customization_id')"

        );


    }



    header("Location: ../Pages/cart/cart.php");
    exit();


}

else{


    echo "Invalid Request";


}


?>