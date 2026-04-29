<?php
include('check_session.php');
include('../db_con.php');

// Fetch all sizes
$fetch = mysqli_query($db, "SELECT * FROM sizes ORDER BY size_id DESC");

// Delete size
if (isset($_REQUEST['del'])) {
    $id = $_REQUEST['del'];
    mysqli_query($db, "DELETE FROM sizes WHERE size_id = $id");
    header("Location: sizes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sizes | Asopalav.in</title>
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
            <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Sizes : </h2>
            <h2 class="text-4xl font-semibold text-[#512DA8] mb-4">
                <a href="./add_sizes.php">
                    <i class="fas fa-plus-square"></i>
                </a>
            </h2>
        </div>

        <?php if (mysqli_num_rows($fetch) > 0) { ?>
            <table class="min-w-full border border-gray-300 text-left text-sm text-gray-700 rounded-md overflow-hidden shadow-md shadow-gray-500">
                <thead class="bg-[#c7a8f57e] text-[#512DA8] uppercase font-semibold tracking-wider">
                    <tr class="border border-gray-300">
                        <th class="w-[5%] px-3 py-2 border border-gray-300">ID</th>
                        <th class="w-[35%] px-3 py-2 border border-gray-300">Size Number</th>
                        <th class="w-[5%] px-3 py-2 border border-gray-300 text-center">Edit</th>
                        <th class="w-[5%] px-3 py-2 border border-gray-300 text-center">Delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php
                    $total_rows = mysqli_num_rows($fetch);
                    $no = $total_rows;
                    while ($row = mysqli_fetch_array($fetch)) { ?>
                        <tr class="border border-gray-300 hover:bg-purple-50 h-10">
                            <td class="px-3 py-2 border border-gray-300"><?php echo $no--; ?></td>
                            <td class="px-3 py-2 border border-gray-300"><?php echo $row['size_number']; ?></td>
                            <td class="px-3 py-2 text-center border border-gray-300">
                                <a href="edit_sizes.php?edt=<?php echo $row['size_id']; ?>" class="text-[#8c49ff] hover:text-[#512DA8]">
                                    <i class="fa-solid fa-pen text-lg"></i>
                                </a>
                            </td>
                            <td class="px-3 py-2 text-center border border-gray-300">
                                <a href="sizes.php?del=<?php echo $row['size_id']; ?>"
                                    onclick="return confirm('Delete this size?')"
                                    class="text-red-600 hover:text-red-800">
                                    <i class="fa-solid fa-trash text-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo "<p class='text-gray-600'>No sizes found.</p>";
        } ?>
    </main>

    <?php include('./admin_parts/footer.php'); ?>
</body>

</html>