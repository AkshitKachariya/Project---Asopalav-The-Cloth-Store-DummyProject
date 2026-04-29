<?php
include('./db_con.php');
session_start();

if (isset($_POST['subscribe']) && !empty($_POST['subs_email'])) {
    $email = $_POST['subs_email'];

    // Sanitize the email to prevent XSS
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    // Check if the email already exists using a prepared statement
    $check_query = "SELECT subs_email FROM subscribers WHERE subs_email = ?";
    $stmt = mysqli_prepare($db, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Email already exists
        $_SESSION['alert_message'] = "It looks like you are already subscribed to our newsletter!";
    } else {
        // Email does not exist, proceed with insertion
        $insert_query = "INSERT INTO subscribers (subs_email) VALUES (?)";
        $insert_stmt = mysqli_prepare($db, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, "s", $email);

        if (mysqli_stmt_execute($insert_stmt)) {
            $_SESSION['alert_message'] = "You have been successfully subscribed! Welcome to our newsletter.";
        } else {
            $_SESSION['alert_message'] = "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($insert_stmt);
    }
    mysqli_stmt_close($stmt);
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
        /* Default mobile-first styles (accordion active) */
        .accordion-item {
            border-bottom: 1px solid #444;
            padding: 10px 0;
        }

        .accordion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            padding-top: 0;
            color: #d1d5db;
        }

        .accordion-content-inner {
            padding-top: 5px;
        }

        .accordion-item.active .accordion-content {
            max-height: 200px;
            transition: max-height 0.3s ease-in;
        }

        .accordion-content ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .accordion-content li {
            padding: 3px 0;
        }

        .accordion-icon {
            transition: transform 0.3s ease;
        }

        .accordion-item.active .accordion-icon {
            transform: rotate(180deg);
        }

        /* Styles for screens larger than 1024px (lg and up) */
        @media (min-width: 1024px) {

            /* Remove border and padding for desktop */
            .accordion-item {
                border-bottom: none;
                padding: 0;
            }

            /* Adjust header for desktop */
            .accordion-header {
                cursor: default;
                margin-bottom: 5px;
            }

            .accordion-header .accordion-icon {
                display: none;
            }

            /* Display accordion content on desktop */
            .accordion-content {
                display: block !important;
                max-height: none !important;
                transition: none !important;
                padding-top: 0px !important;
            }

            .accordion-content-inner {
                padding-top: 0px;
            }

            /* Adjust space between columns for desktop */
            .lg\:flex-row {
                gap: 4rem;
            }

            /* Align newsletter section for desktop */
            .lg\:w-\[40\%\] {
                margin-top: 0;
            }
        }
    </style>
</head>

<body>

    <?php
    if (isset($_SESSION['alert_message']) && !empty($_SESSION['alert_message'])) {
    ?>
        <script>
            alert("<?php echo htmlspecialchars($_SESSION['alert_message'], ENT_QUOTES, 'UTF-8'); ?>");
            <?php unset($_SESSION['alert_message']); ?>
        </script>
    <?php
    }
    ?>

    <div class="w-full bg-[#333333] text-gray-300 font-poppins py-8 lg:py-12">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row md:flex-nowrap gap-6 lg:gap-10">

                <div class="w-full lg:w-[60%] flex flex-col lg:flex-row gap-2.5 lg:gap-10">
                    <div class="accordion-item w-full lg:w-1/3">
                        <div class="accordion-header pb-1">
                            <h4 class="text-sm lg:text-base">SHOP</h4>
                            <span class="accordion-icon">
                                <i class="fas fa-chevron-down text-[12px] lg:text-[13px]"></i>
                            </span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <ul class="space-y-1.5">
                                    <li><a href="./shop.php" class="hover:text-white hover:underline transition text-sm">Shop</a></li>
                                    <li><a href="./store_locations.php" class="hover:text-white hover:underline transition text-sm">Store Locator</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item w-full lg:w-1/3">
                        <div class="accordion-header pb-1">
                            <h4 class="text-sm lg:text-base">INFORMATION</h4>
                            <span class="accordion-icon">
                                <i class="fas fa-chevron-down text-[12px] lg:text-[13px]"></i>
                            </span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <ul class="space-y-1.5">
                                    <li><a href="./contact_us.php" class="hover:text-white hover:underline transition text-sm">Contact Us</a></li>
                                    <li><a href="./about_us.php" class="hover:text-white hover:underline transition text-sm">About Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item w-full lg:w-1/3">
                        <div class="accordion-header pb-1">
                            <h4 class="text-sm lg:text-base">CUSTOMER SERVICE</h4>
                            <span class="accordion-icon">
                                <i class="fas fa-chevron-down text-[12px] lg:text-[13px]"></i>
                            </span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-content-inner">
                                <ul class="space-y-1.5">
                                    <li><a href="./shipping_policy.php" class="hover:text-white hover:underline transition text-sm">Shipping Policy</a></li>
                                    <li><a href="./refund_policy.php" class="hover:text-white hover:underline transition text-sm">Refund Policy</a></li>
                                    <li><a href="./privacy_policy.php" class="hover:text-white hover:underline transition text-sm">Privacy Policy</a></li>
                                    <li><a href="./t&c.php" class="hover:text-white hover:underline transition text-sm">T&C</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-[40%] mt-2 md:mt-0">
                    <h4 class="font-bold mb-2 uppercase text-sm lg:text-base">NEWSLETTER SIGN UP</h4>
                    <p class="text-xs lg:text-sm mb-4 leading-relaxed">
                        Sign up for exclusive updates, new arrivals & insider only discounts.
                    </p>
                    <form action="" method="post" class="flex flex-col md:flex-row gap-2 mt-3 text-sm">
                        <input type="email" name="subs_email" id="subs_email" placeholder="Enter your email address"
                            required
                            class="flex-1 px-3 py-2 border border-gray-400 outline-none bg-transparent rounded-sm text-sm" />
                        <button type="submit" name="subscribe"
                            class="px-5 py-2 bg-white text-[#333333] border border-gray-400 font-semibold hover:bg-[#333333] hover:text-white duration-300 rounded-sm">
                            SUBSCRIBE
                        </button>
                    </form>

                    <div class="socials flex space-x-3 pt-4 justify-center md:justify-start">
                        <?php
                        $social_branding_data = mysqli_query($db, "select * from socials");
                        while ($socials = mysqli_fetch_array($social_branding_data)) {
                        ?>
                            <a href="<?php echo $socials['social_link']; ?>" target="_blank"
                                class="flex items-center justify-center bg-white text-gray-700 rounded-full h-9 w-9 transition hover:ring-2 hover:ring-gray-300 hover:ring-offset-2">
                                <i class="<?php echo $socials['social_icon']; ?> text-lg"></i>
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accordionHeaders = document.querySelectorAll('.accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        const currentItem = header.closest('.accordion-item');
                        const isActive = currentItem.classList.contains('active');

                        document.querySelectorAll('.accordion-item').forEach(item => {
                            if (item !== currentItem) {
                                item.classList.remove('active');
                                const content = item.querySelector('.accordion-content');
                                content.style.maxHeight = '0';
                            }
                        });

                        currentItem.classList.toggle('active');
                        const content = currentItem.querySelector('.accordion-content');
                        if (isActive) {
                            content.style.maxHeight = '0';
                        } else {
                            content.style.maxHeight = content.scrollHeight + "px";
                        }
                    }
                });
            });

            const currentUrl = window.location.pathname.split("/").pop();
            document.querySelectorAll(".accordion-content a").forEach(link => {
                // yaha "./" hata diya
                let linkHref = link.getAttribute("href").replace("./", "");
                if (linkHref === currentUrl) {
                    const accordionItem = link.closest(".accordion-item");
                    accordionItem.classList.add("active");

                    const content = accordionItem.querySelector(".accordion-content");
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });

        });
    </script>
</body>

</html>