<?php
error_reporting(0);
include('./db_con.php');
header('Content-Type: application/json');

if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($db, $_GET['query']);

    $sql = "SELECT * FROM products 
            WHERE name LIKE '%$query%' COLLATE utf8mb4_general_ci
            LIMIT 10";

    $result = mysqli_query($db, $sql);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = [
            'id' => $row['product_id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => $row['image1']
        ];
    }

    echo json_encode($products);
} else {
    echo json_encode([]);
}
