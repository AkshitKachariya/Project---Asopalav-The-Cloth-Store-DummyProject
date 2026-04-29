<?php

include('./db_con.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Locations | Asopalav.in</title>
    <link rel="shortcut icon" href="./images/asopalav favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./src/output.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <style>
        .storeshadow {
            box-shadow: 0px 1px 5px grey;
        }

        .store-link:hover {
            transform: translateY(-5px);
        }

        /* Custom CSS for the hover effect line */
        .location-name-container {
            position: relative;
            display: inline-block;
        }

        .location-name-container::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -5px;
            width: 0;
            height: 2px;
            background-color: currentColor;
            /* Matches text color */
            transition: width 0.3s ease-in-out, left 0.3s ease-in-out;
            transform: translateX(-50%);
        }

        .store-card:hover .location-name-container::after {
            width: 100%;
            left: 50%;
        }
    </style>
</head>

<body>
    <header class="sticky top-0 z-10">
        <?php include('./main_header.php'); ?>
    </header>
    <main class="pt-15 pb-0 lg:px-20 px-10 space-y-4">
        <div class="container mx-auto px-4">
            <div class="text-center text-3xl font-bold uppercase mb-7">Our Store Locations</div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 items-stretch">
                <?php
                $stores_data = mysqli_query($db, "select * from store_location");
                while ($stores = mysqli_fetch_array($stores_data)) {
                ?>
                    <div class="store-card">
                        <div class="flex flex-col h-[400px] rounded-xl overflow-hidden bg-white storeshadow transition-transform duration-300 store-link">
                            <div class="location-image-container relative w-full h-[240px] rounded-t-xl">
                                <img src="./images/<?php echo $stores['location_image']; ?>" alt="<?php echo $stores['location_name']; ?>" class="w-full h-full object-cover rounded-t-xl">
                                <button onclick="showMap(this, '<?php echo $stores['location_link']; ?>')" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white text-gray-800 font-semibold py-2 px-4 rounded-full shadow-lg hover:bg-gray-100 transition-colors duration-200 focus:outline-none">
                                    View on Map
                                </button>
                            </div>
                            <iframe src="" class="hidden w-full h-[240px] rounded-t-xl" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

                            <div class="p-5 text-center">
                                <p class="text-lg font-semibold location-name text-gray-900">
                                    <span class="location-name-container">
                                        <?php echo $stores['location_name']; ?>
                                    </span>
                                </p>
                                <p class="text-sm text-gray-600 mt-2"><?php echo $stores['location_address']; ?></p>
                            </div>
                            <div class="pb-2 text-center mt-auto">
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-phone"></i>&nbsp;
                                    +91 <?php echo $stores['location_phone']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </main>
    <footer class="my-10 lg:mb-0">
        <?php include('main_footer.php'); ?>
    </footer>
    <script>
        function showMap(button, mapUrl) {
            const card = button.closest('.store-card');
            const imageContainer = card.querySelector('.location-image-container');
            const iframe = card.querySelector('iframe');

            iframe.src = mapUrl;
            iframe.classList.remove('hidden');

            imageContainer.classList.add('hidden');
        }
    </script>
</body>

</html>