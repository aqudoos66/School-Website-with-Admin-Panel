<?php
include 'db.php';

// Fetch existing data
$query = "SELECT * FROM about_us WHERE id=1 LIMIT 1";
$result = mysqli_query($conn, $query);
$about = mysqli_fetch_assoc($result);

// Update form submit
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $description1 = $_POST['description1'];
    $description2 = $_POST['description2'];
    $button_text = $_POST['button_text'];
    $person_name = $_POST['person_name'];
    $designation = $_POST['designation'];

    // Handle image uploads
    $person_image = $about['person_image'];
    $img1 = $about['img1'];
    $img2 = $about['img2'];
    $img3 = $about['img3'];

    if (!empty($_FILES['person_image']['name'])) {
        $person_image = "uploads/" . basename($_FILES['person_image']['name']);
        move_uploaded_file($_FILES['person_image']['tmp_name'], $person_image);
    }
    if (!empty($_FILES['img1']['name'])) {
        $img1 = "uploads/" . basename($_FILES['img1']['name']);
        move_uploaded_file($_FILES['img1']['tmp_name'], $img1);
    }
    if (!empty($_FILES['img2']['name'])) {
        $img2 = "uploads/" . basename($_FILES['img2']['name']);
        move_uploaded_file($_FILES['img2']['tmp_name'], $img2);
    }
    if (!empty($_FILES['img3']['name'])) {
        $img3 = "uploads/" . basename($_FILES['img3']['name']);
        move_uploaded_file($_FILES['img3']['tmp_name'], $img3);
    }

    $sql = "UPDATE about_us SET 
        title='$title', 
        description1='$description1', 
        description2='$description2', 
        button_text='$button_text',
        person_name='$person_name',
        designation='$designation',
        person_image='$person_image',
        img1='$img1',
        img2='$img2',
        img3='$img3'
        WHERE id=1";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Updated Successfully'); window.location.href='dashboard.php?page=edit-about_us';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">✏️ Edit About Us Section</div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="<?= $about['title'] ?>">
                        </div>
                        <div class="mb-3">
                            <label>Description 1</label>
                            <textarea name="description1" class="form-control"><?= $about['description1'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Description 2</label>
                            <textarea name="description2" class="form-control"><?= $about['description2'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Button Text</label>
                            <input type="text" name="button_text" class="form-control" value="<?= $about['button_text'] ?>">
                        </div>
                        <div class="mb-3">
                            <label>Person Name</label>
                            <input type="text" name="person_name" class="form-control" value="<?= $about['person_name'] ?>">
                        </div>
                        <div class="mb-3">
                            <label>Designation</label>
                            <input type="text" name="designation" class="form-control" value="<?= $about['designation'] ?>">
                        </div>
                        <div class="mb-3">
                            <label>Person Image</label><br>
                            <img src="<?= $about['person_image'] ?>" width="80" class="mb-2"><br>
                            <input type="file" name="person_image" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Image 1</label><br>
                                <img src="<?= $about['img1'] ?>" width="100" class="mb-2"><br>
                                <input type="file" name="img1" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Image 2</label><br>
                                <img src="<?= $about['img2'] ?>" width="100" class="mb-2"><br>
                                <input type="file" name="img2" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Image 3</label><br>
                                <img src="<?= $about['img3'] ?>" width="100" class="mb-2"><br>
                                <input type="file" name="img3" class="form-control">
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" name="update" class="btn btn-primary">💾 Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
