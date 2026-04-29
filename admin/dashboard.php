<?php
include('check_session.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
</head>

<body class="font-poppins">

    <?php include('./admin_parts/./header.php'); ?>
    <?php include('./admin_parts/./sidebar.php'); ?>

    <main class="flex-1 p-4 sm:p-6 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">

        <h2 class="text-2xl sm:text-3xl font-semibold text-[#512DA8] mb-6">Dashboard</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">

            <!-- Home Images -->
            <a href="home_image.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Home Images</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_home_image; ?></p>
                    </div>
                    <i class="fa-solid fa-image text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Categories -->
            <a href="categories.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Categories</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_category; ?></p>
                    </div>
                    <i class="fa-solid fa-list text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Sizes -->
            <a href="sizes.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Sizes</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_sizes; ?></p>
                    </div>
                    <i class="fa-solid fa-ruler-horizontal text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Products -->
            <a href="products.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Products</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_products; ?></p>
                    </div>
                    <i class="fa-solid fa-box-open text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Users -->
            <a href="user_details.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Users</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_users; ?></p>
                    </div>
                    <i class="fa-solid fa-user text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- User Messages -->
            <a href="user_messages.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">User Messages</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_user_messages; ?></p>
                    </div>
                    <i class="fa-solid fa-envelope text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Subscribers -->
            <a href="subscribers.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Subscribers</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_subscribers; ?></p>
                    </div>
                    <i class="fa-solid fa-rss text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Store Locations -->
            <a href="store_locations.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Store Locations</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_store_location; ?></p>
                    </div>
                    <i class="fa-solid fa-location-dot text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Store Details -->
            <a href="store_details.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Store Details</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_store_details; ?></p>
                    </div>
                    <i class="fa-solid fa-info text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Social Branding -->
            <a href="social_brandings.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Social Branding</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_socials; ?></p>
                    </div>
                    <i class="fa-solid fa-bullhorn text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Orders -->
            <a href="orders.php" class="group">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 flex items-center justify-between hover:bg-gradient-to-br hover:from-purple-50 hover:to-purple-100 transition-all duration-300 transform group-hover:-translate-y-1 group-hover:shadow-xl">
                    <div>
                        <p class="text-gray-500 text-sm sm:text-base font-medium">Orders</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#512DA8]"><?php echo $count_orders; ?></p>
                    </div>
                    <i class="fa-solid fa-cart-shopping text-3xl sm:text-4xl text-purple-400 group-hover:text-purple-500 group-hover:scale-110 transition-transform duration-300"></i>
                </div>
            </a>
        </div>
    </main>

    <?php include('./admin_parts/./footer.php'); ?>

    </script>
</body>

</html>