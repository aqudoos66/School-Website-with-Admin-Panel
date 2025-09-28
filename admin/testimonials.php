<?php
include 'file/session.php';
include 'db.php'; 

// -------------------- ADD TESTIMONIAL --------------------
if (isset($_POST['add_testimonial'])) {
    $client_name = $_POST['client_name'];
    $profession = $_POST['profession'];
    $comment = $_POST['comment'];

    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/testimonials/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $image = $targetDir . time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    mysqli_query($conn, "INSERT INTO testimonials (client_name, profession, comment, image) 
                         VALUES ('$client_name','$profession','$comment','$image')");
    header("Location: testimonials.php");
    exit();
}

// -------------------- UPDATE TESTIMONIAL --------------------
if (isset($_POST['update_testimonial'])) {
    $id = $_POST['id'];
    $client_name = $_POST['client_name'];
    $profession = $_POST['profession'];
    $comment = $_POST['comment'];

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/testimonials/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $image = $targetDir . time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);

        $sql = "UPDATE testimonials SET client_name='$client_name', profession='$profession', comment='$comment', image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE testimonials SET client_name='$client_name', profession='$profession', comment='$comment' WHERE id=$id";
    }
    mysqli_query($conn, $sql);
    header("Location: testimonials.php");
    exit();
}

// -------------------- DELETE TESTIMONIAL --------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM testimonials WHERE id=$id");
    header("Location: testimonials.php");
    exit();
}

// -------------------- FETCH TESTIMONIALS --------------------
$result = mysqli_query($conn, "SELECT id, client_name, profession, comment, image FROM testimonials ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Testimonials Management</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
    <?php include 'file/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php include 'file/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Testimonials</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Testimonials</li>
                    </ol>

                    <!-- Add Button -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add Testimonial</button>

                    <!-- Testimonials Table -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-users me-1"></i> Testimonials List</div>
                        <div class="card-body">
                            <table class="table table-bordered align-middle text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Client Name</th>
                                        <th>Profession</th>
                                        <th>Comment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($row['image'])) { ?>
                                                <img src="<?php echo $row['image']; ?>" style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                                            <?php } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['profession']); ?></td>
                                        <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                            <a href="testimonials.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this testimonial?')">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Testimonial</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                        <div class="mb-3">
                                                            <label>Client Name</label>
                                                            <input type="text" name="client_name" class="form-control" value="<?php echo htmlspecialchars($row['client_name']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Profession</label>
                                                            <input type="text" name="profession" class="form-control" value="<?php echo htmlspecialchars($row['profession']); ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Comment</label>
                                                            <textarea name="comment" class="form-control" required><?php echo htmlspecialchars($row['comment']); ?></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Image</label><br>
                                                            <?php if (!empty($row['image'])) { ?>
                                                                <img src="<?php echo $row['image']; ?>" style="width:80px; height:80px; object-fit:cover; border-radius:50%; margin-bottom:10px;">
                                                            <?php } ?>
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="update_testimonial" class="btn btn-success">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">© School Website 2025</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Testimonial</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Client Name</label>
                            <input type="text" name="client_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Profession</label>
                            <input type="text" name="profession" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Comment</label>
                            <textarea name="comment" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_testimonial" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>