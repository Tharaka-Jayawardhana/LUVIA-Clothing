<?php
include '../../php/db.php';

session_start();

$user = null;
$user_id = null;

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE user_id='$user_id'"
    );

    $user = mysqli_fetch_assoc($result);
}

$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

}

$category_id = "";

if (isset($_GET['category_id'])) {

    $category_id = $_GET['category_id'];

}


$sql = "SELECT products.*, categories.category_name
        FROM products
        JOIN categories
        ON products.category_id = categories.category_id
        WHERE REPLACE(products.product_name,' ','') 
        LIKE REPLACE('%$search%',' ','')";

if ($category_id != "") {

    $sql .= " AND products.category_id='$category_id'";

}

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}


$count_query = mysqli_query(
    $conn,
    "SELECT SUM(quantity) as total
     FROM cart
     WHERE user_id='$user_id'"
);

$count = mysqli_fetch_assoc($count_query);

$total_cart = $count['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Home</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS FILE -->

    <link rel="stylesheet" href="../style.css">

</head>

<body class="products-page">

    <!-- TOP NAVBAR -->

    <header>

        <div class="top-navbar">

            <!-- Logo -->
            <div class="nav-logo d-flex align-items-center">
                <img src="../../images/logo.png" class="img-fluid rounded-circle me-2" alt="Logo"
                    style="width:60px; height:60px; object-fit:cover;">

                <div>
                    <h1 class="m-0">LUVIA</h1>
                    <small class="text-muted">Design Your Style</small>
                </div>
            </div>
            <!-- Search BAR-->
            <form id="search-form" action="../products/products.php" method="GET" class="search-bar">

                <input type="text" id="search-input" name="search" placeholder="Search for products...">

                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

            </form>

            <!-- Icons -->
            <div class="nav-icons">

                <!-- Voice Search -->
                <div class="voice-search" id="voice-search-btn">
                    <i class="fa-solid fa-microphone"></i>
                    <span>Voice Search</span>
                </div>


                <div class="cart-icon">

                    <?php if (isset($_SESSION['user_id'])) { ?>

                        <a href="../cart/cart.php" class="text-decoration-none text-dark">

                            <i class="fa-solid fa-cart-shopping"></i>

                            <span class="cart-count">
                                <?= $total_cart; ?>
                            </span>

                        </a>

                    <?php } else { ?>

                        <a href="../login/login.php" class="text-decoration-none text-dark">

                            <i class="fa-solid fa-cart-shopping"></i>

                            <span class="cart-count">
                                <?= $total_cart; ?>
                            </span>

                        </a>

                    <?php } ?>


                </div>

                <?php if (isset($_SESSION['user_id']) && $user) { ?>

                    <a href="../profile/my_profile.php" class="user-profile text-decoration-none text-dark">
                        <i class="fa-regular fa-user"></i>
                        <span>Hello<br><?= htmlspecialchars($user['full_name']); ?></span>
                    </a>

                <?php } else { ?>

                    <a href="../login/login.html" class="user-profile text-decoration-none text-dark">
                        <i class="fa-regular fa-user"></i>
                        <span>Login/Register</span>
                    </a>

                <?php } ?>


            </div>

        </div>

        <!-- MAIN NAVBAR -->

        <nav>

            <ul>
                <li><a href="../home/home.php">Home</a></li>

                <li><a href="../products/products.php">Products</a></li>

                <li><a href="../customize/customize.php">Customize</a></li>

                <li><a href="../point/loyalty_point.php">Offers</a></li>

                <li><a href="../contact/contact.php">Contact</a></li>
            </ul>

    </header>

    <!-- PRODUCTS HEADING -->

    <section class="products-heading">

        <h2>Our Products</h2>

        <p>Explore trendy and customizable apparel</p>

    </section>

    <!-- CATEGORY BUTTONS -->

    <div class="container text-center mt-4">

        <a href="products.php" class="btn btn-primary m-2">
            All
        </a>


        <a href="products.php?category_id=1" class="btn btn-outline-primary m-2">
            Plain T-Shirts
        </a>


        <a href="products.php?category_id=2" class="btn btn-outline-primary m-2">
            Hoodies
        </a>

        <a href="products.php?category_id=4" class="btn btn-outline-primary m-2">
            Ladies
        </a>


        <a href="products.php?category_id=5" class="btn btn-outline-primary m-2">
            Gents
        </a>

    </div>

    <!-- PRODUCT CARDS -->

    <div class="container mt-5">
        <div class="row g-4">

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="col-md-3">

                    <div class="card product-card p-3">

                        <img src="../../images/<?php echo $row['image']; ?>" class="img-fluid">
                        <h4 class="mt-3">
                            <?php echo $row['product_name']; ?>
                        </h4>
                        <p>
                            Rs. <?php echo $row['price']; ?>
                        </p>

                        <div class="buttons d-flex justify-content-center">

                            <a href="products_details.php?id=<?= $row['product_id']; ?>" class="btn btn-primary">
                                View Details
                            </a>


                            <form action="../../php/add_to_cart.php" method="POST">

                                <input type="hidden" name="product_id" value="<?= $row['product_id']; ?>">

                                <input type="hidden" name="size" value="M">

                                <input type="hidden" name="color" value="white">


                                <button type="submit" name="add_cart" class="btn btn-dark">

                                    Add To Cart

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>
    </div>

    <!-- FOOTER -->

    <footer class="footer mt-5">

        <h3>LUVIA</h3>

        <p>Customize your fashion with AI powered shopping</p>

    </footer>

    <script>

        const voiceBtn = document.getElementById("voice-search-btn");
        const searchInput = document.getElementById("search-input");

        const SpeechRecognition =
            window.SpeechRecognition ||
            window.webkitSpeechRecognition;

        if (SpeechRecognition) {

            const recognition = new SpeechRecognition();

            recognition.lang = "en-US";
            recognition.continuous = false;
            recognition.interimResults = false;

            voiceBtn.addEventListener("click", function () {

                recognition.start();

                voiceBtn.innerHTML =
                    '<i class="fa-solid fa-microphone"></i> Listening...';

            });

            recognition.onresult = function (event) {

                const text = event.results[0][0].transcript;

                searchInput.value = text;

                document.getElementById("search-form").submit();

            };

            recognition.onend = function () {

                voiceBtn.innerHTML =
                    '<i class="fa-solid fa-microphone"></i><span> Voice Search</span>';

            };

        }
        else {
            alert("Voice Search is not supported in this browser");
        }

    </script>

</body>

</html>