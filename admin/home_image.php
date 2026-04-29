<?php
include('check_session.php');

include('../db_con.php');

$fetch = mysqli_query($db, "SELECT * FROM home_image ORDER BY image_id DESC");

if (isset($_REQUEST['del'])) {
    $id = $_REQUEST['del'];
    $folder = mysqli_query($db, "SELECT * FROM home_image WHERE image_id = $id");
    $image = mysqli_fetch_array($folder);
    unlink("../images/" . $image['image_image']);

    mysqli_query($db, "DELETE FROM home_image WHERE image_id = $id");
    header("Location: home_image.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Image | Asopalav.in</title>
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

        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Home Image : </h2>
            <h2 class="text-4xl font-semibold text-[#512DA8] mb-4">
                <a href="./add_home_image.php">
                    <i class="fas fa-plus-square"></i>
                </a>
            </h2>
        </div>

        <?php
        if (mysqli_num_rows($fetch) > 0) {
        ?>
            <table class="min-w-full border border-gray-300 text-left text-sm text-gray-700 rounded-md overflow-hidden shadow-md shadow-gray-500">
                <thead class="bg-[#c7a8f57e] text-[#512DA8] uppercase font-semibold tracking-wider">
                    <tr class="border border-gray-300">
                        <th class="w-[5%] px-3 py-2 border border-gray-300">No.</th>
                        <th class="w-[30%] px-3 py-2 border border-gray-300">Image</th>
                        <th class="w-[20%] px-3 py-2 border border-gray-300">Heading</th>
                        <th class="w-[30%] px-3 py-2 border border-gray-300">Text</th>
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
                                <img src="../images/<?php echo $row['image_image']; ?>" alt="image"
                                    class="h-40 rounded shadow border border-gray-300" />
                            </td>
                            <td class="px-3 py-2 border border-gray-300"><?php echo $row['image_heading']; ?></td>
                            <td class="px-3 py-2 border border-gray-300"><?php echo $row['image_text']; ?></td>
                            <td class="px-3 py-2 text-center border border-gray-300">
                                <a href="edit_home_image.php?edt=<?php echo $row['image_id']; ?>" class="text-[#8c49ff] hover:text-[#512DA8]">
                                    <i class="fa-solid fa-pen text-lg"></i>
                                </a>
                            </td>
                            <td class="px-3 py-2 text-center border border-gray-300">
                                <a href="home_image.php?del=<?php echo $row['image_id']; ?>"
                                    onclick="return confirm('Delete this record?')"
                                    class="text-red-600 hover:text-red-800">
                                    <i class="fa-solid fa-trash text-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "<p class='text-gray-600'>No home page images found.</p>";
        }
        ?>
    </main>

    <?php include('./admin_parts/./footer.php'); ?>
</body>

</html>