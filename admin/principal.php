<?php
include 'file/session.php';
include 'db.php'; 

// -------------------- UPDATE PRINCIPAL SECTION --------------------
if (isset($_POST['update_principal'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description1 = $_POST['description1'];
    $description2 = $_POST['description2'];
    $button_text = $_POST['button_text'];
    $principal_name = $_POST['principal_name'];
    $principal_designation = $_POST['principal_designation'];

    // Handle Images
    $uploadDir = "uploads/principal/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $fields = [];
    if (!empty($_FILES['principal_image']['name'])) {
        $principal_image = $uploadDir . time() . "_principal_" . basename($_FILES["principal_image"]["name"]);
        move_uploaded_file($_FILES["principal_image"]["tmp_name"], $principal_image);
        $fields[] = "principal_image='$principal_image'";
    }
    if (!empty($_FILES['image1']['name'])) {
        $image1 = $uploadDir . time() . "_img1_" . basename($_FILES["image1"]["name"]);
        move_uploaded_file($_FILES["image1"]["tmp_name"], $image1);
        $fields[] = "image1='$image1'";
    }
    if (!empty($_FILES['image2']['name'])) {
        $image2 = $uploadDir . time() . "_img2_" . basename($_FILES["image2"]["name"]);
        move_uploaded_file($_FILES["image2"]["tmp_name"], $image2);
        $fields[] = "image2='$image2'";
    }
    if (!empty($_FILES['image3']['name'])) {
        $image3 = $uploadDir . time() . "_img3_" . basename($_FILES["image3"]["name"]);
        move_uploaded_file($_FILES["image3"]["tmp_name"], $image3);
        $fields[] = "image3='$image3'";
    }

    $sql = "UPDATE card SET 
                title='$title', 
                description1='$description1', 
                description2='$description2', 
                button_text='$button_text', 
                principal_name='$principal_name', 
                principal_designation='$principal_designation'";

    if (!empty($fields)) {
        $sql .= ", " . implode(", ", $fields);
    }

    $sql .= " WHERE id=$id";

    mysqli_query($conn, $sql);
    header("Location: principal.php");
    exit();
}

// -------------------- FETCH PRINCIPAL DATA --------------------
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM card LIMIT 1"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Principal Section Management</title>
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
                    <h1 class="mt-4">Principal Section</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Principal Section</li>
                    </ol>

                    <div class="card">
                        <div class="card-header">Update Principal Section</div>
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
                                    <div class="col-md-6 mb-3">
                                        <label>Principal Name</label>
                                        <input type="text" name="principal_name" class="form-control" value="<?php echo $data['principal_name']; ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Principal Designation</label>
                                        <input type="text" name="principal_designation" class="form-control" value="<?php echo $data['principal_designation']; ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Principal Image</label><br>
                                    <?php if (!empty($data['principal_image'])) { ?>
                                        <img src="<?php echo $data['principal_image']; ?>" style="width:100px; height:100px; border-radius:50%; object-fit:cover; margin-bottom:10px;">
                                    <?php } ?>
                                    <input type="file" name="principal_image" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Image 1</label><br>
                                        <?php if (!empty($data['image1'])) { ?>
                                            <img src="<?php echo $data['image1']; ?>" style="width:80px; height:80px; object-fit:cover; margin-bottom:10px;">
                                        <?php } ?>
                                        <input type="file" name="image1" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Image 2</label><br>
                                        <?php if (!empty($data['image2'])) { ?>
                                            <img src="<?php echo $data['image2']; ?>" style="width:80px; height:80px; object-fit:cover; margin-bottom:10px;">
                                        <?php } ?>
                                        <input type="file" name="image2" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Image 3</label><br>
                                        <?php if (!empty($data['image3'])) { ?>
                                            <img src="<?php echo $data['image3']; ?>" style="width:80px; height:80px; object-fit:cover; margin-bottom:10px;">
                                        <?php } ?>
                                        <input type="file" name="image3" class="form-control">
                                    </div>
                                </div>

                                <button type="submit" name="update_principal" class="btn btn-success">Update Section</button>
                            </form>
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
