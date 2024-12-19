<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$item = $conn->query("SELECT * FROM items WHERE id=$id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $file_path = $_POST['existing_file'];

    if (!empty($_FILES['file']['name'])) {
        $file_name = basename($_FILES['file']['name']);
        $file_path = 'uploads/' . $file_name;
        move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
    }

    $sql = "UPDATE items SET name='$name', description='$description', file_path='$file_path' WHERE id=$id";
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
    <title>CRUD Operation - Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Item</h2>

        <div class="card mt-4">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter item name" value="<?php echo $item['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter description"><?php echo $item['description']; ?></textarea>
                    </div>
                    <input type="hidden" name="existing_file" value="<?php echo $item['file_path']; ?>">
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
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
