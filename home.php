<?php

session_start();
include('./db_con.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <style>
        .custom-sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
            z-index: 90;
        }

        .custom-sidebar.open {
            transform: translateX(0);
        }

        .backdrop-blur-overlay {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.3s linear;
        }

        .backdrop-blur-overlay.open {
            visibility: visible;
            opacity: 1;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f0f0f0;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #6b7280;
            border-radius: 10px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #4b5563;
        }

        .header {
            box-shadow: 0px 1px 2px #C0C0C0;
        }

        .footer {
            box-shadow: 0px -1px 2px #C0C0C0;
            z-index: 1;
        }

        .slideshow-container {
            position: relative;
            width: 100%;
            margin: auto;
        }

        .mySlides {
            display: none;
            width: 100%;
            box-sizing: border-box;
            height: 100%;
        }

        .mySlides.fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        .dot-container {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            width: 100%;
        }

        .dot {
            cursor: pointer;
            height: 5px;
            width: 5px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active_dot,
        .dot:hover {
            background-color: #c28e5c;
        }

        @keyframes fade {
            from {
                opacity: .4;
            }

            to {
                opacity: 1;
            }
        }

        .category-name-overlay {
            opacity: 1;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.0);
            color: white;
            font-size: 1.2em;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            box-sizing: border-box;
            transition: opacity 0.3s ease-in-out;
        }

        .category-card a:hover .category-name-overlay {
            opacity: 1;
        }

        .category-card a:hover img {
            transform: scale(1.02);
            transition: transform 0.3s ease-in-out;
        }

        .category-card a:hover .category-name-overlay p {
            color: #c28e5c;
        }

        .category-name-overlay p {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .category-card {
            flex-shrink: 0;
            width: 50%;
            padding: 1rem;
        }

        .category-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .category-slider-container {
            overflow: hidden;
            /* Hide extra width */
            position: relative;
        }

        #categorySlider {
            display: flex;
            flex-wrap: nowrap;
            /* Prevent wrapping */
            white-space: nowrap;
            /* Ensure single row */
            scrollbar-width: none;
            /* Hide scrollbar (Firefox) */
            -ms-overflow-style: none;
            /* Hide scrollbar (IE/Edge) */
        }

        #categorySlider::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar (Chrome, Safari) */
        }

        .category-card {
            flex: 0 0 auto;
            /* Prevent shrinking */
        }

        @media (min-width: 768px) {
            .category-card {
                width: 33.333%;
            }
        }

        .storeshadow {
            box-shadow: 0px 1px 5px grey;
        }

        .store-card .store-link:hover {
            transform: translateY(-5px);
        }

        .location-name-container {
            position: relative;
            display: inline-block;
            transition: color 0.3s ease-in-out;
        }

        .location-name-container::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -5px;
            width: 0;
            height: 2px;
            background-color: currentColor;
            transition: width 0.3s ease-in-out, left 0.3s ease-in-out;
            transform: translateX(-50%);
        }

        .store-card:hover .location-name-container::after {
            width: 100%;
        }

        .store-card {
            flex-shrink: 0;
            width: 50%;
            padding: 1rem;
        }

        .store-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        @media (min-width: 768px) {
            .store-card {
                width: 33.333%;
            }
        }

        @media (min-width: 1024px) {
            .store-card {
                width: 20%;
            }

            .store-card img {
                height: 250px;
            }
        }

        .title {
            display: flex;
            align-items: center;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .title::before,
        .title::after {
            content: '';
            flex: 1;
            height: 2px;
            background-color: #000;
            margin: 0 1rem;
        }
    </style>
</head>

<body>
    <header class="sticky top-0 z-10">
        <?php include('./main_header.php'); ?>
    </header>
    <main>
        <div class="main_image">
            <div class="slideshow-container h-full">
                <?php
                $home_image_data = mysqli_query($db, "select * from home_image");
                $slides = [];
                while ($row = mysqli_fetch_array($home_image_data)) {
                    $slides[] = $row;
                }
                foreach ($slides as $slide_data) {
                ?>
                    <div class="mySlides fade flex flex-col lg:flex-row w-full">
                        <!-- Left Image -->
                        <div class="left_home_image h-auto lg:h-full w-full lg:w-[58%] flex justify-center items-center bg-white">
                            <img src="./images/<?php echo $slide_data['image_image']; ?>"
                                alt=""
                                class="w-full h-auto object-contain">
                        </div>

                        <!-- Right Text -->
                        <div class="right_home_image w-full lg:w-[42%] p-4 flex flex-col justify-center items-center text-center">
                            <p class="text-[28px] sm:text-[35px] lg:text-[45px] font-medium font-gfs-didot transform scale-y-110 leading-snug">
                                <?php echo $slide_data['image_heading']; ?>
                            </p>
                            <p class="text-[18px] sm:text-[25px] lg:text-[20px] font-medium font-gfs-didot text-slate-800 mt-2">
                                <?php echo $slide_data['image_text']; ?>
                            </p>
                            <a href="shop.php" class="mt-4">
                                <button class="border border-black bg-black text-[#f9f6ee] py-2 px-6 cursor-pointer">
                                    Shop Now
                                </button>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- Dots -->
                <div class="dot-container mt-4 hidden lg:block">
                    <?php
                    for ($i = 0; $i < count($slides); $i++) {
                    ?>
                        <span class="dot" onclick="currentSlide(<?php echo $i + 1; ?>)"></span>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <br><br>

        <div class="category-slider-container relative overflow-hidden w-[85%] m-auto">
            <div class="category-slider flex transition-transform duration-500 ease-in-out" id="categorySlider">
                <?php
                $category_data = mysqli_query($db, "SELECT * FROM category");
                while ($category = mysqli_fetch_array($category_data)) {
                ?>
                    <div class="category-card flex-shrink-0 p-4">
                        <a href="shop_category.php?cat=<?php echo $category['category_name']; ?>"
                            class="relative block rounded-lg overflow-hidden group categoryshadow">

                            <img src="./images/<?php echo $category['category_image']; ?>"
                                alt="<?php echo $category['category_name']; ?>"
                                class="w-full h-auto object-cover transition-transform duration-300 group-hover:scale-105">

                            <div class="category-name-overlay absolute inset-0 flex items-center justify-center 
                                bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-white text-xl font-bold">
                                    <?php echo $category['category_name']; ?>
                                </p>
                            </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>

            <!-- Previous Button -->
            <button onclick="prevCategorySlide()"
                class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-white text-gray-800 p-2 
                   rounded-full shadow-md border border-gray-300 z-10 transition-transform duration-200 hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="lg:h-6 lg:w-6 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Next Button -->
            <button onclick="nextCategorySlide()"
                class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-white text-gray-800 p-2 
                   rounded-full shadow-md border border-gray-300 z-10 transition-transform duration-200 hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="lg:h-6 lg:w-6 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>


        <div class="mt-10">
            <div class="items p-1 px-7.5 md:px-10">
                <div class="title">Sarees</div>
                <?php
                $sql = mysqli_query($db, "select * from products where category = 'Saree' order by product_id desc limit 4");
                ?>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
                    <?php
                    while ($products = mysqli_fetch_array($sql)) {
                    ?>
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-500 border border-gray-300 group  cursor-pointer">
                            <a href="shop_products.php?pro=<?php echo $products['product_id']; ?>" class="block">

                                <div class="product-image-container relative w-full overflow-hidden">
                                    <!-- Image1 -->
                                    <img src="./images/<?php echo $products['image1']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0 absolute top-0 left-0">

                                    <!-- Image2 -->
                                    <img src="./images/<?php echo $products['image2']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 relative">

                                    <!-- Hover Button -->
                                    <div
                                        class="absolute inset-0 flex items-end justify-center p-3 opacity-0 group-hover:opacity-100 transition duration-500 ease-in-out w-full">
                                        <button
                                            class="w-full py-2 bg-white text-[#c28e5c] font-semibold rounded-lg shadow-md transform translate-y-4 group-hover:translate-y-0 transition duration-500 ease-in-out border-2 border-[#c28e5c] cursor-pointer">
                                            <i class="far fa-eye"></i> View Product
                                        </button>
                                    </div>

                                </div>

                                <div class="p-4 md:p-5">
                                    <div class="space-y-2">
                                        <p class="name font-semibold text-md text-gray-900 line-clamp-2">
                                            <?php echo $products['name']; ?>
                                        </p>
                                        <p class="price text-start lg:text-center font-bold text-md text-[#c28e5c]">
                                            ₹<?php echo number_format($products['price']); ?>/-
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="mt-7">
            <div class="items p-1 px-7.5 md:px-10">
                <div class="title">Salwar Suits</div>
                <?php
                $sql = mysqli_query($db, "select * from products where category = 'Salwar Suit' order by product_id desc limit 4");
                ?>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
                    <?php
                    while ($products = mysqli_fetch_array($sql)) {
                    ?>
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-500 border border-gray-300 group  cursor-pointer">
                            <a href="shop_products.php?pro=<?php echo $products['product_id']; ?>" class="block">

                                <div class="product-image-container relative w-full overflow-hidden">
                                    <!-- Image1 -->
                                    <img src="./images/<?php echo $products['image1']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0 absolute top-0 left-0">

                                    <!-- Image2 -->
                                    <img src="./images/<?php echo $products['image2']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 relative">

                                    <!-- Hover Button -->
                                    <div
                                        class="absolute inset-0 flex items-end justify-center p-3 opacity-0 group-hover:opacity-100 transition duration-500 ease-in-out w-full">
                                        <button
                                            class="w-full py-2 bg-white text-[#c28e5c] font-semibold rounded-lg shadow-md transform translate-y-4 group-hover:translate-y-0 transition duration-500 ease-in-out border-2 border-[#c28e5c] cursor-pointer">
                                            <i class="far fa-eye"></i> View Product
                                        </button>
                                    </div>

                                </div>

                                <div class="p-4 md:p-5">
                                    <div class="space-y-2">
                                        <p class="name font-semibold text-md text-gray-900 line-clamp-2">
                                            <?php echo $products['name']; ?>
                                        </p>
                                        <p class="price text-start lg:text-center font-bold text-md text-[#c28e5c]">
                                            ₹<?php echo number_format($products['price']); ?>/-
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="mt-7">
            <div class="items p-1 px-7.5 md:px-10">
                <div class="title">LEHENGAS</div>
                <?php
                $sql = mysqli_query($db, "select * from products where category = 'Lehenga Choli' order by product_id desc limit 4");
                ?>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
                    <?php
                    while ($products = mysqli_fetch_array($sql)) {
                    ?>
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-500 border border-gray-300 group  cursor-pointer">
                            <a href="shop_products.php?pro=<?php echo $products['product_id']; ?>" class="block">

                                <div class="product-image-container relative w-full overflow-hidden">
                                    <!-- Image1 -->
                                    <img src="./images/<?php echo $products['image1']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0 absolute top-0 left-0">

                                    <!-- Image2 -->
                                    <img src="./images/<?php echo $products['image2']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 relative">

                                    <!-- Hover Button -->
                                    <div
                                        class="absolute inset-0 flex items-end justify-center p-3 opacity-0 group-hover:opacity-100 transition duration-500 ease-in-out w-full">
                                        <button
                                            class="w-full py-2 bg-white text-[#c28e5c] font-semibold rounded-lg shadow-md transform translate-y-4 group-hover:translate-y-0 transition duration-500 ease-in-out border-2 border-[#c28e5c] cursor-pointer">
                                            <i class="far fa-eye"></i> View Product
                                        </button>
                                    </div>

                                </div>

                                <div class="p-4 md:p-5">
                                    <div class="space-y-2">
                                        <p class="name font-semibold text-md text-gray-900 line-clamp-2">
                                            <?php echo $products['name']; ?>
                                        </p>
                                        <p class="price text-start lg:text-center font-bold text-md text-[#c28e5c]">
                                            ₹<?php echo number_format($products['price']); ?>/-
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="mt-7">
            <div class="items p-1 px-7.5 md:px-10">
                <div class="title">Kurti's</div>
                <?php
                $sql = mysqli_query($db, "select * from products where category = 'Kurti' order by product_id desc limit 4");
                ?>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
                    <?php
                    while ($products = mysqli_fetch_array($sql)) {
                    ?>
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-500 border border-gray-300 group  cursor-pointer">
                            <a href="shop_products.php?pro=<?php echo $products['product_id']; ?>" class="block">

                                <div class="product-image-container relative w-full overflow-hidden">
                                    <!-- Image1 -->
                                    <img src="./images/<?php echo $products['image1']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0 absolute top-0 left-0">

                                    <!-- Image2 -->
                                    <img src="./images/<?php echo $products['image2']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 relative">

                                    <!-- Hover Button -->
                                    <div
                                        class="absolute inset-0 flex items-end justify-center p-3 opacity-0 group-hover:opacity-100 transition duration-500 ease-in-out w-full">
                                        <button
                                            class="w-full py-2 bg-white text-[#c28e5c] font-semibold rounded-lg shadow-md transform translate-y-4 group-hover:translate-y-0 transition duration-500 ease-in-out border-2 border-[#c28e5c] cursor-pointer">
                                            <i class="far fa-eye"></i> View Product
                                        </button>
                                    </div>

                                </div>

                                <div class="p-4 md:p-5">
                                    <div class="space-y-2">
                                        <p class="name font-semibold text-md text-gray-900 line-clamp-2">
                                            <?php echo $products['name']; ?>
                                        </p>
                                        <p class="price text-start lg:text-center font-bold text-md text-[#c28e5c]">
                                            ₹<?php echo number_format($products['price']); ?>/-
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="mt-7">
            <div class="items p-1 px-7.5 md:px-10">
                <div class="title">Men's Wear</div>
                <?php
                $sql = mysqli_query($db, "select * from products where category = 'Men' order by product_id desc limit 4");
                ?>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 md:gap-6">
                    <?php
                    while ($products = mysqli_fetch_array($sql)) {
                    ?>
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-500 border border-gray-300 group  cursor-pointer">
                            <a href="shop_products.php?pro=<?php echo $products['product_id']; ?>" class="block">

                                <div class="product-image-container relative w-full overflow-hidden">
                                    <!-- Image1 -->
                                    <img src="./images/<?php echo $products['image1']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0 absolute top-0 left-0">

                                    <!-- Image2 -->
                                    <img src="./images/<?php echo $products['image2']; ?>"
                                        alt="<?php echo $products['name']; ?>"
                                        class="w-full h-auto object-cover transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 relative">

                                    <!-- Hover Button -->
                                    <div
                                        class="absolute inset-0 flex items-end justify-center p-3 opacity-0 group-hover:opacity-100 transition duration-500 ease-in-out w-full">
                                        <button
                                            class="w-full py-2 bg-white text-[#c28e5c] font-semibold rounded-lg shadow-md transform translate-y-4 group-hover:translate-y-0 transition duration-500 ease-in-out border-2 border-[#c28e5c] cursor-pointer">
                                            <i class="far fa-eye"></i> View Product
                                        </button>
                                    </div>

                                </div>

                                <div class="p-4 md:p-5">
                                    <div class="space-y-2">
                                        <p class="name font-semibold text-md text-gray-900 line-clamp-2">
                                            <?php echo $products['name']; ?>
                                        </p>
                                        <p class="price text-start lg:text-center font-bold text-md text-[#c28e5c]">
                                            ₹<?php echo number_format($products['price']); ?>/-
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="stores my-4 relative overflow-hidden w-[95%] m-auto mt-15">
            <p class="text-center text-xl font-bold uppercase">Our Stores</p>
            <div class="store-slider flex transition-transform duration-500 ease-in-out" id="storeSlider">
                <?php
                $stores_data = mysqli_query($db, "select * from store_location");
                while ($stores = mysqli_fetch_array($stores_data)) {
                ?>
                    <div class="store-card flex-shrink-0 w-1/5 p-3">
                        <div class="h-[100%] block rounded-lg overflow-hidden storeshadow transition-transform duration-300 store-link">
                            <a href="#" onclick="openMap('<?php echo $stores['location_link']; ?>'); return false;" class="block h-full">
                                <img src="./images/<?php echo $stores['location_image']; ?>" alt="<?php echo $stores['location_name']; ?>" class="w-full h-48 object-cover">
                                <div class="p-4 text-center">
                                    <p class="text-sm font-bold location-name-container"><?php echo $stores['location_name']; ?></p>
                                    <p class="text-sm text-gray-500 mt-1"><?php echo $stores['location_address']; ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <button onclick="prevStoreSlide()" class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-white text-gray-800 p-2 rounded-full shadow-md border border-gray-300 z-1 transition-transform duration-200 hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-6 lg:w-6 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button onclick="nextStoreSlide()" class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-white text-gray-800 p-2 rounded-full shadow-md border border-gray-300 z-1 transition-transform duration-200 hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="lg:h-6 lg:w-6 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <br>

    </main>

    <footer class="mb-10 lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>

    <script>
        // Main Slideshow Scripts
        let slideIndex = 1;
        showSlides(slideIndex);
        let slideInterval = setInterval(function() {
            plusSlides(1);
        }, 2000);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            clearInterval(slideInterval);
            slideInterval = setInterval(function() {
                plusSlides(1);
            }, 2000);
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active_dot", "");
            }
            slides[slideIndex - 1].style.display = "flex";
            dots[slideIndex - 1].className += " active_dot";
        }

        // Category Slider Scripts
        const categorySlider = document.getElementById('categorySlider');
        const categoryCards = categorySlider.querySelectorAll('.category-card');
        const totalCategories = categoryCards.length;

        let currentCategoryIndex = 0;

        function getCardsToShow() {
            if (window.innerWidth >= 1024) {
                return 3;
            } else if (window.innerWidth >= 768) {
                return 3;
            } else {
                return 2;
            }
        }

        function showCategorySlide(index) {
            const cardsToShow = getCardsToShow();
            const maxIndex = totalCategories - cardsToShow;

            if (index > maxIndex) {
                index = 0;
            } else if (index < 0) {
                index = maxIndex;
            }

            currentCategoryIndex = index;
            const offset = -currentCategoryIndex * (100 / cardsToShow);
            categorySlider.style.transform = `translateX(${offset}%)`;
        }

        function nextCategorySlide() {
            showCategorySlide(currentCategoryIndex + 1);
        }

        function prevCategorySlide() {
            showCategorySlide(currentCategoryIndex - 1);
        }

        window.addEventListener('resize', () => {
            showCategorySlide(0);
        });

        let categorySliderInterval = setInterval(nextCategorySlide, 2000);

        categorySlider.parentElement.addEventListener('mouseenter', () => {
            clearInterval(categorySliderInterval);
        });

        categorySlider.parentElement.addEventListener('mouseleave', () => {
            categorySliderInterval = setInterval(nextCategorySlide, 2000);
        });

        showCategorySlide(0);

        // Store Slider Scripts
        const storeSlider = document.getElementById('storeSlider');
        const storeCards = storeSlider.querySelectorAll('.store-card');
        const totalStores = storeCards.length;

        let currentStoreIndex = 0;

        function getStoresToShow() {
            if (window.innerWidth >= 1024) {
                return 5;
            } else if (window.innerWidth >= 768) {
                return 3;
            } else {
                return 2;
            }
        }

        function showStoreSlide(index) {
            const storesToShow = getStoresToShow();
            const maxIndex = totalStores - storesToShow;

            if (index > maxIndex) {
                index = 0;
            } else if (index < 0) {
                index = maxIndex;
            }

            currentStoreIndex = index;
            const offset = -currentStoreIndex * (100 / storesToShow);
            storeSlider.style.transform = `translateX(${offset}%)`;
        }

        function nextStoreSlide() {
            showStoreSlide(currentStoreIndex + 1);
        }

        function prevStoreSlide() {
            showStoreSlide(currentStoreIndex - 1);
        }

        window.addEventListener('resize', () => {
            showStoreSlide(0);
        });

        let storeSliderInterval = setInterval(nextStoreSlide, 2500);

        storeSlider.parentElement.addEventListener('mouseenter', () => {
            clearInterval(storeSliderInterval);
        });

        storeSlider.parentElement.addEventListener('mouseleave', () => {
            storeSliderInterval = setInterval(nextStoreSlide, 2500);
        });

        showStoreSlide(0);

        // Store Map Popup
        function openMap(link) {
            window.open(link, '_blank');
        }
    </script>

</body>

</html>