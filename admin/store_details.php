<?php
include('check_session.php');
include('../db_con.php');

$fetch = mysqli_query($db, "SELECT * FROM store_details ORDER BY store_id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Details | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
</head>

<body>
    <?php include('./admin_parts/./header.php'); ?>
    <?php include('./admin_parts/./sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">

        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Store Details : </h2>

        <?php if (mysqli_num_rows($fetch) > 0) { ?>
            <table class="min-w-full border border-gray-300 text-left text-sm text-gray-700 rounded-md overflow-hidden shadow-md shadow-gray-500">
                <thead class="bg-[#c7a8f57e] text-[#512DA8] uppercase font-semibold tracking-wider">
                    <tr class="border border-gray-300">
                        <th class="w-[5%] px-3 py-2 border border-gray-300">ID</th>
                        <th class="w-[30%] px-3 py-2 border border-gray-300 text-center">Phone</th>
                        <th class="w-[30%] px-3 py-2 border border-gray-300 text-center">Email</th>
                        <th class="w-[25%] px-3 py-2 border border-gray-300 text-center">Timing</th>
                        <th class="w-[5%] px-3 py-2 border border-gray-300 text-center">Edit</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php
                    $total_rows = mysqli_num_rows($fetch);
                    $no = $total_rows;
                    while ($row = mysqli_fetch_array($fetch)) {
                    ?>
                        <tr class="border border-gray-300 hover:bg-purple-50">
                            <td class="px-3 py-2 border border-gray-300"><?php echo $no--; ?></td>
                            <td class="px-3 py-2 border border-gray-300 text-center">
                                <?php echo $row['store_phone']; ?>
                            </td>
                            <td class="px-3 py-2 border border-gray-300 text-center">
                                <?php echo $row['store_email']; ?>
                            </td>
                            <td class="px-3 py-2 border border-gray-300 text-center">
                                <?php echo $row['store_timing']; ?>
                            </td>
                            <td class="px-3 py-2 text-center border border-gray-300">
                                <a href="edit_store_details.php?edt=<?php echo $row['store_id']; ?>" class="text-[#8c49ff] hover:text-[#512DA8]">
                                    <i class="fa-solid fa-pen text-lg"></i>
                                </a>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo "<p class='text-gray-600'>No Details found.</p>";
        } ?>
    </main>

    <?php include('./admin_parts/./footer.php'); ?>
</body>

</html>