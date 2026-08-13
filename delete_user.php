<?php

session_start();

include '../../php/db.php';


// Admin check

if (!isset($_SESSION['admin_id'])) {

    header("Location: admin_login.php");
    exit();

}



if (isset($_GET['id'])) {


    $user_id = $_GET['id'];



    // Prevent deleting admin account

    $check = mysqli_query(
        $conn,
        "SELECT role FROM users WHERE user_id='$user_id'"
    );


    $user = mysqli_fetch_assoc($check);



    if ($user['role'] == "admin") {

        echo "<script>
        alert('Admin account cannot be deleted!');
        window.location='manage_user.php';
        </script>";

        exit();

    }




    // Delete chatbot messages

    mysqli_query(
        $conn,
        "DELETE FROM chatbot_messages 
WHERE user_id='$user_id'"
    );


    // Get user orders

    $order_query = mysqli_query(
        $conn,
        "SELECT order_id FROM orders 
WHERE user_id='$user_id'"
    );


    while ($order = mysqli_fetch_assoc($order_query)) {

        $order_id = $order['order_id'];


        // Get order items

        $item_query = mysqli_query(
            $conn,
            "SELECT order_item_id FROM order_items
     WHERE order_id='$order_id'"
        );


        while ($item = mysqli_fetch_assoc($item_query)) {

            $order_item_id = $item['order_item_id'];


            // Delete customizations

            mysqli_query(
                $conn,
                "DELETE FROM customizations
         WHERE order_item_id='$order_item_id'"
            );

        }


        // Delete order items

        mysqli_query(
            $conn,
            "DELETE FROM order_items
     WHERE order_id='$order_id'"
        );


        // Delete payments

        mysqli_query(
            $conn,
            "DELETE FROM payments
     WHERE order_id='$order_id'"
        );


        // Delete deliveries

        mysqli_query(
            $conn,
            "DELETE FROM deliveries
     WHERE order_id='$order_id'"
        );


        // Delete order

        mysqli_query(
            $conn,
            "DELETE FROM orders
     WHERE order_id='$order_id'"
        );


    }


    // Delete loyalty points

    mysqli_query(
        $conn,
        "DELETE FROM loyalty_points
WHERE user_id='$user_id'"
    );


    // Finally delete user

    $delete = mysqli_query(
        $conn,
        "DELETE FROM users
WHERE user_id='$user_id'"
    );



    if ($delete) {

        echo "<script>
        alert('User Deleted Successfully');
        window.location='manage_user.php';
        </script>";

    } else {

        echo "<script>
        alert('Delete Failed');
        window.location='manage_user.php';
        </script>";

    }


}


?>