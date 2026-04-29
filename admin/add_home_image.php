<?php
include('check_session.php');

include('../db_con.php');

$fetch = mysqli_query($db, "SELECT * FROM home_image ORDER BY image_id DESC");

if (isset($_REQUEST['submit_btn'])) {
    $heading = $_REQUEST['image_heading'];
    $text = $_REQUEST['image_text'];
    $image = $_FILES['image_image']['name'];
    $tmp = $_FILES['image_image']['tmp_name'];
    move_uploaded_file($tmp, "../images/" . $image);

    mysqli_query($db, "INSERT INTO home_image (image_heading, image_text, image_image) VALUES ('$heading', '$text', '$image')");

    header("Location: home_image.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Home Image | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
    <style>
        table,
        td {
            border: 1px solid #D1D5DB;
        }
    </style>
</head>

<body>
    <?php include('./admin_parts/./header.php'); ?>
    <?php include('./admin_parts/./sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">

        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Add Home Image : </h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <div>
                <label for="image_heading" class="block text-sm font-medium text-[#512DA8] mb-1">Image Heading</label>
                <input type="text" id="image_heading" name="image_heading" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]" placeholder="image heading..." />
            </div>

            <div>
                <label for="image_text" class="block text-sm font-medium text-[#512DA8] mb-1">Image Text</label>
                <textarea id="image_text" name="image_text" rows="2" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]" placeholder="image text..."></textarea>
            </div>

            <div>
                <label for="image_image" class="block text-sm font-medium text-[#512DA8] mb-1">Upload Image</label>
                <input type="file" id="image_image" name="image_image" accept="image/*" required
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                   file:rounded-md file:border-0 file:text-sm file:font-semibold
                   file:bg-[#ede7f6] file:text-[#512DA8]
                   hover:file:bg-[#d1c4e9] cursor-pointer" />
            </div>

            <div class="pt-2 text-end">
                <button type="submit" name="submit_btn"
                    class="bg-[#512DA8] hover:bg-[#3c1c99] text-white px-6 py-2 rounded-md transition duration-200">
                    Insert Record
                </button>
            </div>
        </form>
    </main>

    <?php include('./admin_parts/./footer.php'); ?>
</body>

</html>