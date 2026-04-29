<?php
error_reporting(0);

session_start();

include('./db_con.php');

// Check if the user is logged in to get the cart count
$cart_count = 0;
if (isset($_SESSION['session'])) {
    $sessionID = $_SESSION['session'];
    $user_query = mysqli_query($db, "SELECT user_id FROM users WHERE user_email ='$sessionID'");
    $fetch_user = mysqli_fetch_array($user_query);
    $user_id = $fetch_user['user_id'];

    // Get the total number of items in the cart for the user
    $count_query = "SELECT SUM(product_qty) AS total_items FROM cart WHERE user_id = '$user_id'";
    $count_result = mysqli_query($db, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $cart_count = $count_row['total_items'] ?? 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Asopalav.in</title>
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

        .custom-sidebar {
            z-index: 70;
        }

        @media (min-width: 1024px) {
            .custom-sidebar {
                display: none;
            }
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

        @media (max-width: 1023px) {
            ::-webkit-scrollbar {
                display: none;
            }
        }

        .header {
            box-shadow: 0px 1px 1px #e0e0e0;
        }

        .footer {
            box-shadow: 0px -1px 1px #e0e0e0;
            z-index: 1;
        }

        .active-link {
            color: #c28e5c !important;
        }

        .mobile-nav-link.active-link {
            background-color: #f0f0f0;
        }

        #liveSearchResults {
            position: absolute;
            width: 100%;
            background: white;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 0.5rem 0.5rem;
            display: none;
            z-index: 80;
        }

        #liveSearchResults li {
            padding: 0.5rem 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        #liveSearchResults li:hover {
            background-color: #f0f0f0;
        }

        #liveSearchResults span.highlight {
            background-color: #ffe58a;
        }
    </style>
</head>

