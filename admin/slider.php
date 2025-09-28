<?php
include 'file/session.php';
include 'db.php'; 

// -------------------- ADD SLIDE --------------------
if (isset($_POST['add_slide'])) {
    $slide_number = $_POST['slide_number'];
    $heading = $_POST['heading'];
    $paragraph = $_POST['paragraph'];
    $btn1_text = $_POST['btn1_text'];
    $btn1_url = $_POST['btn1_url'];
    $btn2_text = $_POST['btn2_text'];
    $btn2_url = $_POST['btn2_url'];

    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/slider/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $image = $targetDir . time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);
    }

    mysqli_query($conn, "INSERT INTO slider (slide_number, image, heading, paragraph, btn1_text, btn1_url, btn2_text, btn2_url) 
                         VALUES ('$slide_number','$image','$heading','$paragraph','$btn1_text','$btn1_url','$btn2_text','$btn2_url')");
    header("Location: slider.php");
    exit();
}

// -------------------- UPDATE SLIDE --------------------
if (isset($_POST['update_slide'])) {
    $id = $_POST['id'];
    $slide_number = $_POST['slide_number'];
    $heading = $_POST['heading'];
    $paragraph = $_POST['paragraph'];
    $btn1_text = $_POST['btn1_text'];
    $btn1_url = $_POST['btn1_url'];
    $btn2_text = $_POST['btn2_text'];
    $btn2_url = $_POST['btn2_url'];

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/slider/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $image = $targetDir . time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $image);

        $sql = "UPDATE slider SET slide_number='$slide_number', image='$image', heading='$heading', paragraph='$paragraph', 
                btn1_text='$btn1_text', btn1_url='$btn1_url', btn2_text='$btn2_text', btn2_url='$btn2_url' WHERE id=$id";
    } else {
        $sql = "UPDATE slider SET slide_number='$slide_number', heading='$heading', paragraph='$paragraph', 
                btn1_text='$btn1_text', btn1_url='$btn1_url', btn2_text='$btn2_text', btn2_url='$btn2_url' WHERE id=$id";
    }
    mysqli_query($conn, $sql);
    header("Location: slider.php");
    exit();
}

// -------------------- DELETE SLIDE --------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM slider WHERE id=$id");
    header("Location: slider.php");
    exit();
}

// -------------------- FETCH SLIDES --------------------
$result = mysqli_query($conn, "SELECT id, slide_number, image, heading, paragraph, btn1_text, btn1_url, btn2_text, btn2_url FROM slider ORDER BY slide_number ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Slider Management</title>
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
                    <h1 class="mt-4">Slider</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Homepage Slider</li>
                    </ol>

                    <!-- Add Button -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add Slide</button>

                    <!-- Slides Table -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-sliders-h me-1"></i> Slides List</div>
                        <div class="card-body">
                            <table class="table table-bordered align-middle text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Heading</th>
                                        <th>Paragraph</th>
                                        <th>Buttons</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['slide_number']; ?></td>
                                        <td>
                                            <?php if (!empty($row['image'])) { ?>
                                                <img src="<?php echo $row['image']; ?>" style="width:80px; height:50px; object-fit:cover; border-radius:6px;">
                                            <?php } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['heading']); ?></td>
                                        <td><?php echo htmlspecialchars($row['paragraph']); ?></td>
                                        <td>
                                            <?php if (!empty($row['btn1_text'])) { ?>
                                                <a href="<?php echo $row['btn1_url']; ?>" target="_blank" class="btn btn-sm btn-primary mb-1"><?php echo $row['btn1_text']; ?></a>
                                            <?php } ?>
                                            <?php if (!empty($row['btn2_text'])) { ?>
                                                <a href="<?php echo $row['btn2_url']; ?>" target="_blank" class="btn btn-sm btn-success"><?php echo $row['btn2_text']; ?></a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                            <a href="slider.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this slide?')">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Slide</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                        <div class="row g-3">
                                                            <div class="col-md-3">
                                                                <label>Slide Number</label>
                                                                <input type="number" name="slide_number" class="form-control" value="<?php echo $row['slide_number']; ?>" required>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <label>Heading</label>
                                                                <input type="text" name="heading" class="form-control" value="<?php echo htmlspecialchars($row['heading']); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 mt-3">
                                                            <label>Paragraph</label>
                                                            <textarea name="paragraph" class="form-control" required><?php echo htmlspecialchars($row['paragraph']); ?></textarea>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label>Button 1 Text</label>
                                                                <input type="text" name="btn1_text" class="form-control" value="<?php echo $row['btn1_text']; ?>">
                                                                <label class="mt-2">Button 1 URL</label>
                                                                <input type="text" name="btn1_url" class="form-control" value="<?php echo $row['btn1_url']; ?>">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Button 2 Text</label>
                                                                <input type="text" name="btn2_text" class="form-control" value="<?php echo $row['btn2_text']; ?>">
                                                                <label class="mt-2">Button 2 URL</label>
                                                                <input type="text" name="btn2_url" class="form-control" value="<?php echo $row['btn2_url']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 mt-3">
                                                            <label>Image</label><br>
                                                            <?php if (!empty($row['image'])) { ?>
                                                                <img src="<?php echo $row['image']; ?>" style="width:100px; height:60px; object-fit:cover; border-radius:6px; margin-bottom:10px;">
                                                            <?php } ?>
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="update_slide" class="btn btn-success">Update</button>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Slide</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label>Slide Number</label>
                                <input type="number" name="slide_number" class="form-control" required>
                            </div>
                            <div class="col-md-9">
                                <label>Heading</label>
                                <input type="text" name="heading" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label>Paragraph</label>
                            <textarea name="paragraph" class="form-control" required></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Button 1 Text</label>
                                <input type="text" name="btn1_text" class="form-control">
                                <label class="mt-2">Button 1 URL</label>
                                <input type="text" name="btn1_url" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Button 2 Text</label>
                                <input type="text" name="btn2_text" class="form-control">
                                <label class="mt-2">Button 2 URL</label>
                                <input type="text" name="btn2_url" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_slide" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>