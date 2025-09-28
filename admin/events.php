<?php
include 'file/session.php';
include 'db.php'; 

// -------------------- UPDATE EVENT --------------------
if (isset($_POST['update_event'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/events/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $image = $targetDir . time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);

        $sql = "UPDATE teacher_section SET title='$title', description='$description', image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE teacher_section SET title='$title', description='$description' WHERE id=$id";
    }

    mysqli_query($conn, $sql);
    header("Location: events.php");
    exit();
}

// -------------------- FETCH SINGLE EVENT --------------------
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM teacher_section LIMIT 1"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Events Management</title>
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
                    <h1 class="mt-4">Events / News</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Event</li>
                    </ol>

                    <!-- Event Card -->
                    <div class="card mb-4">
                        <div class="row g-0">
                            <div class="col-md-4 text-center p-3">
                                <?php if (!empty($row['image'])) { ?>
                                    <img src="<?php echo $row['image']; ?>" class="img-fluid rounded-circle" style="width:150px; height:150px; object-fit:cover;">
                                <?php } else { ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle" style="width:150px; height:150px;">
                                        <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $row['title']; ?></h4>
                                    <p class="card-text"><?php echo $row['description']; ?></p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Event</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control" value="<?php echo $row['title']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" required><?php echo $row['description']; ?></textarea>
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
                                        <button type="submit" name="update_event" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>