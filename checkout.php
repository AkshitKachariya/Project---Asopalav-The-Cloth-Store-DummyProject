<?php
include('./db_con.php');
session_start();

if (!isset($_SESSION['session'])) {
    header("Location: login.php");
    exit();
}

$sessionID = $_SESSION['session'];
$user_query = mysqli_query($db, "SELECT * FROM users WHERE user_email ='$sessionID' ");
$fetch_user = mysqli_fetch_array($user_query);
$user_id = $fetch_user['user_id'];

$cart_result = mysqli_query($db, "SELECT * FROM cart WHERE user_id = '$user_id' ORDER BY cart_id DESC");
$cart_count = mysqli_num_rows($cart_result);

if (isset($_REQUEST['insert_orders'])) {

    // Get all form fields and sanitize them
    $contact_email = $_REQUEST['contact_email'];
    $contact_phone = $_REQUEST['contact_phone'];
    $shopping_firstname = $_REQUEST['shopping_firstname'];
    $shopping_lastname = $_REQUEST['shopping_lastname'];
    $shopping_address = $_REQUEST['shopping_address'];
    $shopping_pincode = $_REQUEST['shopping_pincode'];
    $shopping_country = $_REQUEST['shopping_country'];
    $shopping_state = $_REQUEST['shopping_state'];
    $shopping_city = $_REQUEST['shopping_city'];

    $grand_total = 0;

    $cart_ids = [];
    $product_ids = [];
    $product_names = [];
    $product_sizes = [];
    $product_qtys = [];
    $product_prices = [];

    $cart_result_for_total = mysqli_query($db, "SELECT * FROM cart WHERE user_id = '$user_id'");
    while ($cart_item = mysqli_fetch_assoc($cart_result_for_total)) {
        $grand_total += $cart_item['product_price'] * $cart_item['product_qty'];

        $cart_ids[]     = $cart_item['cart_id'];
        $product_ids[]   = $cart_item['product_id'];
        $product_names[] = $cart_item['product_name'];
        $product_sizes[] = $cart_item['product_size'];
        $product_qtys[]  = $cart_item['product_qty'];
        $product_prices[] = $cart_item['product_price'];
    }

    // Convert arrays into comma-separated values
    $cart_ids_str     = implode(",", $cart_ids);
    $product_ids_str   = implode(",", $product_ids);
    $product_names_str = implode(",", $product_names);
    $product_sizes_str = implode(",", $product_sizes);
    $product_qtys_str  = implode(",", $product_qtys);
    $product_prices_str = implode(",", $product_prices);

    // Insert into the orders table
    $insert_order_query = "INSERT INTO orders 
    (user_id, total_amount, contact_email, contact_phone, shopping_firstname, shopping_lastname, shopping_address, shopping_city, shopping_state, shopping_country, shopping_pincode, cart_id, product_id, product_name, product_size, product_qty, product_price) 
    VALUES 
    ('$user_id', '$grand_total', '$contact_email', '$contact_phone', '$shopping_firstname', '$shopping_lastname', '$shopping_address', '$shopping_city', '$shopping_state', '$shopping_country', '$shopping_pincode', '$cart_ids_str', '$product_ids_str', '$product_names_str', '$product_sizes_str', '$product_qtys_str', '$product_prices_str')";

    if (mysqli_query($db, $insert_order_query)) {
        $clear_cart_query = "DELETE FROM cart WHERE user_id = '$user_id'";
        mysqli_query($db, $clear_cart_query);

        header("Location: user_information.php");
        exit();
    } else {
        echo "Error placing order: " . mysqli_error($db);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
</head>

<body class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col">
    <main class="flex-1">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <header class="flex items-center justify-between py-4 px-6 bg-white border border-gray-200 shadow-sm mb-10 rounded-2xl">
                <div class="flex-shrink-0" title="Home">
                    <a href="./home.php">
                        <img src="./images/Asopalav Logo.avif" alt="Asopalav Logo" class="h-10 sm:h-12 w-auto">
                    </a>
                </div>
                <div class="cart" title="Cart">
                    <a href="cart.php"
                        class="relative text-gray-700 hover:text-[#bb7431] transition-colors duration-200">
                        <i class="fa-solid fa-cart-shopping text-2xl"></i>
                    </a>
                </div>
            </header>

            <h1 class="text-center text-3xl font-extrabold tracking-wide text-gray-800 uppercase mb-10">
                Checkout
            </h1>

            <?php if ($cart_count > 0) { ?>
                <div class="flex flex-col lg:flex-row gap-4">

                    <section class="flex-1 bg-white shadow-md rounded-2xl p-4 border border-gray-100 lg:sticky lg:top-8 lg:h-fit">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-3">Contact & Delivery</h2>

                        <form action="" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <div class="space-y-4 mb-8">
                                <input type="email" placeholder="Enter Your Email Address"
                                    class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] focus:border-[#bb7431] transition outline-none" name="contact_email" />

                                <input type="tel" placeholder="Enter Your Phone Number"
                                    class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] focus:border-[#bb7431] transition outline-none" name="contact_phone" />
                            </div>

                            <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-3">Shipping Address</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <input type="text" placeholder="First Name"
                                    class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] outline-none" name="shopping_firstname" />
                                <input type="text" placeholder="Last Name"
                                    class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] outline-none" name="shopping_lastname" />
                            </div>

                            <textarea placeholder="Delivery Address" rows="3"
                                class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] mb-4 outline-none" name="shopping_address"></textarea>

                            <input type="text" placeholder="Postal Code"
                                class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] mb-4 outline-none" name="shopping_pincode" />

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                                <input type="text" placeholder="Country"
                                    class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] outline-none" name="shopping_country" />
                                <input type="text" placeholder="State"
                                    class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] outline-none" name="shopping_state" />
                                <input type="text" placeholder="City"
                                    class="w-full border border-gray-300 rounded-lg shadow-sm p-3 text-base focus:ring-2 focus:ring-[#bb7431] outline-none" name="shopping_city" />
                            </div>

                            <button type="submit" name="insert_orders"
                                class="w-full bg-[#bb7431] text-white text-lg font-semibold rounded-lg py-3 hover:bg-[#9b5f26] transition cursor-pointer">
                                Place Order
                            </button>
                        </form>
                    </section>

                    <section class="w-full lg:w-1/3  shadow-md rounded-2xl p-4 border border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-3">Order Summary</h2>

                        <div class="space-y-5">
                            <?php
                            $grand_total = 0;
                            mysqli_data_seek($cart_result, 0);
                            while ($cart_item = mysqli_fetch_assoc($cart_result)) {
                                $product_total = $cart_item['product_price'] * $cart_item['product_qty'];
                                $grand_total += $product_total;

                                $product_image_query = "SELECT image1 FROM products WHERE product_id = " . (int)$cart_item['product_id'];
                                $product_image_result = mysqli_query($db, $product_image_query);
                                $product_image = mysqli_fetch_assoc($product_image_result);
                            ?>
                                <div class="flex items-center gap-4 rounded-lg border border-gray-200 p-4 hover:shadow-md transition">
                                    <?php if ($product_image) { ?>
                                        <img src="images/<?php echo htmlspecialchars($product_image['image1']); ?>"
                                            alt="<?php echo htmlspecialchars($cart_item['product_name']); ?>"
                                            class="w-15 object-cover rounded-lg border border-gray-200">
                                    <?php } ?>

                                    <div class="flex flex-col flex-grow">
                                        <h3 class="font-medium text-gray-800 text-base">
                                            <?php echo htmlspecialchars($cart_item['product_name']); ?>
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Size: <?php echo htmlspecialchars($cart_item['product_size']); ?>
                                        </p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-sm text-gray-600">
                                                Qty: <?php echo htmlspecialchars($cart_item['product_qty']); ?>
                                            </span>
                                            <span class="text-sm font-semibold text-gray-800">
                                                Rs. <?php echo number_format($cart_item['product_price']); ?>/-
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="mt-8 border-t-1 pt-4">
                            <div class="flex justify-between items-center text-lg text-gray-900">
                                <span>Total:</span>
                                <span class="text-[#bb7431] font-semibold">Rs. <?php echo number_format($grand_total); ?>/-</span>
                            </div>
                        </div>
                    </section>
                </div>

            <?php } else { ?>
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl shadow-lg">
                    <i class="fa-solid fa-cart-shopping text-6xl text-gray-400 mb-6"></i>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">Your cart is empty</h2>
                    <p class="text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
                    <a href="shop.php" class="bg-[#bb7431] text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-[#9b5f26] transition duration-300">
                        Start Shopping
                    </a>
                </div>
            <?php } ?>

        </div>
    </main>
</body>

</html>