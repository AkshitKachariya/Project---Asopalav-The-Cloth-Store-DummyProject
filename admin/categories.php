<?php
include('check_session.php');
include('../db_con.php');

// Fetch all categories
$fetch = mysqli_query($db, "SELECT * FROM category ORDER BY category_id DESC");

// Delete category
if (isset($_REQUEST['del'])) {
    $id = $_REQUEST['del'];
    $folder = mysqli_query($db, "SELECT * FROM category WHERE category_id = $id");
    $image = mysqli_fetch_array($folder);
    unlink("../images/" . $image['category_image']);

    mysqli_query($db, "DELETE FROM category WHERE category_id = $id");
    header("Location: categories.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | Asopalav.in</title>
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

        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Categories : </h2>
            <h2 class="text-4xl font-semibold text-[#512DA8] mb-4">
                <a href="./add_categories.php">
                    <i class="fas fa-plus-square"></i>
                </a>
            </h2>
        </div>

        <?php if (mysqli_num_rows($fetch) > 0) { ?>
            <table class="min-w-full border border-gray-300 text-left text-sm text-gray-700 rounded-md overflow-hidden shadow-md shadow-gray-500">
                <thead class="bg-[#c7a8f57e] text-[#512DA8] uppercase font-semibold tracking-wider">
                    <tr class="border border-gray-300">
                        <th class="w-[5%] px-3 py-2 border border-gray-300">ID</th>
                        <th class="w-[50%] px-3 py-2 border border-gray-300">Image</th>
                        <th class="w-[35%] px-3 py-2 border border-gray-300">Name</th>
                        <th class="w-[5%] px-3 py-2 border border-gray-300 text-center">Edit</th>
                        <th class="w-[5%] px-3 py-2 border border-gray-300 text-center">Delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php
                    $total_rows = mysqli_num_rows($fetch);
                    $no = $total_rows;
                    while ($row = mysqli_fetch_array($fetch)) { ?>
                        <tr class="border border-gray-300 hover:bg-purple-50 h-35">
                            <td class="px-3 py-2 border border-gray-300"><?php echo $no--; ?></td>
                            <td class="px-3 py-2 border border-gray-300">
                                <img src="../images/<?php echo $row['category_image']; ?>" alt="image"
                                    class="h-40 rounded shadow border border-gray-300" />
                            </td>
                            <td class="px-3 py-2 border border-gray-300"><?php echo $row['category_name']; ?></td>
                            <td class="px-3 py-2 text-center border border-gray-300">
                                <a href="edit_categories.php?edt=<?php echo $row['category_id']; ?>" class="text-[#8c49ff] hover:text-[#512DA8]">
                                    <i class="fa-solid fa-pen text-lg"></i>
                                </a>
                            </td>
                            <td class="px-3 py-2 text-center border border-gray-300">
                                <a href="categories.php?del=<?php echo $row['category_id']; ?>"
                                    onclick="return confirm('Delete this category?')"
                                    class="text-red-600 hover:text-red-800">
                                    <i class="fa-solid fa-trash text-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo "<p class='text-gray-600'>No categories found.</p>";
        } ?>
    </main>

    <?php include('./admin_parts/footer.php'); ?>
</body>

</html>