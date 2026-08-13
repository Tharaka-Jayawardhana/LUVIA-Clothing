<?php

include __DIR__ . '/db.php';


if (isset($_GET['order_id'])) {

    $order_id = $_GET['order_id'];

} else {

    die("Order ID not found");

}


// Order details

$order_query = mysqli_query($conn, "
SELECT orders.*, 
       users.full_name,
       users.email,
       users.phone,
       users.address

FROM orders

JOIN users
ON orders.user_id = users.user_id

WHERE orders.order_id='$order_id'
");


$order = mysqli_fetch_assoc($order_query);



// Order items

$item_query = mysqli_query($conn, "
SELECT 
    products.product_name,
    products.price,
    order_items.quantity,
    order_items.subtotal

FROM order_items

JOIN products
ON order_items.product_id = products.product_id

WHERE order_items.order_id='$order_id'
");


?>

<!DOCTYPE html>
<html>

<head>

    <title>LUVIA Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">

</head>


<body class="invoice-page">


    <div class="invoice-box">


        <div class="header">

            <h1>LUVIA</h1>

            <p>AI Fashion Store</p>

        </div>



        <div class="invoice-info">

            <div>

                <h3>Bill To:</h3>

                <p>
                    <?= $order['full_name']; ?><br>
                    <?= $order['email']; ?><br>
                    <?= $order['phone']; ?><br>
                    <?= $order['address']; ?>
                </p>

            </div>


            <div>

                <h3>Invoice</h3>

                <p>
                    Invoice No : #<?= $order['order_id']; ?><br>

                    Date :
                    <?= date("d M Y", strtotime($order['order_date'])); ?>

                </p>

            </div>

        </div>




        <table class="invoice-table">


            <tr>

                <th>Product</th>

                <th>Quantity</th>

                <th>Price</th>

                <th>Total</th>

            </tr>



            <?php while ($row = mysqli_fetch_assoc($item_query)) { ?>

                <tr>

                    <td>
                        <?= $row['product_name']; ?>
                    </td>

                    <td>
                        <?= $row['quantity']; ?>
                    </td>

                    <td>
                        Rs. <?= number_format($row['price'], 2); ?>
                    </td>

                    <td>
                        Rs. <?= number_format($row['subtotal'], 2); ?>
                    </td>

                </tr>


            <?php } ?>



        </table>


        <div class="summary">

            <p>
                Total Amount :
                Rs. <?= number_format($order['total_amount'], 2); ?>
            </p>

        </div>


        <div class="payment">

            Order Status :
            <?= $order['order_status']; ?>

        </div>


        <button onclick="window.print()">
            Print Invoice
        </button>

    </div>


</body>

</html>