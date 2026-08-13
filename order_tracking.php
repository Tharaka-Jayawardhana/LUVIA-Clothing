<?php
include '../../php/db.php';

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

// Latest Order
$order_query = mysqli_query($conn, "
SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY order_id DESC
LIMIT 1");

$order = mysqli_fetch_assoc($order_query);

if (!$order) {
    die("No Orders Found");
}

$order_id = $order['order_id'];
$status = $order['order_status'];
$total = $order['total_amount'];
$date = $order['order_date'];

$badge = "warning";

if ($status == "Delivered") {
    $badge = "success";
} elseif ($status == "Shipped") {
    $badge = "info";
} elseif ($status == "Cancelled") {
    $badge = "danger";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUVIA | Order Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body class="order_tracking page">

    <div class="container py-5">
        <h2 class="text-center fw-bold mb-5">Track Your Order</h2>

        <div class="row g-4">

            <div class="col-lg-7">
                <div class="tracking-card">
                    <h4 class="fw-bold">
                        Order ID :
                        <span class="text-primary">
                            #LUV<?php echo $order_id; ?>
                        </span>
                    </h4>

                    <p class="text-muted">
                        Placed on
                        <?php echo date("d M Y", strtotime($date)); ?>
                    </p>

                    <span class="badge bg-<?php echo $badge; ?> mb-4">
                        <?php echo $status; ?>
                    </span>

                    <?php
                    include '../../php/db.php';

                    // දැනට test කරන්න
                    

                    $steps = [
                        ["name" => "Order Placed", "icon" => "fa-check"],
                        ["name" => "Confirmed", "icon" => "fa-check"],
                        ["name" => "Processing", "icon" => "fa-box"],
                        ["name" => "Shipped", "icon" => "fa-truck"],
                        ["name" => "Delivered", "icon" => "fa-house"]
                    ];

                    $current = array_search($status, array_column($steps, 'name'));

                    ?>

                    <div class="timeline">

                        <?php foreach ($steps as $index => $step) { ?>

                            <?php

                            if ($index < $current) {
                                $class = "completed";
                                $icon = "fa-check";
                            } elseif ($index == $current) {
                                $class = "active";
                                $icon = $step['icon'];
                            } else {
                                $class = "";
                                $icon = $step['icon'];
                            }

                            ?>

                            <div class="timeline-item <?= $class ?>">

                                <div class="circle">
                                    <i class="fa-solid <?= $icon ?>"></i>
                                </div>

                                <div class="content">

                                    <h5><?= $step['name']; ?></h5>

                                    <?php if ($index <= $current) { ?>

                                        <p><?= date("d M Y - h:i A"); ?></p>

                                    <?php } else { ?>

                                        <p>Expected</p>

                                    <?php } ?>

                                </div>

                            </div>


                        <?php } ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="tracking-card">
                    <h4 class="fw-bold mb-4">Order Details</h4>

                    <?php

                    $item_query = mysqli_query(
                        $conn,
                        "SELECT order_items.quantity,
                        products.product_name,
                        products.image
                        FROM order_items
                        JOIN products
                        ON order_items.product_id = products.product_id
                        WHERE order_items.order_id='$order_id'"
                    );

                    while ($item = mysqli_fetch_assoc($item_query)) {
                        ?>

                        <div class="order-product">

                            <img src="../../images/<?php echo $item['image']; ?>">

                            <div class="flex-grow-1">

                                <h6>
                                    <?php echo $item['product_name']; ?>
                                </h6>

                            </div>

                            <span>
                                x<?php echo $item['quantity']; ?>
                            </span>

                        </div>

                    <?php } ?>


                    <div class="d-flex justify-content-between">

                        <span>Total Amount</span>

                        <strong class="text-primary">
                            Rs. <?php echo number_format($total, 2); ?>
                        </strong>

                    </div>




                    <a href="../../php/invoice.php?order_id=<?= $order['order_id']; ?>"
                        class="btn invoice-btn w-100 mt-3">
                        View Invoice
                    </a>

                    <a href="../home/home.php" class="btn btn-outline-primary w-100 mt-3">
                        Continue Shopping
                    </a>

                </div>

            </div>
        </div>

</body>

</html>