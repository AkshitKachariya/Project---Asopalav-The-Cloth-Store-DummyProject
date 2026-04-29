<?php
include('./db_con.php');

$products_query = mysqli_query($db, "SELECT * FROM products ORDER BY product_id DESC");
$count_products = mysqli_num_rows($products_query);

$current_category = 'All Products';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shop | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <style>
        .translate-x-full {
            transform: translateX(-100%);
        }

        .translate-x-0 {
            transform: translateX(0);
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
</head>

<body>
    <header class="sticky top-0 z-10">
        <?php include('./main_header.php'); ?>
    </header>
    <main class="py-15 lg:px-15 px-7 space-y-4">
        <div class="text-center text-3xl font-bold uppercase">Shop</div>

        <div class="flex flex-col lg:flex-row lg:gap-6">

            <div id="sidebar"
                class="fixed top-0 left-0 w-full h-full bg-opacity-50 z-50 transition-transform duration-300 transform -translate-x-full lg:static  lg:w-1/5 lg:translate-x-0 lg:h-auto lg:bg-transparent lg:z-auto"
                style="backdrop-filter: blur(10px);">
                <div
                    class="left w-3/4 md:w-1/2 sm:w-4/6 h-full bg-gray-50 border-r border-gray-50 rounded-r-lg shadow-xl lg:bg-gray-50 lg:border lg:rounded-lg lg:w-full lg:h-auto lg:shadow-sm sticky top-46 px-10 py-10 lg:px-0 lg:py-0">
                    <button id="closeSidebar" class="absolute top-4 right-4 text-gray-600 lg:hidden">
                        <i class="fa-solid fa-xmark text-2xl hover:text-[#c28e5c]"></i>
                    </button>

                    <div class="border-gray-200 lg:hidden border my-3"></div>
                    <div class="text-xl font-semibold text-gray-800 mb-4 lg:hidden">Filters</div>
                    <div class="border-gray-200 lg:hidden border my-3"></div>
                    <div class="text-[19px] font-semibold text-gray-800 mb-4">Categories</div>
                    <div class="space-y-2">
                        <?php
                        // All Products link (highlight if current)
                        $all_class = (strtolower(trim($current_category)) === 'all products')
                            ? 'bg-[#d5cfc1] text-white font-semibold'
                            : 'text-gray-700 hover:text-[#c28e5c] hover:bg-gray-100';
                        ?>
                        <a href="shop.php"
                            class="flex justify-between items-center px-2 py-1 rounded-md transition-colors duration-200 ease-in-out <?php echo $all_class; ?>">
                            <p class="left text-[16px]">All Products</p>
                            <p class="left text-[16px]">(<?php echo $count_products; ?>)</p>
                        </a>

                        <?php
                        $category_query = mysqli_query($db, "SELECT * FROM category");
                        while ($category = mysqli_fetch_array($category_query)) {
                            $cat = $category['category_name'];
                            $counts_query = mysqli_query($db, "SELECT * FROM products WHERE category='" . mysqli_real_escape_string($db, $cat) . "'");
                            $counts = mysqli_num_rows($counts_query);

                            // compare case-insensitive
                            $is_active = (strtolower(trim($current_category)) === strtolower(trim($cat)));
                            $cat_class = $is_active ? 'bg-[#c28e5c] text-white font-semibold' : 'text-gray-700 hover:text-[#c28e5c] hover:bg-gray-100';
                        ?>
                            <a href="shop_category.php?cat=<?php echo urlencode($cat); ?>"
                                class="flex justify-between items-center px-2 py-1 rounded-md transition-colors duration-200 ease-in-out <?php echo $cat_class; ?>">
                                <div class="left text-[16px]"><?php echo $cat; ?></div>
                                <div class="right text-[16px]">(<?php echo $counts; ?>)</div>
                            </a>
                        <?php } ?>

                    </div>
                </div>
            </div>

            <div class="border-gray-200 border my-4  lg:mx-[-60px] lg:block hidden"></div>

            <div class="right_content w-full lg:flex-1 p-1 md:px-6">
                <div class="flex items-center justify-between">
                    <div class="text-xl font-bold text-gray-800">
                        All Products (<?php echo $count_products; ?>)
                    </div>
                    <div class="lg:hidden">
                        <button id="toggleSidebar"
                            class="flex items-center gap-2 p-1 bg-[#c28e5c] text-white rounded-lg hover:bg-[#a5784f] transition-colors duration-200">
                            <i class="fas fa-filter w-5 h-5"></i>
                            Filter
                        </button>
                    </div>
                </div>
                <div class="border-gray-200 border my-4"></div>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                    <?php
                    while ($products = mysqli_fetch_array($products_query)) {
                    ?>
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-500 border border-gray-200 group  cursor-pointer">
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
                                        <p class="price font-bold text-md text-[#c28e5c]">
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
    </main>
    <footer class="mb-10 lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const toggleSidebarBtn = document.getElementById('toggleSidebar');
            const closeSidebarBtn = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');

            if (toggleSidebarBtn) {
                toggleSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                });
            }

            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                });
            }

            if (sidebar) {
                sidebar.addEventListener('click', (e) => {
                    if (e.target === sidebar) {
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('translate-x-0');
                    }
                });
            }
        });
    </script>
</body>

</html>