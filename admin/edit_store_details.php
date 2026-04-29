<?php
include('check_session.php');
include('../db_con.php');

if (isset($_REQUEST['edt'])) {

    $id = $_REQUEST['edt'];
    $record = mysqli_query($db, "SELECT * FROM store_details WHERE store_id=$id");
    $result = mysqli_fetch_array($record);
}

if (isset($_REQUEST['submit_btn'])) {
    $phone = $_REQUEST['store_phone'];
    $email = $_REQUEST['store_email'];
    $timing = $_REQUEST['store_timing'];

    mysqli_query($db, "UPDATE store_details SET store_phone='$phone', store_email='$email', store_timing='$timing' WHERE store_id=$id");

    header("Location: store_details.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Store Details | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
</head>

<body>
    <?php include('./admin_parts/header.php'); ?>
    <?php include('./admin_parts/sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">
        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Edit Store Details:</h2>

        <form action="" method="POST" class="space-y-5">
            <div>
                <label for="store_phone" class="block text-sm font-medium text-[#512DA8] mb-1">Phone Number</label>
                <input type="text" id="store_phone" name="store_phone" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    value="<?php echo $result['store_phone']; ?>" placeholder="Enter phone number..." />
            </div>

            <div>
                <label for="store_email" class="block text-sm font-medium text-[#512DA8] mb-1">Email</label>
                <input type="email" id="store_email" name="store_email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    value="<?php echo $result['store_email']; ?>" placeholder="Enter email..." />
            </div>

            <div>
                <label for="store_timing" class="block text-sm font-medium text-[#512DA8] mb-1">Store Timing</label>
                <input type="text" id="store_timing" name="store_timing" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    value="<?php echo $result['store_timing']; ?>" placeholder="Enter store timing..." />
            </div>

            <div class="pt-2 text-end">
                <button type="submit" name="submit_btn"
                    class="bg-[#512DA8] hover:bg-[#3c1c99] text-white px-6 py-2 rounded-md transition duration-200">
                    Update Record
                </button>
            </div>
        </form>
    </main>

    <?php include('./admin_parts/footer.php'); ?>
</body>

</html>