<?php
include('check_session.php');
include('../db_con.php');

if (isset($_REQUEST['submit_btn'])) {
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

    $image1 = $_FILES['image1']['name'];
    $tmp1 = $_FILES['image1']['tmp_name'];
    move_uploaded_file($tmp1, "../images/" . $image1);

    $image2 = $_FILES['image2']['name'];
    $tmp2 = $_FILES['image2']['tmp_name'];
    move_uploaded_file($tmp2, "../images/" . $image2);

    $image3 = $_FILES['image3']['name'];
    $tmp3 = $_FILES['image3']['tmp_name'];
    move_uploaded_file($tmp3, "../images/" . $image3);

    $image4 = $_FILES['image4']['name'];
    $tmp4 = $_FILES['image4']['tmp_name'];
    move_uploaded_file($tmp4, "../images/" . $image4);

    $get_category_name = mysqli_query($db, "SELECT category_name FROM category WHERE category_id = '$category_id'");
    $category_row = mysqli_fetch_array($get_category_name);
    $category_name = $category_row['category_name'];

    mysqli_query($db, "INSERT INTO products (name, price, size, category, color, fabric, work, blouse_color, blouse_fabric, blouse_type, dupatta_color, dupatta_fabric, bottom_color, bottom_fabric, bottom_style, product_type, image1, image2, image3, image4) VALUES ('$name','$price','$size_string','$category_name','$color','$fabric','$work','$blouse_color','$blouse_fabric','$blouse_type','$dupatta_color','$dupatta_fabric','$bottom_color','$bottom_fabric','$bottom_style', '$product_type', '$image1','$image2','$image3','$image4')");

    header("Location: products.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Asopalav.in</title>
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

        <h2 class="text-2xl font-semibold text-[#512DA8] mb-4">Add Product : </h2>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-5">

            <div>
                <label for="name" class="block text-sm font-medium text-[#512DA8] mb-1">Product Name</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    placeholder="Product name..." />
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-[#512DA8] mb-1">Price</label>
                <input type="number" id="price" name="price" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                    placeholder="Product price..." />
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
                                class="form-checkbox h-5 w-5 text-[#512DA8] rounded-md focus:ring-2 focus:ring-[#512DA8] transition duration-200">
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
                            <option value="" hidden>-- Select Category --</option>
                            <?php
                            $fetch_category = mysqli_query($db, "SELECT * FROM category");
                            while ($category = mysqli_fetch_array($fetch_category)) {
                            ?>
                                <option value="<?php echo $category['category_id']; ?>">
                                    <?php echo $category['category_name']; ?></option>
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
                                class="form-radio h-4 w-4 text-[#512DA8] focus:ring-2 focus:ring-[#512DA8] accent-[#512DA8]">
                            <span class="ml-2 text-sm text-gray-700">Stitched</span>
                        </label>
                        <label
                            class="inline-flex items-center cursor-pointer border border-gray-300 rounded-md px-4 py-2 focus-within:ring-2 focus-within:ring-[#512DA8] focus-within:border-[#512DA8] transition duration-200">
                            <input type="radio" name="product_type" value="Unstitched"
                                class="form-radio h-4 w-4 text-[#512DA8] focus:ring-2 focus:ring-[#512DA8] accent-[#512DA8]">
                            <span class="ml-2 text-sm text-gray-700">Unstitched</span>
                        </label>
                        <label
                            class="inline-flex items-center cursor-pointer border border-gray-300 rounded-md px-4 py-2 focus-within:ring-2 focus-within:ring-[#512DA8] focus-within:border-[#512DA8] transition duration-200">
                            <input type="radio" name="product_type" value="Not Prefrence"
                                class="form-radio h-4 w-4 text-[#512DA8] focus:ring-2 focus:ring-[#512DA8] accent-[#512DA8]">
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
                        placeholder="Product color..." />
                </div>
                <div>
                    <label for="fabric" class="block text-sm font-medium text-[#512DA8] mb-1">Fabric</label>
                    <input type="text" id="fabric" name="fabric"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Product fabric..." />
                </div>
                <div>
                    <label for="work" class="block text-sm font-medium text-[#512DA8] mb-1">Work</label>
                    <input type="text" id="work" name="work"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Product work..." />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="blouse_color" class="block text-sm font-medium text-[#512DA8] mb-1">Blouse Color</label>
                    <input type="text" id="blouse_color" name="blouse_color"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Blouse color..." />
                </div>
                <div>
                    <label for="blouse_fabric" class="block text-sm font-medium text-[#512DA8] mb-1">Blouse Fabric</label>
                    <input type="text" id="blouse_fabric" name="blouse_fabric"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Blouse fabric..." />
                </div>
                <div>
                    <label for="blouse_type" class="block text-sm font-medium text-[#512DA8] mb-1">Blouse Type</label>
                    <input type="text" id="blouse_type" name="blouse_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Blouse type..." />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="bottom_color" class="block text-sm font-medium text-[#512DA8] mb-1">Bottom Color</label>
                    <input type="text" id="bottom_color" name="bottom_color"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Bottom color..." />
                </div>
                <div>
                    <label for="bottom_fabric" class="block text-sm font-medium text-[#512DA8] mb-1">Bottom Fabric</label>
                    <input type="text" id="bottom_fabric" name="bottom_fabric"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Bottom fabric..." />
                </div>
                <div>
                    <label for="bottom_style" class="block text-sm font-medium text-[#512DA8] mb-1">Bottom Style</label>
                    <input type="text" id="bottom_style" name="bottom_style"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Bottom style..." />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="dupatta_color" class="block text-sm font-medium text-[#512DA8] mb-1">Dupatta Color</label>
                    <input type="text" id="dupatta_color" name="dupatta_color"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Dupatta color..." />
                </div>
                <div>
                    <label for="dupatta_fabric" class="block text-sm font-medium text-[#512DA8] mb-1">Dupatta Fabric</label>
                    <input type="text" id="dupatta_fabric" name="dupatta_fabric"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#512DA8]"
                        placeholder="Dupatta fabric..." />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label for="image1" class="block text-sm font-medium text-[#512DA8] mb-1">Upload Image 1</label>
                    <input type="file" id="image1" name="image1" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-[#ede7f6] file:text-[#512DA8]
                        hover:file:bg-[#d1c4e9] cursor-pointer" required />
                </div>
                <div>
                    <label for="image2" class="block text-sm font-medium text-[#512DA8] mb-1">Upload Image 2</label>
                    <input type="file" id="image2" name="image2" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-[#ede7f6] file:text-[#512DA8]
                        hover:file:bg-[#d1c4e9] cursor-pointer" required />
                </div>
                <div>
                    <label for="image3" class="block text-sm font-medium text-[#512DA8] mb-1">Upload Image 3</label>
                    <input type="file" id="image3" name="image3" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-[#ede7f6] file:text-[#512DA8]
                        hover:file:bg-[#d1c4e9] cursor-pointer" required />
                </div>
                <div>
                    <label for="image4" class="block w-full text-sm font-medium text-[#512DA8] mb-1">Upload Image 4</label>
                    <input type="file" id="image4" name="image4" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0 file:text-sm file:font-semibold
                        file:bg-[#ede7f6] file:text-[#512DA8]
                        hover:file:bg-[#d1c4e9] cursor-pointer" required />
                </div>
            </div>


            <div class="pt-2 text-end">
                <button type="submit" name="submit_btn"
                    class="bg-[#512DA8] hover:bg-[#3c1c99] text-white px-6 py-2 rounded-md transition duration-200">
                    Insert Record
                </button>
            </div>
        </form>
    </main>

    <?php include('./admin_parts/./footer.php'); ?>
</body>

</html>