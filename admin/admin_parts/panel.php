<?php
include('../db_con.php');
session_start();
$admin = "select * from admins";
$fetch_admin = mysqli_query($db, $admin);
$admin_details = mysqli_fetch_array($fetch_admin);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>
    <link rel="shortcut icon" href="../images/./asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-x: hidden;
        }

        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-divider-shadow {
            position: relative;
            box-shadow: inset -1px 0 0 #c3b7de;
        }

        .sidebar-divider-shadow::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, rgb(237, 231, 246), rgb(237, 231, 246), transparent);
            z-index: 5;
        }

        .dropdown-content {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.3s ease, opacity 0.3s ease;
        }

        .dropdown-content.open {
            max-height: 500px;
            opacity: 1;
        }

        .active-link {
            background-color: #683ab7ce;
            color: #FFFFFF;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .active-link i {
            color: #FFFFFF;
        }

        aside a .flex-1,
        .dropdown button span span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 1023px) {
            #sidebar {
                position: fixed;
                top: 4rem;
                left: 0;
                height: calc(100vh - 4rem);
                width: 13rem;
                transform: translateX(-100%);
                transition: transform 0.3s ease, width 0.3s ease;
                z-index: 40;
                background-color: #decff8;
            }

            #sidebar.open-sidebar {
                transform: translateX(0);
                width: 17rem;
            }

            main {
                margin-left: 0;
                width: 100%;
                transition: margin-left 0.3s ease;
            }

            body.sidebar-open-overlay::after {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 30;
            }
        }

        @media (min-width: 1024px) {
            #sidebar {
                position: sticky;
                top: 4rem;
                width: 14rem;
                transform: translateX(0);
                left: 0;
                flex-shrink: 0;
            }

            main {
                /* Removed manual margin-left */
                transition: margin-left 0.3s ease;
            }

            body.sidebar-closed-desktop #sidebar {
                transform: translateX(-100%);
            }
        }

        body.sidebar-closed-desktop #sidebar {
            transform: translateX(-100%);
        }

        #toggleIcon {
            transition: transform 0.3s ease;
        }
    </style>

</head>

