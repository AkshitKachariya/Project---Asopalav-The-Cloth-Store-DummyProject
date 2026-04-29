<?php

session_start();

include('./db_con.php');

if (!$_SESSION['session']) {

    header('location:login.php');
    die;
}

$session = $_SESSION['session'];
$data = mysqli_query($db, "select * from users where user_email='$session'");
$array = mysqli_fetch_array($data);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information | Asopalav.in</title>
    <script src="./jquery-3.7.1.min.js"></script>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
</head>

<body>

    <header class="sticky top-0 z-10">
        <?php include('./main_header.php'); ?>
    </header>

    <main class="py-10 lg:px-20 px-5 flex flex-col items-center justify-center min-h-[50vh]">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm max-w-md w-full text-center transform transition-all duration-500  shadow-gray-800">
            <h2 class="text-2xl font-playfair font-semibold text-[#c28e5c] mb-1">
                Welcome, <?php echo $array['user_name']; ?>!
            </h2>
            <p class="text-gray-500 text-sm mb-10">
                Here's your profile overview.
            </p>

            <div class="space-y-4 text-left text-gray-700">
                <div class="flex items-center space-x-3 p-3 bg-gray-100 rounded-lg transition-all duration-300 hover:bg-gray-200 shadow-inner">
                    <i class="fa-solid fa-user text-lg text-[#2e2e2e]"></i>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Username</h3>
                        <p class="text-base font-semibold text-[#2e2e2e]"><?php echo $array['user_name']; ?></p>
                    </div>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-100 rounded-lg transition-all duration-300 hover:bg-gray-200 shadow-inner">
                    <i class="fa-solid fa-envelope text-lg text-[#2e2e2e]"></i>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Email</h3>
                        <p class="text-base font-semibold text-[#2e2e2e]"><?php echo $array['user_email']; ?></p>
                    </div>
                </div>

                <div class="flex items-center space-x-3 p-3 bg-gray-100 rounded-lg transition-all duration-300 hover:bg-gray-200 shadow-inner">
                    <i class="fa-solid fa-phone text-lg text-[#2e2e2e]"></i>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Phone</h3>
                        <p class="text-base font-semibold text-[#2e2e2e]"><?php echo $array['user_phone']; ?></p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-3 sm:space-y-0 mt-8">
                <a href="change_password.php" class="inline-block w-full">
                    <button class="w-full bg-[#2e2e2e] text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-101 hover:bg-[#1a1a1a] shadow-lg focus:outline-none focus:ring-2 focus:ring-[#c28e5c] focus:ring-opacity-50 text-sm">
                        Change Password
                    </button>
                </a>

                <a href="orders.php" class="inline-block w-full">
                    <button class="w-full bg-[#2e2e2e] text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-101 hover:bg-[#1a1a1a] shadow-lg focus:outline-none focus:ring-2 focus:ring-[#c28e5c] focus:ring-opacity-50 text-sm">
                        Your Orders
                    </button>
                </a>
            </div>

            <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-3 sm:space-y-0 mt-3">
                <a href="logout.php" class="inline-block w-full">
                    <button class="w-full bg-[#c28e5c] hover:bg-[#a5784a] text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-101 shadow-lg focus:outline-none focus:ring-2 focus:ring-[#c28e5c] focus:ring-opacity-50 text-sm">
                        Logout
                    </button>
                </a>
            </div>
        </div>
    </main>


    <footer class="mb-10 lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>

</body>

</html>