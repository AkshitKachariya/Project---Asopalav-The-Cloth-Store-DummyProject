<?php
include('check_session.php');
include('../db_con.php');

$fetch = mysqli_query($db, "SELECT * FROM store_location ORDER BY location_id DESC");

if (isset($_REQUEST['del'])) {
    $id = $_REQUEST['del'];
    $folder = mysqli_query($db, "SELECT * FROM store_location WHERE location_id = $id");
    $image = mysqli_fetch_array($folder);
    unlink("../images/" . $image['location_image']);

    mysqli_query($db, "DELETE FROM store_location WHERE location_id = $id");
    header("Location: store_locations.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Locations | Asopalav.in</title>
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
            <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Store Locations : </h2>
            <h2 class="text-4xl font-semibold text-[#512DA8] mb-4">
                <a href="./add_store_locations.php">
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
                        <th class="w-[25%] px-3 py-2 border border-gray-300">Image</th>
                        <th class="w-[10%] px-3 py-2 border border-gray-300">Name</th>
                        <th class="w-[20%] px-3 py-2 border border-gray-300">Address</th>
                        <th class="w-[20%] px-3 py-2 border border-gray-300">Link</th>
                        <th class="w-[10%] px-3 py-2 border border-gray-300">Phone</th>
                        <th class="w-[5%] px-3 py-2 text-center border border-gray-300">Edit</th>
                        <th class="w-[5%] px-3 py-2 text-center border border-gray-300">Delete</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php
                    $total_rows = mysqli_num_rows($fetch);
                    $no = $total_rows;
                    while ($row = mysqli_fetch_array($fetch)) {
                    ?>
                        <tr class="border hover:bg-purple-50">
                            <td class="px-3 py-2 border"><?php echo $no--; ?></td>
                            <td class="px-3 py-2 border">
                                <img src="../images/<?php echo $row['location_image']; ?>" alt="store"
                                    class="h-40 rounded shadow border border-gray-300" />
                            </td>
                            <td class="px-3 py-2 border"><?php echo $row['location_name']; ?></td>
                            <td class="px-3 py-2 border"><?php echo $row['location_address']; ?></td>
                            <td class="px-3 py-2 border">
                                <div class="w-64 h-48 overflow-hidden rounded-lg shadow-lg border border-gray-200">
                                    <iframe src="<?php echo $row['location_link']; ?>"
                                        class="w-full h-full border-0 rounded-md"
                                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </td>
                            <td class=" px-3 py-2 border"><?php echo $row['location_phone']; ?></td>
                            <td class="px-3 py-2 text-center border">
                                <a href="edit_store_locations.php?edt=<?php echo $row['location_id']; ?>" class="text-[#8c49ff] hover:text-[#512DA8]">
                                    <i class="fa-solid fa-pen text-lg"></i>
                                </a>
                            </td>
                            <td class="px-3 py-2 text-center border">
                                <a href="store_locations.php?del=<?php echo $row['location_id']; ?>"
                                    onclick="return confirm(' Delete this record?')"
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
            echo "<p class='text-gray-600'>No store locations found.</p>";
        }
        ?>
    </main>

    <?php include('./admin_parts/footer.php'); ?>
</body>

</html>