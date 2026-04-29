<?php
include('check_session.php');
include('../db_con.php');

if (isset($_REQUEST['edt'])) {
    $id = $_REQUEST['edt'];
    $record = mysqli_query($db, "SELECT * FROM store_location WHERE location_id = $id");
    $result = mysqli_fetch_array($record);
}

if (isset($_REQUEST['submit_btn'])) {
    $id = $_REQUEST['location_id'];
    $name = $_REQUEST['location_name'];
    $address = $_REQUEST['location_address'];
    $link = $_REQUEST['location_link'];
    $phone = $_REQUEST['location_phone'];
    $image = $_FILES['location_image']['name'];
    $tmp = $_FILES['location_image']['tmp_name'];
    move_uploaded_file($tmp, "../images/" . $image);

    if ($image == "") {

        $image = $result['location_image'];
    }

    mysqli_query($db, "UPDATE store_location SET location_name='$name', location_address='$address', location_link='$link', location_phone='$phone', location_image='$image' WHERE location_id=$id");

    header("Location: store_locations.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Store Location | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
</head>

<body>
    <?php include('./admin_parts/header.php'); ?>
    <?php include('./admin_parts/sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">
        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Edit Store Location :</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5" onsubmit="return validateForm();">

            <input type="hidden" name="location_id" value="<?php echo $result['location_id']; ?>">
            <input type="hidden" name="old_location_image" value="<?php echo $result['location_image']; ?>">

            <div>
                <label for="location_name" class="block text-sm font-medium text-[#512DA8] mb-1">Store Name</label>
                <input type="text" id="location_name" name="location_name" required placeholder="store name..."
                    value="<?php echo $result['location_name']; ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]" />
            </div>

            <div>
                <label for="location_address" class="block text-sm font-medium text-[#512DA8] mb-1">Store Address</label>
                <textarea id="location_address" name="location_address" rows="2" required placeholder="store address..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"><?php echo $result['location_address']; ?></textarea>
            </div>

            <div>
                <label for="location_phone" class="block text-sm font-medium text-[#512DA8] mb-1">Phone Number</label>
                <input type="text" id="location_phone" name="location_phone" required placeholder="10-digit number"
                    maxlength="10" value="<?php echo $result['location_phone']; ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]" />
            </div>

            <div>
                <label for="location_link" class="block text-sm font-medium text-[#512DA8] mb-1">Google Maps Link</label>
                <input type="text" id="location_link" name="location_link" required placeholder="Paste Google Maps link..."
                    value="<?php echo htmlspecialchars($result['location_link']); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]" />
                <p class="text-sm text-gray-500 mt-1">
                    Paste only the <strong>iframe src URL</strong> from Google Maps' "Embed a map" option.
                </p>
            </div>

            <div>
                <label for="location_image" class="block text-sm font-medium text-[#512DA8] mb-1">Upload Image</label>
                <input type="file" id="location_image" name="location_image" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0 file:text-sm file:font-semibold
                file:bg-[#ede7f6] file:text-[#512DA8]
                hover:file:bg-[#d1c4e9] cursor-pointer" /><br>
                <img src="../images/<?php echo $result['location_image']; ?>" alt="Current Store Image"
                    class="h-40 mb-2 rounded shadow border border-gray-300" />
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

    <script>
        function validateForm() {
            const phone = document.getElementById("location_phone").value.trim();
            const phoneRegex = /^[0-9]{10}$/;

            if (!phoneRegex.test(phone)) {
                alert("Please enter a valid 10-digit phone number.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>