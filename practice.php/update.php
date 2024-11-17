<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "product_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM products WHERE id=$id");
    $product = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update product
    $name = $_POST['name'];
    $details = $_POST['details'];
    $price = $_POST['price'];

    $sql = "UPDATE products SET name='$name', details='$details', price='$price' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: process.php"); // Redirect back to the main page
    } else {
        echo "Error updating product: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Update Product</h1>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Product Name" value="<?php echo $product['name']; ?>" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="details" placeholder="Product Details" required><?php echo $product['details']; ?></textarea>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="price" placeholder="Price" value="<?php echo $product['price']; ?>" required>
            </div>
            
            <button type="submit"  class="btn btn-success">Update</button>
            <a href="process.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>