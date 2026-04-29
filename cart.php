<?php
include('./db_con.php');
session_start();

if (!isset($_SESSION['session'])) {
    header("Location: login.php");
    exit();
}

$sessionID = $_SESSION['session'];
$user_query = mysqli_query($db, "select * from users where user_email ='$sessionID' ");
$fetch_user = mysqli_fetch_array($user_query);
$user_id = $fetch_user['user_id'];

if (isset($_POST['cart_id']) && isset($_POST['new_qty'])) {

    $cart_id = (int)$_POST['cart_id'];
    $new_qty = (int)$_POST['new_qty'];

    if ($new_qty < 1) $new_qty = 1;
    if ($new_qty > 10) $new_qty = 10;

    $check = mysqli_query($db, "SELECT * FROM cart WHERE cart_id='$cart_id' AND user_id='$user_id'");
    if (mysqli_num_rows($check) === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid cart item']);
        exit();
    }

    mysqli_query($db, "UPDATE cart SET product_qty='$new_qty' WHERE cart_id='$cart_id' AND user_id='$user_id'");

    $gt = mysqli_query($db, "SELECT SUM(product_price * product_qty) AS gtotal FROM cart WHERE user_id='$user_id'");
    $gt_f = mysqli_fetch_assoc($gt);
    $grand_total = (int)$gt_f['gtotal'];

    $it = mysqli_query($db, "SELECT product_price * product_qty AS item_total 
                             FROM cart WHERE cart_id='$cart_id'");
    $it_f = mysqli_fetch_assoc($it);
    $item_total = (int)$it_f['item_total'];

    echo json_encode([
        'success' => true,
        'grand_total' => number_format($grand_total),
        'item_total' => number_format($item_total),
        'cart_id' => $cart_id
    ]);
    exit();
}


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    mysqli_query($db, "DELETE FROM cart WHERE cart_id = '$delete_id' AND user_id = '$user_id'");
    header("Location: cart.php");
    exit();
}

$cart_result = mysqli_query($db, "SELECT * FROM cart WHERE user_id = '$user_id' order by cart_id desc");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
</head>

