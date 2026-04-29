<?php
include('check_session.php');
include('../db_con.php');

if (isset($_REQUEST['edt'])) {
    $id = $_REQUEST['edt'];
    $record = mysqli_query($db, "SELECT * FROM category WHERE category_id = $id");
    $result = mysqli_fetch_array($record);
}

if (isset($_REQUEST['submit_btn'])) {
    $name = $_REQUEST['category_name'];
    $image = $_FILES['category_image']['name'];
    $tmp = $_FILES['category_image']['tmp_name'];

    if ($image == "") {
        $image = $result['category_image'];
    } else {
        move_uploaded_file($tmp, "../images/" . $image);
    }

    mysqli_query($db, "UPDATE category SET category_name='$name', category_image='$image' WHERE category_id=$id");

    header("Location: categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Category | Asopalav.in</title>
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
        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Edit Category :</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <div>
                <label for="category_name" class="block text-sm font-medium text-[#512DA8] mb-1">Category Name</label>
                <input type="text" id="category_name" name="category_name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    value="<?php echo $result['category_name']; ?>" placeholder="category name..." />
            </div>

            <div>
                <label for="category_image" class="block text-sm font-medium text-[#512DA8] mb-1">Upload Image</label>
                <input type="file" id="category_image" name="category_image" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0 file:text-sm file:font-semibold
                    file:bg-[#ede7f6] file:text-[#512DA8]
                    hover:file:bg-[#d1c4e9] cursor-pointer" /> <br>

                <img src="../images/<?php echo $result['category_image']; ?>" alt="" width="200px">
                <p>Image: (<?php echo $result['category_image']; ?>)</p>
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