<body class="font-poppins flex flex-col h-screen overflow-hidden m-0">
    <header class="bg-[#decff8] text-[#512DA8] p-3 flex justify-between items-center sticky top-0 z-50 shadow-md h-16 w-full">
        <!-- LEFT SIDE -->
        <div class="flex items-center space-x-0">
            <!-- Desktop Sidebar Imitation Logo -->
            <div class="hidden lg:flex items-center justify-center bg-[#decff8] w-[14.5rem] h-16 px-4">
                <img src="../images/./Asopalav Logo.avif" alt="Logo" class="h-10">
            </div>

            <!-- Mobile Toggle + Logo -->
            <div class="flex lg:hidden items-center w-[14.5rem] px-2 space-x-5">
                <button id="sidebarToggle" class="lg:hidden focus:outline-none bg-[#7E57C2] hover:bg-[#6b38b3ea] text-white p-2 rounded-md shadow-md transition-all duration-200 flex items-center cursor-pointer w-[35px] justify-center">
                    <i id="toggleIcon" class="fa-solid fa-bars text-xl"></i>
                </button>

                <img src="../images/./Asopalav Logo.avif" alt="Logo" class="h-10">
            </div>

            <!-- Admin Panel Text -->
            <span class="hidden lg:inline-block text-2xl font-bold ">Admin Panel</span>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex justify-end items-center">
            <div class="relative group">
                <div id="adminProfile" class="flex items-center cursor-pointer space-x-2">
                    <span class="text-[#512DA8]"><?php echo htmlspecialchars($admin_details['admin_name']); ?></span>
                    <div id="profilePhoto" class="w-8 h-8 rounded-full flex items-center justify-center text-white font-semibold text-md mr-1 bg-[#7E57C2]"></div>
                </div>
            </div>
        </div>
    </header>


    <div class="flex flex-1 overflow-hidden">
        <aside id="sidebar" class="w-[13rem] bg-[#decff8] text-[#512DA8] p-3 flex flex-col justify-between overflow-y-auto sidebar-divider-shadow hide-scrollbar text-[15px] transition-transform duration-300 z-40">
            <nav class="space-y-2">
                <a href="dashboard.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                    <div class="w-5 flex items-center justify-center">
                        <i class="fa-solid fa-gauge"></i>
                    </div>
                    <div class="flex-1 overflow-hidden whitespace-nowrap truncate">Dashboard</div>
                </a>

                <a href="home_image.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                    <div class="w-5 flex items-center justify-center">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div class="flex-1 overflow-hidden whitespace-nowrap truncate">Home Image</div>
                </a>

                <div class="dropdown">
                    <button class="flex items-center justify-between w-full py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition">
                        <span class="flex items-center space-x-2 overflow-hidden whitespace-nowrap truncate">
                            <i class="fa-solid fa-shop"></i>
                            <span class="truncate">Shop Management</span>
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="dropdown-content ml-4 mt-1 space-y-1">
                        <a href="categories.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                            <div class="w-5 flex items-center justify-center">
                                <i class="fa-solid fa-list"></i>
                            </div>
                            <div class="flex-1 overflow-hidden whitespace-nowrap truncate">Categories</div>
                        </a>
                        <a href="products.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                            <div class="w-5 flex items-center justify-center">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div class="flex-1 overflow-hidden whitespace-nowrap truncate">Products</div>
                        </a>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="flex items-center justify-between w-full py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition">
                        <span class="flex items-center space-x-2 overflow-hidden whitespace-nowrap truncate">
                            <i class="fa-solid fa-users-gear"></i>
                            <span class="truncate">Details & Management</span>
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="dropdown-content ml-4 mt-1 space-y-1">
                        <a href="admin_details.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                            <div class="w-5 flex items-center justify-center">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <div class="flex-1 overflow-hidden whitespace-nowrap truncate">Admin Details</div>
                        </a>
                        <a href="user_details.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                            <div class="w-5 flex items-center justify-center">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="flex-1 overflow-hidden whitespace-nowrap truncate">User Details</div>
                        </a>
                        <a href="user_messages.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                            <div class="w-5 flex items-center justify-center">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="flex-1 overflow-hidden whitespace-nowrap truncate">User Messages</div>
                        </a>
                    </div>
                </div>

                <a href="locations.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                    <div class="w-5 flex items-center justify-center">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="flex-1 overflow-hidden whitespace-nowrap truncate">Locations</div>
                </a>

                <a href="social_brandings.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                    <div class="w-5 flex items-center justify-center">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="flex-1 overflow-hidden whitespace-nowrap truncate">Social Branding</div>
                </a>

                <a href="orders.php" class="flex py-2 px-3 rounded-md hover:bg-[#C8B9E1] transition items-center space-x-2">
                    <div class="w-5 flex items-center justify-center">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="flex-1 overflow-hidden whitespace-nowrap truncate">Orders</div>
                </a>

                <div class="border-t border-[#512DA8] mt-2 mb-3 opacity-40"></div>

                <button class="w-full bg-[#683ab7ce] hover:bg-[#5E35B1] text-white font-semibold py-2 px-4 rounded-md transition flex items-center space-x-2 text-left">
                    <i class="fa-solid fa-key"></i>
                    <span class="truncate">Change Password</span>
                </button>

                <a href="./admin_logout.php">
                    <button class="w-full bg-[#ad1414dc] hover:bg-[#880e18ee] text-white font-semibold py-2 px-4 rounded-md transition flex items-center space-x-2 text-left mt-2">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="truncate">Logout</span>
                    </button>
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">
            <h1 class="text-3xl font-bold text-[#512DA8] mb-6">Welcome to Your Admin Panel!</h1>
            <p class="text-[#374151] text-lg">This is your main content area. Its background has a subtle, light lavender gradient.</p>
            <div class="mt-8 p-6 bg-white rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Content Area Example</h2>
                <p class="text-[#374151]">
                    This section serves as a placeholder for dynamic content such as dashboards, forms, tables, charts, etc.
                </p>
                <p class="text-[#374151] mt-4">
                    Feel free to populate this section with your specific data and functionalities.
                </p>
                <p class="text-[#374151] mt-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, iste! Pariatur ducimus dolore...
                </p>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const navLinks = document.querySelectorAll('aside nav a');
            const dropdowns = document.querySelectorAll('.dropdown');

            // Toggle sidebar
            sidebarToggle.addEventListener('click', (event) => {
                event.stopPropagation();
                sidebar.classList.toggle('open-sidebar');
                document.body.classList.toggle('sidebar-open-overlay');

                // Toggle hamburger and close icon
                const icon = document.getElementById('toggleIcon');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-xmark');
                icon.classList.toggle('rotate-90'); // Optional rotation for extra effect
            });


            // Close sidebar on outside click (mobile only)
            document.addEventListener('click', (event) => {
                if (window.innerWidth < 1024) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target) && sidebar.classList.contains('open-sidebar')) {
                        sidebar.classList.remove('open-sidebar');
                        document.body.classList.remove('sidebar-open-overlay');
                    }
                }
            });

            // Close sidebar when any nav link is clicked (mobile only)
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        sidebar.classList.remove('open-sidebar');
                        document.body.classList.remove('sidebar-open-overlay');
                    }
                });
            });

            // Dropdown toggle
            dropdowns.forEach(dropdown => {
                const button = dropdown.querySelector('button');
                const content = dropdown.querySelector('.dropdown-content');
                const arrow = dropdown.querySelector('svg');

                button.addEventListener('click', () => {
                    dropdowns.forEach(other => {
                        if (other !== dropdown) {
                            other.querySelector('.dropdown-content').classList.remove('open');
                            other.querySelector('svg').classList.remove('rotate-180');
                        }
                    });

                    content.classList.toggle('open');
                    arrow.classList.toggle('rotate-180');
                });
            });

            // Admin name initial for profile
            const adminNameSpan = document.querySelector('#adminProfile span');
            if (adminNameSpan) {
                const name = adminNameSpan.textContent.trim();
                if (name) {
                    document.getElementById('profilePhoto').textContent = name.charAt(0).toUpperCase();
                }
            }

            // Highlight active nav link and open related dropdown
            const currentPath = window.location.pathname.split('/').pop();
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath) {
                    link.classList.add('active-link');
                    const parentDropdown = link.closest('.dropdown');
                    if (parentDropdown) {
                        parentDropdown.querySelector('.dropdown-content').classList.add('open');
                        parentDropdown.querySelector('svg').classList.add('rotate-180');
                    }
                }
            });

            // On resize: reset overlay and mobile view
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('open-sidebar');
                    document.body.classList.remove('sidebar-open-overlay');

                    // Ensure hamburger icon resets
                    const icon = document.getElementById('toggleIcon');
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-xmark');
                }
            });
        });
    </script>

</body>

</html>