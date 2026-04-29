<?php
include('check_session.php');
include('../db_con.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
</head>

<body>
    <?php include('./admin_parts/header.php'); ?>
    <?php include('./admin_parts/sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">
        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Orders :</h2>

        <?php
        $order_data = mysqli_query($db, "SELECT * FROM orders ORDER BY order_id DESC");

        if (mysqli_num_rows($order_data) > 0) {
        ?>
            <div class="space-y-6">
                <?php
                $orders = 1;
                $no = mysqli_num_rows($order_data);
                while ($order = mysqli_fetch_assoc($order_data)) {
                ?>
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4">
                        <div class="flex justify-between items-center border-b pb-2 mb-3">
                            <div>
                                <h3 class="text-lg font-semibold text-[#512DA8]">
                                    Order #<?php echo $no--; ?>
                                </h3>
                                <p class="text-sm text-gray-600">
                                    <?php echo $order['shopping_firstname'] . " " . $order['shopping_lastname']; ?> &nbsp;&nbsp;|&nbsp;&nbsp;
                                    <?php echo $order['contact_email']; ?> &nbsp;&nbsp;|&nbsp;&nbsp;
                                    <?php echo $order['contact_phone']; ?>
                                </p>

                                <p class="text-sm text-gray-600">
                                    <?php echo $order['shopping_address'] . ", " . $order['shopping_city'] . ", " . $order['shopping_state'] . " - " . $order['shopping_pincode'] . ", " . $order['shopping_country']; ?>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-[#512DA8]">₹<?php echo number_format($order['total_amount']); ?></p>
                                <p class="text-sm text-gray-500">
                                    Date: <?php echo date('d-m-y', strtotime($order['order_date'])); ?>
                                </p>

                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left border-collapse border" style="border-color:#512DA8; border-width:1px;">
                                <thead class="bg-purple-200 text-purple-900 font-semibold">
                                    <tr>
                                        <th class="px-4 py-2" style="border:1px solid #512DA8;">Product</th>
                                        <th class="px-4 py-2" style="border:1px solid #512DA8;">Size</th>
                                        <th class="px-4 py-2" style="border:1px solid #512DA8;">Price</th>
                                        <th class="px-4 py-2" style="border:1px solid #512DA8;">Qty</th>
                                        <th class="px-4 py-2" style="border:1px solid #512DA8;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $names = explode(',', $order['product_name']);
                                    $sizes = explode(',', $order['product_size']);
                                    $prices = explode(',', $order['product_price']);
                                    $qtys  = explode(',', $order['product_qty']);
                                    $product_ids = explode(',', $order['product_id']);

                                    for ($i = 0; $i < count($names); $i++) {
                                        $subtotal = (float)$qtys[$i] * (float)$prices[$i];
                                        $pid = $product_ids[$i];
                                        $img_query = mysqli_query($db, "SELECT * FROM products WHERE product_id='$pid'");
                                        $img_data = mysqli_fetch_assoc($img_query);
                                    ?>
                                        <tr class="hover:bg-purple-100 transition">
                                            <td class="px-4 py-2 flex items-center space-x-3">
                                                <img src="../images/<?php echo $img_data['image1']; ?>" class="w-12 border-gray-300 object-cover rounded" alt="Product">
                                                <span><?php echo $names[$i]; ?></span>
                                            </td>
                                            <td class="px-4 py-2" style="border:1px solid #512DA8;"><?php echo $sizes[$i]; ?></td>
                                            <td class="px-4 py-2" style="border:1px solid #512DA8;">₹<?php echo number_format($prices[$i], 2); ?></td>
                                            <td class="px-4 py-2" style="border:1px solid #512DA8;"><?php echo $qtys[$i]; ?></td>
                                            <td class="px-4 py-2" style="border:1px solid #512DA8;">₹<?php echo number_format($subtotal, 2); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php
        } else {
            echo "<p class='text-gray-600 text-center mt-8'>No orders found.</p>";
        }
        ?>
    </main>

    <?php include('./admin_parts/footer.php'); ?>
</body>

</html>