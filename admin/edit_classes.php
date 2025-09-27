<?php
include 'db.php'; // DB connection
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


// Uploads folder
$uploadDir = "UPLOADS/classes/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// --- Handle Add / Update ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $age_range = mysqli_real_escape_string($conn, $_POST['age_range']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);

    // Image handling
    $teacher_image_path = $_POST['existing_teacher_image'] ?? '';
    $class_image_path = $_POST['existing_class_image'] ?? '';

    if (!empty($_FILES['teacher_image']['name']) && $_FILES['teacher_image']['error'] == 0) {
        $newTeacherImgPath = $uploadDir . time() . "_teacher_" . basename($_FILES['teacher_image']['name']);
        if (move_uploaded_file($_FILES['teacher_image']['tmp_name'], $newTeacherImgPath)) {
            $teacher_image_path = $newTeacherImgPath;
        }
    }

    if (!empty($_FILES['class_image']['name']) && $_FILES['class_image']['error'] == 0) {
        $newClassImgPath = $uploadDir . time() . "_class_" . basename($_FILES['class_image']['name']);
        if (move_uploaded_file($_FILES['class_image']['tmp_name'], $newClassImgPath)) {
            $class_image_path = $newClassImgPath;
        }
    }

    if ($id) {
        // Update record
        $stmt = $conn->prepare("UPDATE classes SET title=?, teacher_name=?, teacher_image=?, price=?, age_range=?, time=?, capacity=?, class_image=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $title, $teacher_name, $teacher_image_path, $price, $age_range, $time, $capacity, $class_image_path, $id);
    } else {
        // Insert new
        $stmt = $conn->prepare("INSERT INTO classes (title, teacher_name, teacher_image, price, age_range, time, capacity, class_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $title, $teacher_name, $teacher_image_path, $price, $age_range, $time, $capacity, $class_image_path);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: index.php?page=edit_classes");
    exit();
}

// --- Handle Delete ---
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM classes WHERE id = $delete_id");
    header("Location: index.php?page=edit_classes");
    exit();
}

// --- Handle Edit (fetch specific record) ---
$editClass = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $res = $conn->query("SELECT * FROM classes WHERE id = $edit_id");
    if ($res->num_rows > 0) {
        $editClass = $res->fetch_assoc();
    }
}

// --- Fetch All Classes ---
$result = $conn->query("SELECT * FROM classes ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-preview {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">

    <!-- Add / Edit Form -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $editClass ? "✏️ Edit Class" : "➕ Add New Class" ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="edit_classes.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $editClass['id'] ?? '' ?>">
                <input type="hidden" name="existing_teacher_image" value="<?= htmlspecialchars($editClass['teacher_image'] ?? '') ?>">
                <input type="hidden" name="existing_class_image" value="<?= htmlspecialchars($editClass['class_image'] ?? '') ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Class Title:</label>
                        <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editClass['title'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teacher Name:</label>
                        <input type="text" name="teacher_name" class="form-control" required value="<?= htmlspecialchars($editClass['teacher_name'] ?? '') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teacher Image:</label>
                        <?php if (!empty($editClass['teacher_image'])): ?>
                            <div><img src="<?= htmlspecialchars($editClass['teacher_image']) ?>" alt="Teacher" class="img-thumbnail img-preview"></div>
                        <?php endif; ?>
                        <input type="file" name="teacher_image" class="form-control mt-2">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Class Image:</label>
                        <?php if (!empty($editClass['class_image'])): ?>
                            <div><img src="<?= htmlspecialchars($editClass['class_image']) ?>" alt="Class" class="img-thumbnail img-preview"></div>
                        <?php endif; ?>
                        <input type="file" name="class_image" class="form-control mt-2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Price:</label>
                        <input type="text" name="price" class="form-control" required value="<?= htmlspecialchars($editClass['price'] ?? '') ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Age Range:</label>
                        <input type="text" name="age_range" class="form-control" required value="<?= htmlspecialchars($editClass['age_range'] ?? '') ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Time:</label>
                        <input type="text" name="time" class="form-control" required value="<?= htmlspecialchars($editClass['time'] ?? '') ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Capacity:</label>
                        <input type="text" name="capacity" class="form-control" required value="<?= htmlspecialchars($editClass['capacity'] ?? '') ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><?= $editClass ? "Update Class" : "Add Class" ?></button>
                <?php if ($editClass): ?>
                    <a href="index.php?page=edit_classes" class="btn btn-secondary">Cancel Edit</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Classes List -->
    <div class="card shadow-sm mt-5">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">🏫 All Classes</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Class</th>
                            <th>Teacher</th>
                            <th>Price</th>
                            <th>Age</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                            <td><?= htmlspecialchars($row['price']) ?></td>
                            <td><?= htmlspecialchars($row['age_range']) ?></td>
                            <td><?= htmlspecialchars($row['time']) ?></td>
                            <td>
                                <a href="edit_classes.php?page=edit_classes&edit_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="edit_classes.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this class?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>
