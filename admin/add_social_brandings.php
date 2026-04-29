<?php
include('check_session.php');
include('../db_con.php');

if (isset($_REQUEST['submit_btn'])) {
    $name = $_REQUEST['social_name'];
    $link = $_REQUEST['social_link'];
    $icon = $_REQUEST['social_icon'];

    mysqli_query($db, "INSERT INTO socials (social_name, social_link, social_icon) VALUES ('$name', '$link', '$icon')");

    header("Location: social_brandings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Social Branding | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="../src/output.css">
    <style>
        table,
        td {
            border: 1px solid #D1D5DB;
        }
    </style>
</head>

<body>
    <?php include('./admin_parts/header.php'); ?>
    <?php include('./admin_parts/sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">
        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Add Social Branding :</h2>

        <form action="" method="POST" class="space-y-5">

            <div>
                <label for="social_name" class="block text-sm font-medium text-[#512DA8] mb-1">Social Name</label>
                <input type="text" id="social_name" name="social_name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]" placeholder="social platform name..." />
            </div>

            <div>
                <label for="social_link" class="block text-sm font-medium text-[#512DA8] mb-1">Social Link</label>
                <input type="url" id="social_link" name="social_link" required
                    placeholder="https://www.instagram.com/..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]" />
            </div>

            <div>
                <label for="social_icon" class="block text-sm font-medium text-[#512DA8] mb-1">Font Awesome Icon</label>
                <input type="text" id="social_icon" name="social_icon" required
                    placeholder="e.g., fab fa-instagram"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    oninput="previewIcon(this.value)" />
                <p class="text-sm mt-2 text-gray-600">Browse icons: <a href="https://fontawesome.com/search" target="_blank" class="text-blue-600 underline">https://fontawesome.com/search</a></p>
            </div>

            <div class="pt-2 text-end">
                <button type="submit" name="submit_btn"
                    class="bg-[#512DA8] hover:bg-[#3c1c99] text-white px-6 py-2 rounded-md transition duration-200">
                    Insert Record
                </button>
            </div>
        </form>
    </main>

    <?php include('./admin_parts/footer.php'); ?>

</body>

</html>