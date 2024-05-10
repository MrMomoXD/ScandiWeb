<?php
$conn = new mysqli("sql108.infinityfree.com", "if0_36515157", "ZUHCV6AK3Kqugq", "if0_36515157_mrmomo_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Assuming you have a database connection established already

// Check if SKU is sent via POST request
if(isset($_POST['sku'])) {
    $sku = $_POST['sku'];

    // Perform SQL query to check if SKU exists in the database
    $sql = "SELECT * FROM items_db WHERE SKU = '$sku'";
    $result = $conn->query($sql);

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // SKU already exists, send "exist" as response
        echo "exist";
    }
} else {
}
