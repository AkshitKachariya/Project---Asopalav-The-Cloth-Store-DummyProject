<?php
include('./db_con.php');
session_start();

if (isset($_REQUEST['pro'])) {
    $item = $_REQUEST['pro'];
    $query = mysqli_query($db, "SELECT * FROM products WHERE product_id = '$item'");
}

$fetch_store_details = mysqli_query($db, "select * from store_details");
$store_details = mysqli_fetch_array($fetch_store_details);

if (isset($_SESSION['session'])) {
    $sessionID = $_SESSION['session'];
    $user_query = mysqli_query($db, "select * from users where user_email ='$sessionID' ");
    $fetch_user = mysqli_fetch_array($user_query);
}

if (isset($_REQUEST['addToCart'])) {
    $user_id = $_REQUEST['user_id'];
    $product_id = $_REQUEST['product_id'];
    $product_name = $_REQUEST['product_name'];
    $product_price = $_REQUEST['product_price'];
    $product_qty = $_REQUEST['product_qty'];
    $product_size = $_REQUEST['product_size'];

    $check = mysqli_query($db, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id' AND product_size='$product_size'");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('This product is already in your cart!'); window.location.href='cart.php';</script>";
    } else {
        $sql = "INSERT INTO cart (user_id, product_id, product_name, product_price, product_qty, product_size) 
                VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_qty', '$product_size')";
        $result = mysqli_query($db, $sql);
        header("Location: cart.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <style>
        .image-container {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
        }

        .mySlides {
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        .mySlides.active {
            opacity: 1;
            position: relative;
        }

        .thumbnails-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .thumbnails-container {
            overflow-x: hidden;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }

        .thumbnails {
            display: inline-flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .thumbnail-col {
            width: calc(100% / 3 - (2rem / 3));
            flex-shrink: 0;
        }

        .thumbnail-img {
            width: 100%;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s ease, border 0.3s ease;
            border: 1px solid gray;
            border-radius: 12px;
        }

        .thumbnail-img:hover {
            opacity: 1;
        }

        .active-thumbnail {
            opacity: 1;
            border: 1px solid #c28e5c;
            border-radius: 12px;
        }

        .scroll-btn {
            background: #fff;
            border: 1px solid gray;
            padding: 0.5rem;
            cursor: pointer;
            z-index: 5;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 12px;
        }

        .scroll-btn-left {
            left: 0;
        }

        .scroll-btn-right {
            right: 0;
        }

        /* Styles for Size Radio Buttons */
        .sizes input[type="radio"] {
            display: none;
        }

        .sizes label {
            display: inline-block;
            padding: 8px 15px;
            border: 1px solid #ccc;
            cursor: pointer;
            margin-right: 5px;
            transition: all 0.2s ease-in-out;
        }

        .sizes input[type="radio"]:checked+label {
            border: 1px solid black;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .sizes label:hover {
            border-color: #555;
            background-color: #f0f0f0;
        }

        /* Styles for Sticky Right Column */
        @media (min-width: 768px) {
            .product-container {
                display: flex;
                flex-direction: row;
                align-items: flex-start;
            }

            .right_product {
                position: sticky;
                top: 60px;
                align-self: flex-start;
            }
        }

        /* New table styles for product details */
        .product-details-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            font-size: 14px;
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #DCDCDC;
        }

        .product-details-table th,
        .product-details-table td {
            padding: 10px 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .product-details-table th {
            background-color: #f7f7f7;
            font-weight: 600;
            color: #4a4a4a;
            width: 40%;
            position: relative;
            border-right: 1px solid #e0e0e0;
        }

        .product-details-table td {
            color: #666;
            background-color: #fff;
        }

        .product-details-table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .product-details-table tr:hover td,
        .product-details-table tr:hover th {
            background-color: #fef5f0;
            transition: background-color 0.3s ease;
        }

        .product-details-table tr:last-child td,
        .product-details-table tr:last-child th {
            border-bottom: none;
        }

        .product-details-table tr:first-child th {
            border-top-left-radius: 12px;
        }

        .product-details-table tr:first-child td {
            border-top-right-radius: 12px;
        }

        .product-details-table tr:last-child th {
            border-bottom-left-radius: 12px;
        }

        .product-details-table tr:last-child td {
            border-bottom-right-radius: 12px;
        }
    </style>
</head>

<body>
    <header class="sticky top-0 z-10">
        <?php include('./main_header.php'); ?>
    </header>
    <main class="py-15 lg:px-15 px-7 space-y-4">
        <div class="text-center text-3xl font-bold uppercase">Shop</div>

        <?php
        while ($products = mysqli_fetch_array($query)) {
        ?>
            <div class="product-container flex flex-col md:flex-row text-[#131313]">
                <div class="left_product w-[100%] md:w-[60%] rounded-2xl p-4 pb-3">
                    <div class="image-container">
                        <img class="mySlides active rounded-xl" src="images/<?php echo $products['image1']; ?>" style="width:100%">
                        <img class="mySlides rounded-xl" src="images/<?php echo $products['image2']; ?>" style="width:100%">
                        <img class="mySlides rounded-xl" src="images/<?php echo $products['image3']; ?>" style="width:100%">
                        <img class="mySlides rounded-xl" src="images/<?php echo $products['image4']; ?>" style="width:100%">

                        <div class="thumbnails-wrapper">
                            <button class="scroll-btn scroll-btn-left" onclick="scrollThumbs(-1)">&#10094;</button>
                            <div class="thumbnails-container">
                                <div class="thumbnails">
                                    <div class="thumbnail-col">
                                        <img class="thumbnail-img active-thumbnail rounded-xl" src="images/<?php echo $products['image1']; ?>" onclick="currentDiv(1)">
                                    </div>
                                    <div class="thumbnail-col">
                                        <img class="thumbnail-img rounded-xl" src="images/<?php echo $products['image2']; ?>" onclick="currentDiv(2)">
                                    </div>
                                    <div class="thumbnail-col">
                                        <img class="thumbnail-img rounded-xl" src="images/<?php echo $products['image3']; ?>" onclick="currentDiv(3)">
                                    </div>
                                    <div class="thumbnail-col">
                                        <img class="thumbnail-img rounded-xl" src="images/<?php echo $products['image4']; ?>" onclick="currentDiv(4)">
                                    </div>
                                </div>
                            </div>
                            <button class="scroll-btn scroll-btn-right" onclick="scrollThumbs(1)">&#10095;</button>
                        </div>
                    </div>
                </div>

                <div class="right_product w-[100%] md:w-[40%] p-5 space-y-3">
                    <div class="name">
                        <p class="text-xl font-bold"><?php echo $products['name']; ?></p>
                    </div>
                    <div class="price">
                        <p class="text-xl font-bold">Rs.<?php echo number_format($products['price']); ?>/-</p>
                    </div>
                    <div class="size_guide">
                        <a href="size_guider.php" class="hover:underline">
                            <p class="cursor-pointer py-2 text-sm"><i class="fas fa-ruler-horizontal"></i> Size Guide </p>
                        </a>
                    </div>
                    <div class="sizes text-sm space-y-1">
                        <p class="text-sm"><strong>Size : </strong><span id="selected-size-display"></span></p>
                        <?php $sizes = explode(',', $products['size']); ?>
                        <?php foreach ($sizes as $index => $size): ?>
                            <input type="radio" id="size-<?php echo trim($size); ?>" name="size" value="<?php echo trim($size); ?>"
                                <?php if ($index === 0) echo 'checked'; ?>>
                            <label for="size-<?php echo trim($size); ?>"><?php echo trim($size); ?></label>
                        <?php endforeach; ?>
                    </div>
                    <div class="msg cursor-default text-sm">
                        <p>
                            For customization requests (additional charges may apply), please contact
                            <strong><?php echo $store_details['store_email']; ?></strong>
                        </p>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $fetch_user['user_id']; ?>" readonly>
                        <input type="hidden" name="product_id" value="<?php echo $products['product_id']; ?>" readonly>
                        <input type="hidden" name="product_name" value="<?php echo $products['name']; ?>" readonly>
                        <input type="hidden" name="product_price" value="<?php echo $products['price']; ?>" readonly>
                        <input type="hidden" name="product_qty" value="1" readonly>
                        <input type="hidden" name="product_size" id="selected_size_hidden" readonly>

                        <div class="btn w-full py-2">
                            <?php
                            if (isset($_SESSION['session']) && $_SESSION['session']) {
                            ?>
                                <input type="submit" value="ADD TO CART" class="border border-[#232323] bg-[#232323] text-white w-full py-2 text-md font-semibold cursor-pointer hover:text-[#232323] hover:bg-white transition duration-400" name="addToCart">
                            <?php
                            } else {
                            ?>
                                <a href="login.php" class="w-full">
                                    <input type="button" value="ADD TO CART" class="border border-[#232323] bg-[#232323] text-white w-full py-2 text-md font-semibold cursor-pointer hover:text-[#232323] hover:bg-white transition duration-400">
                                </a>
                            <?php
                            }
                            ?>
                        </div>
                    </form>

                    <div class="ansure text-sm space-y-1">
                        <div class="one flex">
                            <div class="w-[50%] flex">
                                <p class="w-[20px] text-md"><i class="fas fa-shield-halved text-[#c28e5c]"></i></p>
                                <p>100% Purchase Protection</p>
                            </div>
                            <div class="w-[50%] flex">
                                <p class="w-[20px] text-md"><i class="fas fa-clock-rotate-left text-[#c28e5c]"></i></p>
                                <p>48 hours easy returns</p>
                            </div>
                        </div>
                        <div class="two flex">
                            <div class="w-[50%] flex">
                                <p class="w-[20px] text-md"><i class="fas fa-award text-[#c28e5c]"></i></p>
                                <p>Assured Quality</p>
                            </div>
                            <div class="w-[50%] flex">
                                <p class="w-[20px] text-md"><i class="fas fa-money-bill-wave text-[#c28e5c]"></i></p>
                                <p>COD Available</p>
                            </div>
                        </div>
                    </div>
                    <div class="box border border-gray-200 mx-5 mt-10 p-5 text-sm">
                        <div class="que">
                            <strong>Have a question? We can help.</strong><br><br>
                            <p><?php echo $store_details['store_timing']; ?></p><br>

                            <p>Call or WhatsApp us :</p>
                            <strong>+91 <?php echo $store_details['store_phone']; ?></strong><br><br>

                            <p>Email us <?php echo $store_details['store_email']; ?> or chat/DM us on our Instagram.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-details mt-10 space-y-3">
                <p class="text-xl font-bold">Product Details</p>
                <table class="product-details-table">
                    <tbody>
                        <tr>
                            <th>Product Type</th>
                            <td><?php echo $products['product_type']; ?></td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <td><?php echo $products['color']; ?></td>
                        </tr>
                        <tr>
                            <th>Fabric</th>
                            <td><?php echo $products['fabric']; ?></td>
                        </tr>
                        <tr>
                            <th>Work</th>
                            <td><?php echo $products['work']; ?></td>
                        </tr>
                        <tr>
                            <th>Blouse Color</th>
                            <td><?php echo $products['blouse_color']; ?></td>
                        </tr>
                        <tr>
                            <th>Blouse Fabric</th>
                            <td><?php echo $products['blouse_fabric']; ?></td>
                        </tr>
                        <tr>
                            <th>Blouse Type</th>
                            <td><?php echo $products['blouse_type']; ?></td>
                        </tr>
                        <tr>
                            <th>Dupatta Color</th>
                            <td><?php echo $products['dupatta_color']; ?></td>
                        </tr>
                        <tr>
                            <th>Dupatta Fabric</th>
                            <td><?php echo $products['dupatta_fabric']; ?></td>
                        </tr>
                        <tr>
                            <th>Bottom Color</th>
                            <td><?php echo $products['bottom_color']; ?></td>
                        </tr>
                        <tr>
                            <th>Bottom Fabric</th>
                            <td><?php echo $products['bottom_fabric']; ?></td>
                        </tr>
                        <tr>
                            <th>Bottom Style</th>
                            <td><?php echo $products['bottom_style']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>

    </main>
    <footer class="mb-10 lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>

    <script>
        var slideIndex = 1;
        var autoScrollInterval;

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("thumbnail-img");
            var container = document.querySelector('.thumbnails-container');

            if (n > x.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = x.length;
            }

            // hide all
            for (i = 0; i < x.length; i++) {
                x[i].classList.remove("active");
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active-thumbnail");
            }

            // show current
            x[slideIndex - 1].classList.add("active");
            dots[slideIndex - 1].classList.add("active-thumbnail");

            // Scroll to active thumbnail
            var activeDot = dots[slideIndex - 1];
            if (activeDot) {
                container.scrollLeft = activeDot.offsetLeft - (container.offsetWidth / 2) + (activeDot.offsetWidth / 2);
            }
        }

        function currentDiv(n) {
            slideIndex = n;
            showDivs(slideIndex);
            clearInterval(autoScrollInterval);
            autoScrollInterval = setInterval(autoScroll, 3000); // reset timer
        }

        function scrollThumbs(direction) {
            var container = document.querySelector('.thumbnails-container');
            var scrollAmount = container.offsetWidth / 3;
            container.scrollLeft += direction * scrollAmount;
        }

        function autoScroll() {
            slideIndex++;
            if (slideIndex > document.getElementsByClassName("mySlides").length) {
                slideIndex = 1;
            }
            showDivs(slideIndex);
        }

        // Initial setup
        document.addEventListener('DOMContentLoaded', function() {
            showDivs(slideIndex);
            autoScrollInterval = setInterval(autoScroll, 3000);

            // Get all the radio buttons with the name "size"
            const sizeRadios = document.querySelectorAll('input[name="size"]');

            // Get the element where we'll display the selected size
            const sizeDisplay = document.getElementById('selected-size-display');

            // Add a 'change' event listener to each radio button
            sizeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    sizeDisplay.textContent = this.value;
                });
            });

            // Set the initial value on page load
            const checkedRadio = document.querySelector('input[name="size"]:checked');
            if (checkedRadio) {
                sizeDisplay.textContent = checkedRadio.value;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            showDivs(slideIndex);
            autoScrollInterval = setInterval(autoScroll, 3000);

            const sizeRadios = document.querySelectorAll('input[name="size"]');
            const sizeDisplay = document.getElementById('selected-size-display');
            const hiddenSizeInput = document.getElementById('selected_size_hidden');

            function updateSize() {
                const checkedRadio = document.querySelector('input[name="size"]:checked');
                if (checkedRadio) {
                    sizeDisplay.textContent = checkedRadio.value;
                    hiddenSizeInput.value = checkedRadio.value; // Update the hidden input
                }
            }

            sizeRadios.forEach(radio => {
                radio.addEventListener('change', updateSize);
            });

            // Set the initial value on page load
            updateSize();
        });
    </script>
</body>

</html>