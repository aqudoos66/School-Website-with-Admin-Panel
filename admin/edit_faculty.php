<?php
include 'db.php';
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Folder path
$uploadDir = "uploads/faculty/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Add new faculty
if (isset($_POST['add_faculty'])) {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $image = "";

    if (!empty($_FILES['image']['name'])) {
        $image = $uploadDir . time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $sql = "INSERT INTO faculty (name, designation, image, facebook, twitter, instagram) 
            VALUES ('$name', '$designation', '$image', '$facebook', '$twitter', '$instagram')";
    mysqli_query($conn, $sql);

    header("Location: index.php?page=edit-faculty");
    exit();
}

// Update faculty
if (isset($_POST['update_faculty'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];

    // Get old image
    $res = mysqli_query($conn, "SELECT image FROM faculty WHERE id=$id");
    $faculty = mysqli_fetch_assoc($res);
    $image = $faculty['image'];

    // Check if new image uploaded
    if (!empty($_FILES['image']['name'])) {
        // Delete old image if exists
        if ($image && file_exists($image)) {
            unlink($image);
        }
        $image = $uploadDir . time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $sql = "UPDATE faculty SET 
            name='$name', 
            designation='$designation', 
            image='$image', 
            facebook='$facebook', 
            twitter='$twitter', 
            instagram='$instagram'
            WHERE id=$id";
    mysqli_query($conn, $sql);

    header("Location: index.php?page=edit-faculty");
    exit();
}

// Delete faculty
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete image file
    $res = mysqli_query($conn, "SELECT image FROM faculty WHERE id=$id");
    $faculty = mysqli_fetch_assoc($res);
    if ($faculty && file_exists($faculty['image'])) {
        unlink($faculty['image']);
    }

    mysqli_query($conn, "DELETE FROM faculty WHERE id=$id");

    header("Location: index.php?page=edit-faculty");
    exit();
}

// Fetch all faculty
$result = mysqli_query($conn, "SELECT * FROM faculty ORDER BY id DESC");

// If editing
$editFaculty = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM faculty WHERE id=$id");
    $editFaculty = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Faculty</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .card-header {
      font-weight: bold;
    }
    table img {
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
</head>
<body>
<div class="container py-4">
    <!-- Add/Edit Faculty Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= $editFaculty ? "✏️ Edit Faculty" : "➕ Add New Faculty" ?>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data" class="row g-3">
                <?php if ($editFaculty) { ?>
                    <input type="hidden" name="id" value="<?= $editFaculty['id'] ?>">
                <?php } ?>
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" 
                           value="<?= $editFaculty ? htmlspecialchars($editFaculty['name']) : "" ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" class="form-control" 
                           value="<?= $editFaculty ? htmlspecialchars($editFaculty['designation']) : "" ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="image" class="form-control" <?= $editFaculty ? "" : "required" ?>>
                    <?php if ($editFaculty && $editFaculty['image']) { ?>
                        <div class="mt-2">
                            <img src="<?= $editFaculty['image'] ?>" width="80" height="80">
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Facebook</label>
                    <input type="url" name="facebook" class="form-control"
                           value="<?= $editFaculty ? htmlspecialchars($editFaculty['facebook']) : "" ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Twitter</label>
                    <input type="url" name="twitter" class="form-control"
                           value="<?= $editFaculty ? htmlspecialchars($editFaculty['twitter']) : "" ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Instagram</label>
                    <input type="url" name="instagram" class="form-control"
                           value="<?= $editFaculty ? htmlspecialchars($editFaculty['instagram']) : "" ?>">
                </div>
                <div class="col-12">
                    <button type="submit" 
                            name="<?= $editFaculty ? "update_faculty" : "add_faculty" ?>" 
                            class="btn btn-<?= $editFaculty ? "warning" : "primary" ?>">
                        <?= $editFaculty ? "Update Faculty" : "Save Faculty" ?>
                    </button>
                    <?php if ($editFaculty) { ?>
                        <a href="index.php?page=edit-faculty" class="btn btn-secondary">Cancel</a>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Manage Faculty Table -->
    <div class="card">
        <div class="card-header bg-success text-white">📋 Manage Faculty</div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Social Links</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><img src="<?= $row['image'] ?>" width="60" height="60"></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['designation']) ?></td>
                        <td>
                            <?php if ($row['facebook']) echo "<a href='{$row['facebook']}' target='_blank'>Facebook</a> "; ?>
                            <?php if ($row['twitter']) echo "<a href='{$row['twitter']}' target='_blank'>Twitter</a> "; ?>
                            <?php if ($row['instagram']) echo "<a href='{$row['instagram']}' target='_blank'>Instagram</a>"; ?>
                        </td>
                        <td>
                            <a href="index.php?page=edit-faculty&edit=<?= $row['id'] ?>" 
                               class="btn btn-warning btn-sm">✏️ Edit</a>
                            <a href="index.php?page=edit-faculty&delete=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Delete this faculty?')">🗑️ Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
