<?php
include('check_session.php');
include('../db_con.php');

if (isset($_REQUEST['submit_btn'])) {
    $size_number = $_REQUEST['size_number'];

    // Insert the new size into the 'sizes' table
    mysqli_query($db, "INSERT INTO sizes (size_number) VALUES ('$size_number')");

    header("Location: sizes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Size | Asopalav.in</title>
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
    <?php include('./admin_parts/header.php'); ?>
    <?php include('./admin_parts/sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">
        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Add Size :</h2>

        <form action="" method="POST" class="space-y-5">

            <div>
                <label for="size_number" class="block text-sm font-medium text-[#512DA8] mb-1">Size Number</label>
                <input type="text" id="size_number" name="size_number" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]" placeholder="Enter size number..." />
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