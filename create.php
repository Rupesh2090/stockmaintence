<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $file_path = '';

    if (!empty($_FILES['file']['name'])) {
        $file_name = basename($_FILES['file']['name']);
        $file_path = 'uploads/' . $file_name;
        move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
    }

    $sql = "INSERT INTO items (name, description, file_path) VALUES ('$name', '$description', '$file_path')";
    $conn->query($sql);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operation - Create Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Item</h2>

        <div class="card mt-4">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter item name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>

        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Items</a>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
