<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// -------------------- UPDATE ABOUT US SECTION --------------------
if (isset($_POST['update_about'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description1 = $_POST['description1'];
    $description2 = $_POST['description2'];
    $button_text = $_POST['button_text'];

    // Handle Images
    $uploadDir = "uploads/about_us/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fields = [];
    if (!empty($_FILES['img1']['name'])) {
        $img1 = $uploadDir . time() . "_img1_" . basename($_FILES["img1"]["name"]);
        move_uploaded_file($_FILES["img1"]["tmp_name"], $img1);
        $fields[] = "img1='$img1'";
    }
    if (!empty($_FILES['img2']['name'])) {
        $img2 = $uploadDir . time() . "_img2_" . basename($_FILES["img2"]["name"]);
        move_uploaded_file($_FILES["img2"]["tmp_name"], $img2);
        $fields[] = "img2='$img2'";
    }
    if (!empty($_FILES['img3']['name'])) {
        $img3 = $uploadDir . time() . "_img3_" . basename($_FILES["img3"]["name"]);
        move_uploaded_file($_FILES["img3"]["tmp_name"], $img3);
        $fields[] = "img3='$img3'";
    }

    $sql = "UPDATE about_us SET 
                title='$title', 
                description1='$description1', 
                description2='$description2', 
                button_text='$button_text'";

    if (!empty($fields)) {
        $sql .= ", " . implode(", ", $fields);
    }

    $sql .= " WHERE id=$id";

    mysqli_query($conn, $sql);
    header("Location: aboutus.php");
    exit();
}

// -------------------- FETCH ABOUT US DATA --------------------
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM about_us LIMIT 1"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>About Us Management</title>
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
                    <h1 class="mt-4">About Us Section</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage About Us Section</li>
                    </ol>

                    <div class="card">
                        <div class="card-header">Update About Us Section</div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                                <div class="mb-3">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $data['title']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Description 1</label>
                                    <textarea name="description1" class="form-control" required><?php echo $data['description1']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Description 2</label>
                                    <textarea name="description2" class="form-control" required><?php echo $data['description2']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Button Text</label>
                                    <input type="text" name="button_text" class="form-control" value="<?php echo $data['button_text']; ?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Image 1</label><br>
                                        <?php if (!empty($data['img1'])) { ?>
                                            <img src="<?php echo $data['img1']; ?>" style="width:80px; height:80px; object-fit:cover; margin-bottom:10px;">
                                        <?php } ?>
                                        <input type="file" name="img1" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Image 2</label><br>
                                        <?php if (!empty($data['img2'])) { ?>
                                            <img src="<?php echo $data['img2']; ?>" style="width:80px; height:80px; object-fit:cover; margin-bottom:10px;">
                                        <?php } ?>
                                        <input type="file" name="img2" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Image 3</label><br>
                                        <?php if (!empty($data['img3'])) { ?>
                                            <img src="<?php echo $data['img3']; ?>" style="width:80px; height:80px; object-fit:cover; margin-bottom:10px;">
                                        <?php } ?>
                                        <input type="file" name="img3" class="form-control">
                                    </div>
                                </div>

                                <button type="submit" name="update_about" class="btn btn-success">Update About Us</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; School Website 2025</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
