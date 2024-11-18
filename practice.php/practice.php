<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "product_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $details = $_POST['details'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (name, details, price) VALUES ('$name', '$details', $price)";

    if ($conn->query($sql) === TRUE) {
        header("Location: process.php?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }

        #formContainer {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .custom-table th, .custom-table td {
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        .custom-table thead {
            background-color: #007BFF;
            color: white;
        }

        .custom-table tbody tr {
            background-color: #ffffff;
            transition: background-color 0.3s;
        }

        .custom-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container">
        <h1 class="mb-4">Product Management</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Product added successfully!</div>
        <?php endif; ?>

        <button class="btn btn-primary mb-3" id="openFormBtn">Add Product</button>

        <div id="formContainer" style="display:none;">
            <h2 class="mt-4">Add Product</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="details">Product Details</label>
                    <textarea class="form-control" id="details" name="details" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch products
                $result = $conn->query("SELECT * FROM products");
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['id']."</td>
                                <td>".$row['name']."</td>
                                <td>".$row['details']."</td>
                                <td>".$row['price']."</td>
                                <td>
                                    <a href='update.php?id=".$row['id']."' class='btn btn-warning'>Update</a>
                                    <a href='delete.php?id=".$row['id']."' class='btn btn-danger'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No products found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById("openFormBtn").onclick = function() {
            var formContainer = document.getElementById("formContainer");
            formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
        };
    </script>
</body>
</html>
hccj