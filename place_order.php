<?php
include 'db.php';

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

// Cart total ගන්න
$total_query = mysqli_query($conn,"
SELECT SUM(products.price * cart.quantity) AS total
FROM cart
JOIN products
ON cart.product_id = products.product_id
WHERE cart.user_id='$user_id'
");

$total_row = mysqli_fetch_assoc($total_query);
$shipping = 300;
$total_amount = $total_row['total'] + $shipping;

// Orders table එකට insert කිරීම
$order_status = "Processing";

$order_sql = "
INSERT INTO orders(user_id,total_amount,order_status)
VALUES('$user_id','$total_amount','$order_status')
";

if(mysqli_query($conn,$order_sql)){

    $order_id = mysqli_insert_id($conn);

    // Cart items ගන්න
    $cart_query = mysqli_query($conn,"
    SELECT *
    FROM cart
    JOIN products
    ON cart.product_id = products.product_id
    WHERE cart.user_id='$user_id'
    ");

    while($row = mysqli_fetch_assoc($cart_query)){

        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $subtotal = $row['price'] * $quantity;

        mysqli_query($conn,"
        INSERT INTO order_items(order_id,product_id,quantity,subtotal)
        VALUES('$order_id','$product_id','$quantity','$subtotal')
        ");
    }

    // ===============================
// ADD LOYALTY POINTS
// ===============================

$earned_points = floor($total_amount / 100); // Rs.100 = 1 point

$check = mysqli_query($conn,"
SELECT * FROM loyalty_points
WHERE user_id='$user_id'
");

if(mysqli_num_rows($check) > 0){

    mysqli_query($conn,"
    UPDATE loyalty_points
    SET points = points + $earned_points
    WHERE user_id='$user_id'
    ");

}else{

    mysqli_query($conn,"
    INSERT INTO loyalty_points(user_id,points)
    VALUES('$user_id','$earned_points')
    ");

}

    // Cart empty කිරීම
    mysqli_query($conn,"
    DELETE FROM cart
    WHERE user_id='$user_id'
    ");

    header("Location: ../php/order_success.php");
}
else{
    echo mysqli_error($conn);
}
?>