<?php

include('./db_con.php');

if (isset($_REQUEST['sumbit'])) {

    $name = $_REQUEST['message_name'];
    $phone = $_REQUEST['message_phone'];
    $email = $_REQUEST['message_email'];
    $message = $_REQUEST['message_message'];

    $insert = mysqli_query($db, "insert into user_messages (message_name,message_phone,message_email,message_message) values ('$name','$phone','$email','$message') ");

    if ($insert) {
        echo "<script>
            alert('Thanks for reaching out! We\\'ll be in touch shortly.');
            window.location.href = 'contact_us.php'; // Redirect after alert
        </script>";
    } else {
        echo "<script>alert('There was an error submitting your message. Please try again.');</script>";
    }
}

$fetch_store_details = mysqli_query($db, "select * from store_details");
$store_details = mysqli_fetch_array($fetch_store_details);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
</head>

<body>
    <header class="sticky top-0 z-10">
        <?php include('./main_header.php'); ?>
    </header>
    <main class="pt-15 pb-0 lg:px-20 px-10 space-y-4">
        <div class="text-center text-3xl font-bold uppercase">Contact Us</div>

        <div class="lg:flex space-x-3 space-y-20">
            <div class="left lg:w-[60%] w-full text-[15px] lg:p-10 p-0">
                <p class="text-gray-800 text-sm mb-1 font-semibold">Send us an email</p>
                <p class="text-gray-800 text-sm mb-8">Ask us anything! We're here to help.</p>

                <form action="" method="post" class="space-y-5">
                    <div class="field space-y-1">
                        <p class="text-gray-800 text-sm font-semibold">Name*</p>
                        <input type="text" name="message_name" id="" class="w-full border-1 border-gray-400 outline-none px-4 py-2 text-[15px] text-gray-800 text-sm" placeholder="Enter Your Name" required>
                    </div>

                    <div class="field space-y-1">
                        <p class="text-gray-800 text-sm font-semibold">Phone Number*</p>
                        <input type="text" name="message_phone" id="" class="w-full border-1 border-gray-400 outline-none px-4 py-2 text-[15px] text-gray-800 text-sm" placeholder="Enter Your Phone Number" required>
                    </div>

                    <div class="field space-y-1">
                        <p class="text-gray-800 text-sm font-semibold">Email*</p>
                        <input type="text" name="message_email" id="" class="w-full border-1 border-gray-400 outline-none px-4 py-2 text-[15px] text-gray-800 text-sm" placeholder="Enter Your Email" required>
                    </div>

                    <div class="field space-y-1">
                        <p class="text-gray-800 text-sm font-semibold">Comment*</p>
                        <textarea name="message_message" id="" cols="30" rows="5" class="w-full border-1 border-gray-400 outline-none px-4 py-2 text-[15px] text-gray-800 text-sm" placeholder="Enter Message Here" required></textarea>
                    </div>

                    <div class="field">
                        <input type="submit" value="Submit" name="sumbit" class="border-1 bg-[#333333] w-full py-3 text-white hover:bg-white hover:text-[#333333] hover:border-[#333333] hover:border transition duration-500 font-bold">
                    </div>
                </form>
            </div>

            <div class="right lg:w-[40%] w-full space-y-8 bg-gray-50 py-5 lg:p-10 p-0 h-full ">

                <div class="block1">
                    <p class="text-gray-800 text-sm mb-1 font-bold">Online Inquiries</p>
                    <div class="flex text-gray-800 items-center">
                        <i class="fas fa-message text-md text-gray-800"></i>&nbsp;
                        <p class="text-sm">+91 <?php echo $store_details['store_phone']; ?></p>
                    </div>
                    <div class="flex text-gray-800 items-center">
                        <i class="fas fa-envelope text-lg text-gray-800"></i>&nbsp;
                        <p class="text-sm"><?php echo $store_details['store_email']; ?></p>
                    </div>
                </div>

                <div class="block2">
                    <p class="text-gray-800 text-sm mb-1 font-bold">Our Stores</p>

                    <div class="all text-sm space-y-5">
                        <?php
                        $locations = mysqli_query($db, "select * from store_location");

                        while ($fetch_location = mysqli_fetch_array($locations)) {
                        ?>
                            <div class="text-gray-800">
                                <p>
                                    <i class="fas fa-map"></i>&nbsp;
                                    <?php echo $fetch_location['location_name']; ?>
                                </p>
                                <p>
                                    <i class="fas fa-phone"></i>&nbsp;
                                    +91 <?php echo $fetch_location['location_phone']; ?>
                                </p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="block3">
                    <p class="text-gray-800 text-sm mb-1 font-bold">Opening Hours</p>
                    <div class="flex text-gray-800 items-center">
                        <i class="fas fa-clock text-md"></i>&nbsp;
                        <p class="text-sm"><?php echo $store_details['store_timing']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="mb-10 lg:mt-[-30px] lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>
</body>

</html>