<?php
include 'db.php';

// Fetch teacher section data
$query = "SELECT * FROM teacher_section WHERE id=1 LIMIT 1";
$result = mysqli_query($conn, $query);
$teacher = mysqli_fetch_assoc($result);

// Update teacher section
if (isset($_POST['update_teacher'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $teacher['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = "uploads/" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $sql = "UPDATE teacher_section SET title='$title', description='$description', image='$image' WHERE id=1";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Teacher Section Updated'); window.location.href='dashboard.php?page=edit-teacher';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Teacher Section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">✏️ Edit Teacher Section</div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="<?= $teacher['title'] ?>">
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4"><?= $teacher['description'] ?></textarea>
                </div>
                <div class="mb-3">
                    <label>Background Image</label><br>
                    <img src="<?= $teacher['image'] ?>" width="150" class="mb-2"><br>
                    <input type="file" name="image" class="form-control">
                </div>
                <button type="submit" name="update_teacher" class="btn btn-success">💾 Update Teacher Section</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
