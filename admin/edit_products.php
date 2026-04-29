<?php
include('check_session.php');
include('../db_con.php');

// Fetch existing product data
if (isset($_REQUEST['edt'])) {
    $id = $_REQUEST['edt'];
    $fetch_data = mysqli_query($db, "SELECT * FROM products WHERE product_id = $id");
    $product_data = mysqli_fetch_array($fetch_data);
    $existing_sizes = explode(', ', $product_data['size']);
}

if (isset($_REQUEST['update_btn'])) {
    $id = $_REQUEST['id'];
    $name = $_REQUEST['name'];
    $price = $_REQUEST['price'];
    $selected_sizes = isset($_REQUEST['sizes']) ? $_REQUEST['sizes'] : [];
    $size_string = implode(', ', $selected_sizes);
    $category_id = $_REQUEST['category_id'];
    $color = $_REQUEST['color'];
    $fabric = $_REQUEST['fabric'];
    $work = $_REQUEST['work'];
    $blouse_color = $_REQUEST['blouse_color'];
    $blouse_fabric = $_REQUEST['blouse_fabric'];
    $blouse_type = $_REQUEST['blouse_type'];
    $dupatta_color = $_REQUEST['dupatta_color'];
    $dupatta_fabric = $_REQUEST['dupatta_fabric'];
    $bottom_color = $_REQUEST['bottom_color'];
    $bottom_fabric = $_REQUEST['bottom_fabric'];
    $bottom_style = $_REQUEST['bottom_style'];
    $product_type = $_REQUEST['product_type'];

    $get_existing_images = mysqli_query($db, "SELECT image1, image2, image3, image4 FROM products WHERE product_id = $id");
    $existing_images_row = mysqli_fetch_array($get_existing_images);

    // Handle image updates
    $image1 = $_FILES['image1']['name'] != '' ? $_FILES['image1']['name'] : $existing_images_row['image1'];
    $tmp1 = $_FILES['image1']['tmp_name'];
    if ($_FILES['image1']['name'] != '') {
        unlink("../images/" . $existing_images_row['image1']);
        move_uploaded_file($tmp1, "../images/" . $image1);
    }

    $image2 = $_FILES['image2']['name'] != '' ? $_FILES['image2']['name'] : $existing_images_row['image2'];
    $tmp2 = $_FILES['image2']['tmp_name'];
    if ($_FILES['image2']['name'] != '') {
        unlink("../images/" . $existing_images_row['image2']);
        move_uploaded_file($tmp2, "../images/" . $image2);
    }

    $image3 = $_FILES['image3']['name'] != '' ? $_FILES['image3']['name'] : $existing_images_row['image3'];
    $tmp3 = $_FILES['image3']['tmp_name'];
    if ($_FILES['image3']['name'] != '') {
        unlink("../images/" . $existing_images_row['image3']);
        move_uploaded_file($tmp3, "../images/" . $image3);
    }

    $image4 = $_FILES['image4']['name'] != '' ? $_FILES['image4']['name'] : $existing_images_row['image4'];
    $tmp4 = $_FILES['image4']['tmp_name'];
    if ($_FILES['image4']['name'] != '') {
        unlink("../images/" . $existing_images_row['image4']);
        move_uploaded_file($tmp4, "../images/" . $image4);
    }

    // Get category name
    $get_category_name = mysqli_query($db, "SELECT category_name FROM category WHERE category_id = '$category_id'");
    $category_row = mysqli_fetch_array($get_category_name);
    $category_name = $category_row['category_name'];

    // Update the product record
    $update_query = "UPDATE products SET name='$name', price='$price', size='$size_string', category='$category_name', color='$color', fabric='$fabric', work='$work', blouse_color='$blouse_color', blouse_fabric='$blouse_fabric', blouse_type='$blouse_type', dupatta_color='$dupatta_color', dupatta_fabric='$dupatta_fabric', bottom_color='$bottom_color', bottom_fabric='$bottom_fabric', bottom_style='$bottom_style', product_type='$product_type', image1='$image1', image2='$image2', image3='$image3', image4='$image4' WHERE product_id = $id";
    mysqli_query($db, $update_query);

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product | Asopalav.in</title>
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

        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Edit Product : </h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">
            <input type="hidden" name="id" value="<?php echo $product_data['product_id']; ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-[#512DA8] mb-1">Product Name</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    placeholder="Product name..." value="<?php echo $product_data['name']; ?>" />
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-[#512DA8] mb-1">Price</label>
                <input type="number" id="price" name="price" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    placeholder="Product price..." value="<?php echo $product_data['price']; ?>" />
            </div>

            <div>
                <label class="block text-sm font-medium text-[#512DA8] mb-2">Sizes</label>
                <div class="flex flex-wrap gap-4">
                    <?php
                    $fetch_sizes = mysqli_query($db, "SELECT * FROM sizes");
                    while ($size = mysqli_fetch_array($fetch_sizes)) {
                    ?>
                        <label
                            class="inline-flex items-center cursor-pointer border border-gray-300 rounded-md px-4 py-2 focus-within:ring-2 focus-within:ring-[#512DA8] focus-within:border-[#512DA8] transition duration-200">
                            <input type="checkbox" name="sizes[]" value="<?php echo $size['size_number']; ?>"
                                class="form-checkbox h-5 w-5 text-[#512DA8] rounded-md focus:ring-2 focus:ring-[#512DA8] transition duration-200"
                                <?php echo in_array($size['size_number'], $existing_sizes) ? 'checked' : ''; ?>>
                            <span class="ml-2 text-sm text-gray-700"><?php echo $size['size_number']; ?></span>
                        </label>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="category" class="block text-sm font-medium text-[#512DA8] mb-1">Category</label>
                    <div class="relative">
                        <select name="category_id" id="category" required
                            class="w-full appearance-none px-4 py-2 pr-8 border border-gray-300 rounded-md bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#512DA8] transition duration-200 cursor-pointer">
                            <?php
                            $fetch_category = mysqli_query($db, "SELECT * FROM category");
                            while ($category = mysqli_fetch_array($fetch_category)) {
                            ?>
                                <option value="<?php echo $category['category_id']; ?>"
                                    <?php echo ($category['category_name'] == $product_data['category']) ? 'selected' : ''; ?>>
                                    <?php echo $category['category_name']; ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#512DA8] mb-1">Product Type</label>
                    <div class="flex flex-wrap gap-4">
                        <label
                            class="inline-flex items-center cursor-pointer border border-gray-300 rounded-md px-4 py-2 focus-within:ring-2 focus-within:ring-[#512DA8] focus-within:border-[#512DA8] transition duration-200">
                            <input type="radio" name="product_type" value="Stitched"
                                class="form-radio h-4 w-4 text-[#512DA8] focus:ring-2 focus:ring-[#512DA8] accent-[#512DA8]"
                                <?php echo ($product_data['product_type'] == 'Stitched') ? 'checked' : ''; ?>>
                            <span class="ml-2 text-sm text-gray-700">Stitched</span>
                        </label>
                        <label
                            class="inline-flex items-center cursor-pointer border border-gray-300 rounded-md px-4 py-2 focus-within:ring-2 focus-within:ring-[#512DA8] focus-within:border-[#512DA8] transition duration-200">
                            <input type="radio" name="product_type" value="Unstitched"
                                class="form-radio h-4 w-4 text-[#512DA8] focus:ring-2 focus:ring-[#512DA8] accent-[#512DA8]"
                                <?php echo ($product_data['product_type'] == 'Unstitched') ? 'checked' : ''; ?>>
                            <span class="ml-2 text-sm text-gray-700">Unstitched</span>
                        </label>
                        <label
                            class="inline-flex items-center cursor-pointer border border-gray-300 rounded-md px-4 py-2 focus-within:ring-2 focus-within:ring-[#512DA8] focus-within:border-[#512DA8] transition duration-200">
                            <input type="radio" name="product_type" value="Not Prefrence"
                                class="form-radio h-4 w-4 text-[#512DA8] focus:ring-2 focus:ring-[#512DA8] accent-[#512DA8]"
                                <?php echo ($product_data['product_type'] == 'Not Prefrence') ? 'checked' : ''; ?>>
                            <span class="ml-2 text-sm text-gray-700">Not Prefrence</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="color" class="block text-sm font-medium text-[#512DA8] mb-1">Color</label>
                    <input type="text" id="color" name="color"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Product color..." value="<?php echo $product_data['color']; ?>" />
                </div>
                <div>
                    <label for="fabric" class="block text-sm font-medium text-[#512DA8] mb-1">Fabric</label>
                    <input type="text" id="fabric" name="fabric"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Product fabric..." value="<?php echo $product_data['fabric']; ?>" />
                </div>
                <div>
                    <label for="work" class="block text-sm font-medium text-[#512DA8] mb-1">Work</label>
                    <input type="text" id="work" name="work"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Product work..." value="<?php echo $product_data['work']; ?>" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="blouse_color" class="block text-sm font-medium text-[#512DA8] mb-1">Blouse Color</label>
                    <input type="text" id="blouse_color" name="blouse_color"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Blouse color..." value="<?php echo $product_data['blouse_color']; ?>" />
                </div>
                <div>
                    <label for="blouse_fabric" class="block text-sm font-medium text-[#512DA8] mb-1">Blouse Fabric</label>
                    <input type="text" id="blouse_fabric" name="blouse_fabric"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Blouse fabric..." value="<?php echo $product_data['blouse_fabric']; ?>" />
                </div>
                <div>
                    <label for="blouse_type" class="block text-sm font-medium text-[#512DA8] mb-1">Blouse Type</label>
                    <input type="text" id="blouse_type" name="blouse_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Blouse type..." value="<?php echo $product_data['blouse_type']; ?>" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="bottom_color" class="block text-sm font-medium text-[#512DA8] mb-1">Bottom Color</label>
                    <input type="text" id="bottom_color" name="bottom_color"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Bottom color..." value="<?php echo $product_data['bottom_color']; ?>" />
                </div>
                <div>
                    <label for="bottom_fabric" class="block text-sm font-medium text-[#512DA8] mb-1">Bottom Fabric</label>
                    <input type="text" id="bottom_fabric" name="bottom_fabric"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Bottom fabric..." value="<?php echo $product_data['bottom_fabric']; ?>" />
                </div>
                <div>
                    <label for="bottom_style" class="block text-sm font-medium text-[#512DA8] mb-1">Bottom Style</label>
                    <input type="text" id="bottom_style" name="bottom_style"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Bottom style..." value="<?php echo $product_data['bottom_style']; ?>" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="dupatta_color" class="block text-sm font-medium text-[#512DA8] mb-1">Dupatta Color</label>
                    <input type="text" id="dupatta_color" name="dupatta_color"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Dupatta color..." value="<?php echo $product_data['dupatta_color']; ?>" />
                </div>
                <div>
                    <label for="dupatta_fabric" class="block text-sm font-medium text-[#512DA8] mb-1">Dupatta Fabric</label>
                    <input type="text" id="dupatta_fabric" name="dupatta_fabric"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Dupatta fabric..." value="<?php echo $product_data['dupatta_fabric']; ?>" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label for="image1" class="block text-sm font-medium text-[#512DA8] mb-1">Upload New Image 1</label>
                    <input type="file" id="image1" name="image1" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-[#ede7f6] file:text-[#512DA8]
                        hover:file:bg-[#d1c4e9] cursor-pointer" />
                </div>
                <div>
                    <label for="image2" class="block text-sm font-medium text-[#512DA8] mb-1">Upload New Image 2</label>
                    <input type="file" id="image2" name="image2" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-[#ede7f6] file:text-[#512DA8]
                        hover:file:bg-[#d1c4e9] cursor-pointer" />
                </div>
                <div>
                    <label for="image3" class="block text-sm font-medium text-[#512DA8] mb-1">Upload New Image 3</label>
                    <input type="file" id="image3" name="image3" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-[#ede7f6] file:text-[#512DA8]
                        hover:file:bg-[#d1c4e9] cursor-pointer" />
                </div>
                <div>
                    <label for="image4" class="block w-full text-sm font-medium text-[#512DA8] mb-1">Upload New Image 4</label>
                    <input type="file" id="image4" name="image4" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-[#ede7f6] file:text-[#512DA8]
                        hover:file:bg-[#d1c4e9] cursor-pointer" />
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5 items-start justify-start">
                <div class="flex flex-col items-center justify-start">
                    <label class="block text-sm font-medium text-gray-700">Current Image 1</label>
                    <img src="../images/<?php echo $product_data['image1']; ?>" alt="Image 1"
                        class="h-24 w-24 object-contain rounded-md shadow mt-2" />
                </div>
                <div class="flex flex-col items-center justify-start">
                    <label class="block text-sm font-medium text-gray-700">Current Image 2</label>
                    <img src="../images/<?php echo $product_data['image2']; ?>" alt="Image 2"
                        class="h-24 w-24 object-contain rounded-md shadow mt-2" />
                </div>
                <div class="flex flex-col items-center justify-start">
                    <label class="block text-sm font-medium text-gray-700">Current Image 3</label>
                    <img src="../images/<?php echo $product_data['image3']; ?>" alt="Image 3"
                        class="h-24 w-24 object-contain rounded-md shadow mt-2" />
                </div>
                <div class="flex flex-col items-center justify-start">
                    <label class="block text-sm font-medium text-gray-700">Current Image 4</label>
                    <img src="../images/<?php echo $product_data['image4']; ?>" alt="Image 4"
                        class="h-24 w-24 object-contain rounded-md shadow mt-2" />
                </div>
            </div>

            <div class="pt-2 text-end">
                <button type="submit" name="update_btn"
                    class="bg-[#512DA8] hover:bg-[#3c1c99] text-white px-6 py-2 rounded-md transition duration-200">
                    Update Record
                </button>
            </div>
        </form>
    </main>

    <?php include('./admin_parts/./footer.php'); ?>
</body>

</html>