<body>
    <header class="sticky top-0 z-10">
        <?php include('./main_header.php'); ?>
    </header>

    <main class="py-10 px-4 lg:px-16">
        <h1 class="text-center text-3xl font-bold uppercase mb-8">Your Cart</h1>

        <?php if (mysqli_num_rows($cart_result) > 0) { ?>
            <div class="flex flex-col lg:flex-row gap-10">
                <div class="w-full lg:w-4/5">
                    <div class="hidden lg:block bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 w-1/2">Product</th>
                                    <th class="px-6 py-3 w-1/6">Price</th>
                                    <th class="px-6 py-3 w-1/6">Quantity</th>
                                    <th class="px-6 py-3 w-1/6">Subtotal</th>
                                    <th class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php
                                $grand_total = 0;
                                mysqli_data_seek($cart_result, 0);
                                while ($cart_item = mysqli_fetch_assoc($cart_result)) {

                                    $product_total = $cart_item['product_price'] * $cart_item['product_qty'];
                                    $grand_total += $product_total;

                                    $product_image_query = "SELECT image1 FROM products WHERE product_id = " . $cart_item['product_id'];
                                    $product_image_result = mysqli_query($db, $product_image_query);
                                    $product_image = mysqli_fetch_assoc($product_image_result);
                                ?>
                                    <tr class="hover:bg-gray-50 transition-colors" id="cart-row-<?php echo $cart_item['cart_id']; ?>">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <?php if ($product_image) { ?>
                                                    <img src="images/<?php echo htmlspecialchars($product_image['image1']); ?>"
                                                        alt="<?php echo htmlspecialchars($cart_item['product_name']); ?>"
                                                        class="w-20 object-cover rounded-xl shadow-sm border border-gray-200">
                                                <?php } ?>
                                                <div>
                                                    <p class="font-semibold text-gray-800 text-sm tracking-wide">
                                                        <?php echo htmlspecialchars($cart_item['product_name']); ?>
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1">Size:
                                                        <span class="font-medium text-gray-600">
                                                            <?php echo htmlspecialchars($cart_item['product_size']); ?>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-gray-700 font-medium">
                                            Rs. <?php echo number_format($cart_item['product_price']); ?>/-
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2 quantity-control 
                        bg-gray-100 px-2 py-1 rounded-full border border-gray-300 shadow-sm"
                                                data-cart-id="<?php echo $cart_item['cart_id']; ?>">

                                                <button
                                                    class="qty-btn w-7 h-7 flex items-center justify-center rounded-full border border-gray-300 bg-white
                           text-gray-600 text-sm hover:bg-[#c28e5c] hover:text-white transition-all active:scale-90 shadow"
                                                    onclick="updateQty(<?php echo $cart_item['cart_id']; ?>, -1)">
                                                    -
                                                </button>

                                                <input type="text"
                                                    id="qty-<?php echo $cart_item['cart_id']; ?>"
                                                    class="w-10 text-center text-sm font-semibold bg-transparent focus:outline-none"
                                                    value="<?php echo htmlspecialchars($cart_item['product_qty']); ?>"
                                                    readonly>

                                                <button
                                                    class="qty-btn w-7 h-7 flex items-center justify-center rounded-full border border-gray-300 bg-white
                           text-gray-600 text-sm hover:bg-[#c28e5c] hover:text-white transition-all active:scale-90 shadow"
                                                    onclick="updateQty(<?php echo $cart_item['cart_id']; ?>, 1)">
                                                    +
                                                </button>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-gray-700 item-total font-semibold"
                                            id="total-<?php echo $cart_item['cart_id']; ?>">
                                            Rs. <?php echo number_format($product_total); ?>/-
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <a href="cart.php?delete_id=<?php echo $cart_item['cart_id']; ?>"
                                                onclick="return confirm('Are you sure you want to delete this item?');"
                                                class="text-red-500 hover:text-red-700 transition" title="Remove Item">
                                                <i class="fas fa-trash text-lg"></i>
                                            </a>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>

                    <div class="grid gap-6 lg:hidden">
                        <?php
                        mysqli_data_seek($cart_result, 0);
                        while ($cart_item = mysqli_fetch_assoc($cart_result)) {
                            $product_total = $cart_item['product_price'] * $cart_item['product_qty'];
                            $product_image_query = "SELECT image1 FROM products WHERE product_id = " . $cart_item['product_id'];
                            $product_image_result = mysqli_query($db, $product_image_query);
                            $product_image = mysqli_fetch_assoc($product_image_result);
                        ?>
                            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200" id="cart-row-mobile-<?php echo $cart_item['cart_id']; ?>">
                                <div class="flex items-start space-x-4">
                                    <?php if ($product_image) { ?>
                                        <img src="images/<?php echo htmlspecialchars($product_image['image1']); ?>" alt="<?php echo htmlspecialchars($cart_item['product_name']); ?>" class="w-20 object-cover rounded-lg">
                                    <?php } ?>
                                    <div class="flex-grow">
                                        <h3 class="font-medium text-base text-gray-800 leading-tight"><?php echo htmlspecialchars($cart_item['product_name']); ?></h3>
                                        <p class="text-sm text-gray-500 mt-1">Size: <?php echo htmlspecialchars($cart_item['product_size']); ?></p>
                                        <div class="flex items-center justify-between mt-3">
                                            <span class="text-sm text-gray-600">Price: Rs. <?php echo number_format($cart_item['product_price']); ?>/-</span>
                                            <span class="text-sm font-medium text-gray-800 item-total" id="total-mobile-<?php echo $cart_item['cart_id']; ?>">Total: Rs. <?php echo number_format($product_total); ?>/-</span>
                                        </div>
                                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                            <span class="text-sm text-gray-600">Quantity:</span>
                                            <div class="flex items-center space-x-2 quantity-control" data-cart-id="<?php echo $cart_item['cart_id']; ?>">
                                                <button class="qty-btn text-gray-500 hover:text-[#c28e5c] transition w-6 h-6 border border-gray-300 rounded-md text-sm flex items-center justify-center p-0" onclick="updateQty(<?php echo $cart_item['cart_id']; ?>, -1)">-</button>
                                                <input type="text" id="qty-mobile-<?php echo $cart_item['cart_id']; ?>" class="w-12 text-center text-sm py-1 border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($cart_item['product_qty']); ?>" readonly>
                                                <button class="qty-btn text-gray-500 hover:text-[#c28e5c] transition w-6 h-6 border border-gray-300 rounded-md text-sm flex items-center justify-center p-0" onclick="updateQty(<?php echo $cart_item['cart_id']; ?>, 1)">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-auto flex-shrink-0">
                                        <a href="cart.php?delete_id=<?php echo $cart_item['cart_id']; ?>" class="text-red-500 hover:text-red-700 transition" title="Remove Item">
                                            <i class="fas fa-trash text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="w-full lg:w-1/5">
                    <div class="sticky top-24 p-6 bg-white rounded-xl border border-gray-200 shadow-md">
                        <div class="flex flex-row lg:flex-col xl:flex-row justify-between lg:items-start xl:items-center pb-4 mb-4 border-b border-gray-200">
                            <span class="text-lg font-medium text-gray-600">Total:</span>
                            <span class="text-lg font-bold text-gray-800 lg:mt-2 xl:mt-0" id="grand-total-display">Rs.&nbsp;<?php echo number_format($grand_total); ?>/-</span>
                        </div>

                        <a href="checkout.php" class="block w-full">
                            <button class="w-full py-3 bg-[#c28e5c] text-white font-semibold rounded-md hover:text-[#c28e5c] hover:bg-white transition-colors mb-3 border-2 border-[#c28e5c] cursor-pointer">
                                <span class="lg:hidden">Proceed to Checkout</span>
                                <span class="hidden lg:inline xl:hidden">Checkout</span>
                                <span class="hidden xl:inline">Proceed to Checkout</span>
                            </button>
                        </a>
                        <a href="shop.php" class="block text-center text-sm text-gray-600 hover:text-[#c28e5c] transition-colors underline">
                            <span class="lg:hidden">Continue Shopping</span>
                            <span class="hidden lg:inline xl:hidden">Shop</span>
                            <span class="hidden xl:inline">Continue Shopping</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="text-center mt-10 py-[35px]" id="empty-cart-message">
                <p class="text-xl text-gray-500 mb-4">Your cart is empty.</p>
                <a href="shop.php" class="text-[#c28e5c] font-medium underline hover:text-[#a97d4d] transition-colors">
                    Explore Our Shop
                </a>
            </div>
        <?php } ?>
    </main>

    <footer class="mb-10 lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>

    <script>
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        async function updateQty(cartId, delta) {
            const qtyInput = document.getElementById(`qty-${cartId}`) ||
                document.getElementById(`qty-mobile-${cartId}`);

            let currentQty = parseInt(qtyInput.value);
            let newQty = currentQty + delta;

            if (newQty < 1) newQty = 1;
            if (newQty > 10) newQty = 10;

            if (newQty === currentQty) return;

            qtyInput.value = newQty;

            try {
                const response = await fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `cart_id=${cartId}&new_qty=${newQty}`
                });

                const data = await response.json();

                if (!data.success) {
                    // Revert quantity if update failed
                    qtyInput.value = currentQty;
                    alert("Something went wrong!");
                    return;
                }

                location.reload();

            } catch (error) {
                qtyInput.value = currentQty;
                alert("Network error!");
            }
        }
    </script>
</body>

</html>