<body class="font-poppins">
    <header class="header bg-white text-[#2e2e2e] sticky top-0">
        <div class="mx-auto px-8 py-4 flex items-center justify-between">
            <div class="hidden lg:flex flex-1">
                <nav class="flex space-x-6 text-sm font-medium">
                    <a href="home.php" class="text-[17px] hover:text-[#c28e5c] transition">Home</a>
                    <a href="shop.php" class="text-[17px] hover:text-[#c28e5c] transition">Shop</a>
                    <a href="store_locations.php" class="text-[17px] hover:text-[#c28e5c] transition">Stores</a>
                    <a href="about_us.php" class="text-[17px] hover:text-[#c28e5c] transition">About<span class="text-[#c28e5c] text-[5px]">_</span>Us</a>
                    <a href="contact_us.php" class="text-[17px] hover:text-[#c28e5c] transition">Contact<span class="text-[#c28e5c] text-[5px]">_</span>Us</a>
                </nav>
            </div>
            <div class="lg:hidden flex-1 flex items-center">
                <button id="hamburgerBtn" title="Menu" class="text-2xl text-[#2e2e2e] hover:text-[#c28e5c] transition duration-200 cursor-pointer">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <div class="flex-1 flex lg:justify-center justify-center">
                <a href="home.php">
                    <img src="./images/Asopalav Logo.avif" alt="Logo" class="h-10" />
                </a>
            </div>
            <div class="flex-1 flex justify-end items-center space-x-9 text-[20px] text-[#2e2e2e]">
                <?php if (!$_SESSION['session']) {
                ?>
                    <a href="login.php" title="Account" class="hover:text-[#c28e5c] transition duration-200 cursor-pointer hidden lg:inline-block">
                        <i class="fa-solid fa-user"></i>
                    </a>
                <?php
                } else {
                ?>
                    <a href="user_information.php" title="Account" class="hover:text-[#c28e5c] transition duration-200 cursor-pointer hidden lg:inline-block">
                        <i class="fa-solid fa-user-circle text-xl"></i>
                    </a>
                <?php
                } ?>

                <?php if (!$_SESSION['session']) {
                ?>
                    <a href="login.php" title="Cart" class="hover:text-[#c28e5c] transition duration-200 cursor-pointer hidden lg:inline-block">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                <?php
                } else {
                ?>
                    <a href="cart.php" title="Cart" class="relative hover:text-[#c28e5c] transition duration-200 cursor-pointer hidden lg:inline-block">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <sup class="absolute -top-1 -right-2 bg-[#c28e5c] text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center"><?php echo $cart_count; ?></sup>
                    </a>
                <?php
                } ?>

                <button id="searchBtn" title="Search" class="hover:text-[#c28e5c] transition duration-200 cursor-pointer">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <div id="sidebarOverlay" class="lg:hidden z-[80] fixed inset-0 bg-black/50 backdrop-blur-sm backdrop-blur-overlay">
                <div id="mobileSidebar" class="h-full w-80 bg-white shadow-lg custom-sidebar overflow-y-auto lg:overflow-hidden">
                    <div class="p-4 py-4.5 flex items-center justify-between">
                        <span class="text-2xl font-bold">Menu</span>
                        <button id="closeSidebarBtn" class="text-3xl text-gray-500 hover:text-[#c28e5c] transition duration-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <nav class="flex flex-col text-gray-800">
                        <a href="home.php" class="p-4 border-t border-gray-200 hover:bg-gray-100 transition">
                            <span class="text-[17px] w-full flex items-center justify-center hover:text-[#c28e5c] transition duration-200">
                                <p class="w-[20%] flex items-center justify-center"><i class="fa-solid fa-house"></i></p>
                                <p class="w-[80%]">Home</p>
                            </span>
                        </a>
                        <a href="shop.php" class="p-4 border-t border-gray-200 hover:bg-gray-100 transition">
                            <span class="text-[17px] w-full flex items-center justify-center hover:text-[#c28e5c] transition duration-200">
                                <p class="w-[20%] flex items-center justify-center"><i class="fa-solid fa-shop"></i></p>
                                <p class="w-[80%]">Shop</p>
                            </span>
                        </a>
                        <a href="store_locations.php" class="p-4 border-t border-gray-200 hover:bg-gray-100 transition">
                            <span class="text-[17px] w-full flex items-center justify-center hover:text-[#c28e5c] transition duration-200">
                                <p class="w-[20%] flex items-center justify-center"><i class="fa-solid fa-location-dot"></i></p>
                                <p class="w-[80%]">Stores</p>
                            </span>
                        </a>
                        <a href="about_us.php" class="p-4 border-t border-gray-200 hover:bg-gray-100 transition">
                            <span class="text-[17px] w-full flex items-center justify-center hover:text-[#c28e5c] transition duration-200">
                                <p class="w-[20%] flex items-center justify-center"><i class="fa-solid fa-building"></i></p>
                                <p class="w-[80%]">About Us</p>
                            </span>
                        </a>
                        <a href="contact_us.php" class="p-4 border-t border-gray-200 hover:bg-gray-100 transition">
                            <span class="text-[17px] w-full flex items-center justify-center hover:text-[#c28e5c] transition duration-200">
                                <p class="w-[20%] flex items-center justify-center"><i class="fa-solid fa-handshake"></i></p>
                                <p class="w-[80%]">Contact Us</p>
                            </span>
                        </a>
                        <?php if (!$_SESSION['session']) { ?>
                            <a href="login.php" class="p-4 border-t border-b border-gray-200 hover:bg-gray-100 transition">
                                <span class="text-[17px] w-full flex items-center justify-center hover:text-[#c28e5c] transition duration-200">
                                    <p class="w-[20%] flex items-center justify-center"><i class="fa-solid fa-user"></i></p>
                                    <p class="w-[80%]">Account</p>
                                </span>
                            </a>
                        <?php } else { ?>
                            <a href="user_information.php" class="p-4 border-t border-b border-gray-200 hover:bg-gray-100 transition">
                                <span class="text-[17px] w-full flex items-center justify-center hover:text-[#c28e5c] transition duration-200">
                                    <p class="w-[20%] flex items-center justify-center"><i class="fa-solid fa-user-circle text-xl"></i></p>
                                    <p class="w-[80%]">Account</p>
                                </span>
                            </a>
                        <?php } ?>
                    </nav>
                    <div class="mt-auto border-t border-gray-200">
                        <div class="py-3 text-center text-sm text-[#2e2e2e] bg-[#f9f6ee]">
                            © 2025 Asopalav. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer fixed bottom-0 left-0 w-full bg-[#f9f6ee] text-[#2e2e2e] z-60 lg:hidden py-1">
            <div class="flex justify-around items-center text-xs">
                <a href="home.php" class="flex flex-col items-center py-2 hover:text-[#c28e5c] transition duration-200 space-y-1">
                    <i class="fa-solid fa-house text-lg"></i>
                    <span>Home</span>
                </a>
                <a href="shop.php" class="flex flex-col items-center py-2 hover:text-[#c28e5c] transition duration-200 space-y-1">
                    <i class="fa-solid fa-shop text-lg"></i>
                    <span>Shop</span>
                </a>
                <a href="store_locations.php" class="flex flex-col items-center py-2 hover:text-[#c28e5c] transition duration-200 space-y-1">
                    <i class="fa-solid fa-location-dot text-lg"></i>
                    <span>Stores</span>
                </a>
                <?php if (!$_SESSION['session']) { ?>
                    <a href="login.php" class="flex flex-col items-center py-2 hover:text-[#c28e5c] transition duration-200 space-y-1">
                        <i class="fa-solid fa-user text-lg"></i>
                        <span>Account</span>
                    </a>
                <?php } else { ?>
                    <a href="user_information.php" class="flex flex-col items-center py-2 hover:text-[#c28e5c] transition duration-200 space-y-1">
                        <i class="fa-solid fa-user-circle text-xl"></i>
                        <span>Account</span>
                    </a>
                <?php } ?>
                <?php if (!$_SESSION['session']) {
                ?>
                    <a href="login.php" class="flex flex-col items-center py-2 hover:text-[#c28e5c] transition duration-200 space-y-1 relative">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        <?php if ($cart_count > 0) { ?>
                            <sup class="absolute -top-1 -right-2 bg-[#c28e5c] text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center"><?php echo $cart_count; ?></sup>
                        <?php } ?>
                        <span>Cart</span>
                    </a>
                <?php
                } else {
                ?>
                    <a href="cart.php" class="flex flex-col items-center py-2 hover:text-[#c28e5c] transition duration-200 space-y-1 relative">
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                        <?php if ($cart_count > 0) { ?>
                            <sup class="absolute -top-1 -right-2 bg-[#c28e5c] text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center"><?php echo $cart_count; ?></sup>
                        <?php } ?>
                        <span>Cart</span>
                    </a>
                <?php
                } ?>
            </div>
        </footer>
    </header>
    <div id="fullScreenSearchOverlay" class="fixed inset-0 bg-white/90 backdrop-blur-sm hidden z-100 transition-opacity duration-300 opacity-0">
        <div class="h-full flex flex-col items-center justify-start py-12 px-4">
            <button id="closeFullSearch" class="absolute top-4 right-4 text-3xl text-gray-500 hover:text-[#c28e5c] transition duration-200">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="w-full max-w-2xl mt-24 relative">
                <form id="fullScreenSearchForm" class="flex flex-col items-center">
                    <div class="relative w-full">
                        <input type="text" name="search" id="liveSearchInput" placeholder="Type to search..." class="w-full border-b border-[#c28e5c] px-4 py-3 text-2xl focus:outline-none text-center bg-transparent" autocomplete="off" required />
                        <button type="submit" class="absolute right-0 top-1/2 -translate-y-1/2 text-2xl text-[#c28e5c] hover:text-[#b17c4c] transition duration-200"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
                <ul id="liveSearchResults"></ul>
            </div>
        </div>
    </div>
    <script>
        const searchBtn = document.getElementById('searchBtn');
        const fullScreenSearchOverlay = document.getElementById('fullScreenSearchOverlay');
        const closeFullSearchBtn = document.getElementById('closeFullSearch');
        const liveInput = document.getElementById('liveSearchInput');
        const liveResults = document.getElementById('liveSearchResults');
        const fullScreenSearchForm = document.getElementById('fullScreenSearchForm');
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // ---------- Search Overlay Logic ----------
        function openFullSearch() {
            fullScreenSearchOverlay.classList.remove('hidden');
            setTimeout(() => {
                fullScreenSearchOverlay.classList.add('opacity-100');
                liveInput.focus();
            }, 10);
        }

        function closeFullSearch() {
            fullScreenSearchOverlay.classList.remove('opacity-100');
            setTimeout(() => fullScreenSearchOverlay.classList.add('hidden'), 300);
        }

        searchBtn.addEventListener('click', openFullSearch);
        closeFullSearchBtn.addEventListener('click', closeFullSearch);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (!fullScreenSearchOverlay.classList.contains('hidden')) closeFullSearch();
                if (mobileSidebar.classList.contains('open')) closeSidebar();
            }
        });

        // ---------- Live Search ----------
        liveInput.addEventListener('input', () => {
            const query = liveInput.value.trim();
            if (!query) {
                liveResults.innerHTML = '';
                liveResults.style.display = 'none';
                return;
            }

            fetch(`search_ajax.php?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (!Array.isArray(data)) {
                        console.error('Invalid data from server:', data);
                        liveResults.innerHTML = '<li>No products found</li>';
                        liveResults.style.display = 'block';
                        return;
                    }

                    if (data.length === 0) {
                        liveResults.innerHTML = '<li>No products found</li>';
                        liveResults.style.display = 'block';
                        return;
                    }

                    liveResults.innerHTML = data.map(item => {
                        const regex = new RegExp(`(${query})`, 'gi');
                        const highlighted = item.name.replace(regex, `<span class="highlight">$1</span>`);
                        return `<li onclick="window.location.href='shop_products.php?pro=${item.id}'" class="flex items-center gap-2 cursor-pointer">
                    <img src="./images/${item.image}" class="w-15 object-cover rounded"/>
                    <span>${highlighted} - ₹${Number(item.price).toLocaleString()}</span>
                </li>`;
                    }).join('');
                    liveResults.style.display = 'block';
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    liveResults.innerHTML = '<li>No products found</li>';
                    liveResults.style.display = 'block';
                });
        });


        // Hide suggestions if clicked outside
        document.addEventListener('click', e => {
            if (!liveInput.contains(e.target) && !liveResults.contains(e.target)) {
                liveResults.style.display = 'none';
            }
        });

        // Submit search
        fullScreenSearchForm.addEventListener('submit', e => {
            e.preventDefault();
            const query = liveInput.value.trim();
            if (query) {
                window.location.href = `shop.php?search=${encodeURIComponent(query)}`;
            }
        });

        // ---------- Sidebar Logic ----------
        function closeSidebar() {
            mobileSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('open');
        }

        hamburgerBtn.addEventListener('click', () => {
            mobileSidebar.classList.add('open');
            sidebarOverlay.classList.add('open');
        });
        closeSidebarBtn.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', (e) => {
            if (e.target === sidebarOverlay) closeSidebar();
        });

        // ---------- Active Link Highlight ----------
        function setActiveLink() {
            const currentPath = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('a[href]');
            const shopPages = ['shop.php', 'shop_category.php', 'shop_products.php'];
            const cartPages = ['cart.php'];
            const accountPages = ['login.php', 'register.php', 'user_information.php', 'change_password.php', 'forgot_password.php'];

            navLinks.forEach(link => {
                link.classList.remove('active-link', 'mobile-nav-link');
                const span = link.querySelector('span');
                if (span) span.classList.remove('active-link');
            });

            navLinks.forEach(link => {
                const linkPath = link.href.split('/').pop();

                if (shopPages.includes(currentPath) && linkPath === 'shop.php') {
                    link.classList.add('active-link');
                    if (link.closest('#mobileSidebar')) link.classList.add('mobile-nav-link');
                } else if (cartPages.includes(currentPath) && linkPath === 'cart.php') {
                    link.classList.add('active-link');
                    if (link.closest('#mobileSidebar')) link.classList.add('mobile-nav-link');
                } else if (currentPath === linkPath && !accountPages.includes(currentPath) && !cartPages.includes(currentPath)) {
                    if (link.closest('header nav') || link.closest('footer')) link.classList.add('active-link');
                    if (link.closest('#mobileSidebar')) link.classList.add('mobile-nav-link');
                }
            });

            if (accountPages.includes(currentPath)) {
                const isUserLoggedIn = <?php echo isset($_SESSION['session']) ? 'true' : 'false'; ?>;
                const targetAccountPath = isUserLoggedIn ? 'user_information.php' : 'login.php';

                const headerAccountLink = document.querySelector(`header a[href="${targetAccountPath}"]`);
                if (headerAccountLink) headerAccountLink.classList.add('active-link');

                const mobileSidebarAccountLink = document.querySelector(`#mobileSidebar a[href="${targetAccountPath}"]`);
                if (mobileSidebarAccountLink) mobileSidebarAccountLink.classList.add('mobile-nav-link');
                const span = mobileSidebarAccountLink?.querySelector('span');
                if (span) span.classList.add('active-link');

                const mobileFooterAccountLink = document.querySelector(`footer a[href="${targetAccountPath}"]:not([href="cart.php"])`);
                if (mobileFooterAccountLink) mobileFooterAccountLink.classList.add('active-link');
            }

            if (cartPages.includes(currentPath)) {
                const mobileFooterCartLink = document.querySelector('footer a[href="cart.php"]');
                if (mobileFooterCartLink) mobileFooterCartLink.classList.add('active-link');
            }
        }

        document.addEventListener('DOMContentLoaded', setActiveLink);
        window.addEventListener('popstate', setActiveLink);
    </script>

</body>

</html>