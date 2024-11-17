
<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "product_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete product
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to process.php after deletion
        header("Location: process.php");
        exit();
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}

$conn->close();
?>