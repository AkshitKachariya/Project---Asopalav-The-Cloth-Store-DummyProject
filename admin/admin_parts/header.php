<?php
include('../db_con.php');
session_start();

$admin_query = "select * from admins";
$fetch_admin = mysqli_query($db, $admin_query);
$admin_details = mysqli_fetch_array($fetch_admin);

$home_image = mysqli_query($db, "select * from home_image");
$count_home_image = mysqli_num_rows($home_image);

$category = mysqli_query($db, "select * from category");
$count_category = mysqli_num_rows($category);

$sizes = mysqli_query($db, "select * from sizes");
$count_sizes = mysqli_num_rows($sizes);

$products = mysqli_query($db, "select * from products");
$count_products = mysqli_num_rows($products);

$users = mysqli_query($db, "select * from users");
$count_users = mysqli_num_rows($users);

$user_messages = mysqli_query($db, "select * from user_messages");
$count_user_messages = mysqli_num_rows($user_messages);

$subscribers = mysqli_query($db, "select * from subscribers");
$count_subscribers = mysqli_num_rows($subscribers);

$store_location = mysqli_query($db, "select * from store_location");
$count_store_location = mysqli_num_rows($store_location);

$store_details = mysqli_query($db, "select * from store_details");
$count_store_details = mysqli_num_rows($store_details);

$socials = mysqli_query($db, "select * from socials");
$count_socials = mysqli_num_rows($socials);

$orders = mysqli_query($db, "select * from orders");
$count_orders = mysqli_num_rows($orders);

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
        /* Your CSS styles go here */
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

        /* Apply to all scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        /* Scrollbar track (background) */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        /* Scrollbar thumb (scrolling part) */
        ::-webkit-scrollbar-thumb {
            background-color: #512DA8;
            /* Your theme color */
            border-radius: 10px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        /* On hover */
        ::-webkit-scrollbar-thumb:hover {
            background-color: #3c1c99;
        }
    </style>
</head>

<body class="font-poppins flex flex-col h-screen overflow-hidden m-0">
    <header class="bg-[#decff8] text-[#512DA8] p-3 flex justify-between items-center sticky top-0 z-50 shadow-md h-16 w-full">
        <div class="flex items-center space-x-0">
            <div class="hidden lg:flex items-center justify-center bg-[#decff8] w-[14.5rem] h-16 px-4">
                <img src="../images/./Asopalav Logo.avif" alt="Logo" class="h-10">
            </div>

            <div class="flex lg:hidden items-center w-[14.5rem] px-2 space-x-5">
                <button id="sidebarToggle" class="lg:hidden focus:outline-none bg-[#7E57C2] hover:bg-[#6b38b3ea] text-white p-2 rounded-md shadow-md transition-all duration-200 flex items-center cursor-pointer w-[35px] justify-center">
                    <i id="toggleIcon" class="fa-solid fa-bars text-xl"></i>
                </button>

                <img src="../images/./Asopalav Logo.avif" alt="Logo" class="h-10">
            </div>

            <span class="hidden lg:inline-block text-2xl font-bold ">Admin Panel</span>
        </div>

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