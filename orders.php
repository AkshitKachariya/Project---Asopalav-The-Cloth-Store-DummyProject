<?php
include('./db_con.php');
session_start();

if (!isset($_SESSION['session'])) {
    header("Location: login.php");
    exit();
}

$sessionID = $_SESSION['session'];
$user_query = mysqli_query($db, "SELECT * FROM users WHERE user_email ='$sessionID'");
$fetch_user = mysqli_fetch_array($user_query);
$user_id = $fetch_user['user_id'];

$userVise = mysqli_query($db, "SELECT * FROM orders WHERE user_id = '$user_id'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
</head>

<body class="flex flex-col min-h-screen">
    <header class="sticky top-0 z-10 shadow-md bg-white">
        <?php include('./main_header.php'); ?>
    </header>

    <main class="flex-grow py-10 px-4 lg:px-16">
        <h1 class="text-center text-3xl font-bold uppercase mb-10 text-gray-800">Your Orders</h1>

        <?php
        if (mysqli_num_rows($userVise) > 0) {
            $orderNo = 1;
            while ($row = mysqli_fetch_array($userVise)) {

                $product_id    = explode(",", $row['product_id']);
                $product_name  = explode(",", $row['product_name']);
                $product_size  = explode(",", $row['product_size']);
                $product_qty   = explode(",", $row['product_qty']);
                $product_price = explode(",", $row['product_price']);

                $orderValue = 0;
        ?>
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border">
                    <!-- Order Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b pb-4">
                        <div class="mb-2 md:mb-0">
                            <p class="font-semibold text-gray-700">Order No: <span class="text-gray-900"><?php echo $orderNo++; ?></span></p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Order Date: <span class="text-gray-500"><?php echo date("d-m-Y", strtotime($row['order_date'])); ?></span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 border-b pb-4">
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Customer Info</h3>
                            <p><span class="font-semibold">Name:</span> <?php echo $row['shopping_firstname'] . ' ' . $row['shopping_lastname']; ?></p>
                            <p><span class="font-semibold">Email:</span> <?php echo $row['contact_email']; ?></p>
                            <p><span class="font-semibold">Phone:</span> <?php echo $row['contact_phone']; ?></p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Address</h3>
                            <p><?php echo $row['shopping_address']; ?></p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Location</h3>
                            <p><span class="font-semibold">State:</span> <?php echo $row['shopping_city'] . ", " . $row['shopping_state']; ?></p>
                            <p><span class="font-semibold">Country:</span> <?php echo $row['shopping_country']; ?></p>
                            <p><span class="font-semibold">Pincode:</span> <?php echo $row['shopping_pincode']; ?></p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Order Value</h3>
                            <p class="font-semibold text-lg">
                                ₹<?php echo number_format($row['total_amount'], 2); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Product Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border text-sm text-left rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border w-24">Image</th>
                                    <th class="px-4 py-2 border">Product Name</th>
                                    <th class="px-4 py-2 border">Size</th>
                                    <th class="px-4 py-2 border">Qty</th>
                                    <th class="px-4 py-2 border">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($product_id); $i++) {
                                    $pid   = $product_id[$i];
                                    $pname = $product_name[$i];
                                    $psize = $product_size[$i];
                                    $pqty  = $product_qty[$i];
                                    $pprice = $product_price[$i];

                                    $productQuery = mysqli_query($db, "SELECT * FROM products WHERE product_id = '$pid'");
                                    $productData = mysqli_fetch_array($productQuery);
                                ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-4 py-2 border">
                                            <img src="./images/<?php echo $productData['image1']; ?>" class="w-16 object-cover rounded-lg">
                                        </td>
                                        <td class="px-4 py-2 border"><?php echo $pname; ?></td>
                                        <td class="px-4 py-2 border"><?php echo $psize; ?></td>
                                        <td class="px-4 py-2 border"><?php echo $pqty; ?></td>
                                        <td class="px-4 py-2 border">₹<?php echo number_format($pprice); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>


                </div>
        <?php
            }
        } else {

            echo "<p class='text-center text-gray-600 text-lg'>No orders found.</p>";
            echo "<p class='text-center'><a href='shop.php' class=' text-gray-600 text-sm underline'>Explore Out Shop</a></p>";
        }
        ?>
    </main>

    <footer class="mt-auto mb-10 lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>
</body>

</html>