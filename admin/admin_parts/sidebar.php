<aside id="sidebar" class="w-[13rem] bg-[#decff8] text-[#512DA8] p-3 flex flex-col justify-between overflow-y-auto sidebar-divider-shadow hide-scrollbar text-[15px] transition-transform duration-300 z-40">
    <nav class="space-y-2">

        <!-- Dashboard -->
        <a href="dashboard.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
            <div class="flex items-center space-x-2">
                <div class="w-5 flex items-center justify-center">
                    <i class="fa-solid fa-gauge"></i>
                </div>
                <span class="truncate">Dashboard</span>
            </div>
        </a>

        <!-- Home Image -->
        <a href="home_image.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
            <div class="flex items-center space-x-2">
                <div class="w-5 flex items-center justify-center">
                    <i class="fa-solid fa-image"></i>
                </div>
                <span class="truncate">Home Image</span>
            </div>
            <span>(<?php echo $count_home_image; ?>)</span>
        </a>

        <!-- Shop Management Dropdown -->
        <div class="dropdown">
            <button class="flex justify-between items-center w-full py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition">
                <div class="flex items-center space-x-2 truncate">
                    <i class="fa-solid fa-shop"></i>
                    <span class="truncate">Shop Management</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="dropdown-content ml-4 mt-1 space-y-1">
                <a href="categories.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
                    <div class="flex items-center space-x-2 truncate">
                        <div class="w-5 flex items-center justify-center">
                            <i class="fa-solid fa-list"></i>
                        </div>
                        <span class="truncate">Categories</span>
                    </div>
                    <span>(<?php echo $count_category; ?>)</span>
                </a>
                <a href="sizes.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
                    <div class="flex items-center space-x-2 truncate">
                        <div class="w-5 flex items-center justify-center">
                            <i class="fa-solid fa-ruler-horizontal"></i>
                        </div>
                        <span class="truncate">Sizes</span>
                    </div>
                    <span>(<?php echo $count_sizes; ?>)</span>
                </a>
                <a href="products.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
                    <div class="flex items-center space-x-2 truncate">
                        <div class="w-5 flex items-center justify-center">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <span class="truncate">Products</span>
                    </div>
                    <span>(<?php echo $count_products; ?>)</span>
                </a>
            </div>
        </div>

        <!-- Details & Management Dropdown -->
        <div class="dropdown">
            <button class="flex justify-between items-center w-full py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition">
                <div class="flex items-center space-x-2 truncate">
                    <i class="fa-solid fa-users-gear"></i>
                    <span class="truncate">Details & Management</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="dropdown-content ml-4 mt-1 space-y-1">
                <a href="user_details.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
                    <div class="flex items-center space-x-2 truncate">
                        <div class="w-5 flex items-center justify-center">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span class="truncate">User Details</span>
                    </div>
                    <span>(<?php echo $count_users; ?>)</span>
                </a>
                <a href="user_messages.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
                    <div class="flex items-center space-x-2 truncate">
                        <div class="w-5 flex items-center justify-center">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <span class="truncate">User Msgs</span>
                    </div>
                    <span>(<?php echo $count_user_messages; ?>)</span>
                </a>
                <a href="subscribers.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
                    <div class="flex items-center space-x-2 truncate">
                        <div class="w-5 flex items-center justify-center">
                            <i class="fa-solid fa-rss"></i>
                        </div>
                        <span class="truncate">Subscribers</span>
                    </div>
                    <span>(<?php echo $count_subscribers; ?>)</span>
                </a>
            </div>
        </div>

        <!-- Other Links -->
        <a href="store_locations.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
            <div class="flex items-center space-x-2 truncate">
                <div class="w-5 flex items-center justify-center">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <span class="truncate">Store Locations</span>
            </div>
            <span>(<?php echo $count_store_location; ?>)</span>
        </a>

        <a href="store_details.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
            <div class="flex items-center space-x-2 truncate">
                <div class="w-5 flex items-center justify-center">
                    <i class="fa-solid fa-info"></i>
                </div>
                <span class="truncate">Store Details</span>
            </div>
            <span>(<?php echo $count_store_details; ?>)</span>
        </a>

        <a href="social_brandings.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
            <div class="flex items-center space-x-2 truncate">
                <div class="w-5 flex items-center justify-center">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <span class="truncate">Social Branding</span>
            </div>
            <span>(<?php echo $count_socials; ?>)</span>
        </a>

        <a href="orders.php" class="flex justify-between py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center">
            <div class="flex items-center space-x-2 truncate">
                <div class="w-5 flex items-center justify-center">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <span class="truncate">Orders</span>
            </div>
            <span>(<?php echo $count_orders; ?>)</span>
        </a>

        <div class="border-t border-[#512DA8] mt-2 mb-3 opacity-40"></div>

        <!-- Change Password -->
        <a href="change_password.php">
            <button class="w-full cursor-pointer bg-[#683ab7ce] hover:bg-[#5E35B1] text-white py-2 px-4 rounded-md transition flex items-center space-x-2 text-left">
                <i class="fa-solid fa-key"></i>
                <span class="truncate">Change Password</span>
            </button>
        </a>

        <!-- Logout -->
        <a href="admin_logout.php">
            <button class="w-full cursor-pointer bg-[#ad1414dc] hover:bg-[#880e18ee] text-white py-2 px-4 rounded-md transition flex items-center space-x-2 text-left mt-2">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span class="truncate">Logout</span>
            </button>
        </a>

    </nav>
</aside>