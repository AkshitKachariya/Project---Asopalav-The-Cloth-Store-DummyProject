<?php
include('check_session.php');
include('../db_con.php');

$fetch = mysqli_query($db, "SELECT * FROM products ORDER BY product_id DESC");

if (isset($_REQUEST['del'])) {
    $id = $_REQUEST['del'];
    $folder = mysqli_query($db, "SELECT * FROM products WHERE product_id = $id");
    $product_images = mysqli_fetch_array($folder);
    unlink("../images/" . $product_images['image1']);
    unlink("../images/" . $product_images['image2']);
    unlink("../images/" . $product_images['image3']);
    unlink("../images/" . $product_images['image4']);

    mysqli_query($db, "DELETE FROM products WHERE product_id = $id");
    header("Location: products.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Asopalav.in</title>
    <link rel="shortcut icon" href="../images/asopalav favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../src/output.css">
</head>

<body>
    <?php include('./admin_parts/./header.php'); ?>
    <?php include('./admin_parts/./sidebar.php'); ?>

    <main class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-[#ae8dfc3b] via-purple-50 to-[#ae8dfc36]">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-[#512DA8]">Products : </h2>
            <h2 class="text-4xl font-semibold text-[#512DA8]">
                <a href="./add_products.php"
                    class="transition-transform duration-200 hover:scale-110">
                    <i class="fas fa-plus-square"></i>
                </a>
            </h2>
        </div>

        <?php
        if (mysqli_num_rows($fetch) > 0) {
        ?>
            <div class="overflow-x-auto rounded-lg shadow-md">
                <table class="min-w-full table-auto border border-gray-300 text-left text-sm text-gray-700">
                    <thead class="bg-[#c7a8f57e] text-[#512DA8] uppercase font-semibold tracking-wider">
                        <tr>
                            <th class="px-3 py-2 border border-gray-300 w-1/17">No.</th>
                            <th class="px-3 py-2 border border-gray-300 w-5/17">Images</th>
                            <th class="px-3 py-2 border border-gray-300 w-3/17">Product Name</th>
                            <th class="px-3 py-2 border border-gray-300 w-3/17">Details</th>
                            <th class="px-3 py-2 border border-gray-300 w-3/17">Styles</th>
                            <th class="px-3 py-2 border border-gray-300 w-1/17 text-center">Edit</th>
                            <th class="px-3 py-2 border border-gray-300 w-1/17 text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <?php
                        $total_rows = mysqli_num_rows($fetch);
                        $no = $total_rows;
                        while ($row = mysqli_fetch_array($fetch)) { ?>
                            <tr class="border-b border-gray-300 hover:bg-purple-50">
                                <td class="px-3 py-2 border-r border-gray-300"><?php echo $no--; ?></td>
                                <td class="px-3 py-2 border-r border-gray-300">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <img src="../images/<?php echo $row['image1']; ?>" alt="image1" class="h-24 object-contain rounded shadow border border-gray-300" />
                                        <img src="../images/<?php echo $row['image2']; ?>" alt="image2" class="h-24 object-contain rounded shadow border border-gray-300" />
                                        <img src="../images/<?php echo $row['image3']; ?>" alt="image3" class="h-24 object-contain rounded shadow border border-gray-300" />
                                        <img src="../images/<?php echo $row['image4']; ?>" alt="image4" class="h-24 object-contain rounded shadow border border-gray-300" />
                                    </div>
                                </td>
                                <td class="px-3 py-2 border-r border-gray-300 text-sm"><?php echo $row['name']; ?></td>
                                <td class="px-3 py-2 border-r border-gray-300 text-sm">
                                    <div class="space-y-1">
                                        <p><strong>Price : </strong> ₹<?php echo number_format($row['price']); ?>/- </p>
                                        <p><strong>Size : </strong> <?php echo $row['size']; ?></p>
                                        <p><strong>Category : </strong> <?php echo $row['category']; ?></p>
                                        <p><strong>Color : </strong> <?php echo $row['color']; ?></p>
                                        <p><strong>Fabric : </strong> <?php echo $row['fabric']; ?></p>
                                        <p><strong>Work : </strong> <?php echo $row['work']; ?></p>
                                        <p><strong>Product Type : </strong> <?php echo $row['product_type']; ?></p>
                                    </div>
                                </td>
                                <td class="px-3 py-2 border-r border-gray-300 text-sm">
                                    <div class="space-y-1">
                                        <p><strong>Blouse Color : </strong> <?php echo $row['blouse_color']; ?></p>
                                        <p><strong>Blouse Fabric : </strong> <?php echo $row['blouse_fabric']; ?></p>
                                        <p><strong>Blouse Type : </strong> <?php echo $row['blouse_type']; ?></p>
                                        <p><strong>Dupatta Color : </strong> <?php echo $row['dupatta_color']; ?></p>
                                        <p><strong>Dupatta Fabric : </strong> <?php echo $row['dupatta_fabric']; ?></p>
                                        <p><strong>Bottom Color : </strong> <?php echo $row['bottom_color']; ?></p>
                                        <p><strong>Bottom Fabric : </strong> <?php echo $row['bottom_fabric']; ?></p>
                                        <p><strong>Bottom Style : </strong> <?php echo $row['bottom_style']; ?></p>
                                    </div>
                                </td>
                                <td class="px-3 py-2 text-center border-r border-gray-300">
                                    <a href="edit_products.php?edt=<?php echo $row['product_id']; ?>"
                                        class="text-[#8c49ff] hover:text-[#512DA8] transition-colors duration-200">
                                        <i class="fa-solid fa-pen text-lg"></i>
                                    </a>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <a href="products.php?del=<?php echo $row['product_id']; ?>"
                                        onclick="return confirm('Delete this product?')"
                                        class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                        <i class="fa-solid fa-trash text-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo "<p class='text-gray-600 text-center mt-8'>No products found.</p>";
        }
        ?>
    </main>

    <?php include('./admin_parts/./footer.php'); ?>
</body>

</html>