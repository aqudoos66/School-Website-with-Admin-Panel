<?php
include 'db.php';

// Fetch existing data
$query = "SELECT * FROM card WHERE id=1 LIMIT 1";
$result = mysqli_query($conn, $query);
$card = mysqli_fetch_assoc($result);

// Update on form submit
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $description1 = $_POST['description1'];
    $description2 = $_POST['description2'];
    $button_text = $_POST['button_text'];
    $principal_name = $_POST['principal_name'];
    $principal_designation = $_POST['principal_designation'];

    // Handle image uploads
    $principal_image = $card['principal_image'];
    if (!empty($_FILES['principal_image']['name'])) {
        $principal_image = "uploads/" . basename($_FILES['principal_image']['name']);
        move_uploaded_file($_FILES['principal_image']['tmp_name'], $principal_image);
    }

    $image1 = $card['image1'];
    if (!empty($_FILES['image1']['name'])) {
        $image1 = "uploads/" . basename($_FILES['image1']['name']);
        move_uploaded_file($_FILES['image1']['tmp_name'], $image1);
    }

    $image2 = $card['image2'];
    if (!empty($_FILES['image2']['name'])) {
        $image2 = "uploads/" . basename($_FILES['image2']['name']);
        move_uploaded_file($_FILES['image2']['tmp_name'], $image2);
    }

    $image3 = $card['image3'];
    if (!empty($_FILES['image3']['name'])) {
        $image3 = "uploads/" . basename($_FILES['image3']['name']);
        move_uploaded_file($_FILES['image3']['tmp_name'], $image3);
    }

    $update = "UPDATE card 
               SET title='$title', description1='$description1', description2='$description2',
                   button_text='$button_text', principal_name='$principal_name', 
                   principal_designation='$principal_designation',
                   principal_image='$principal_image', image1='$image1', 
                   image2='$image2', image3='$image3'
               WHERE id=1";

    if (mysqli_query($conn, $update)) {
        echo "<div style='color:green; font-weight:bold; margin-bottom:15px;'>Card section updated successfully!</div>";
        header("Refresh:1");
    } else {
        echo "<div style='color:red; font-weight:bold;'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!-- Custom CSS -->
<style>
/* Form Container */
form {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    max-width: 900px;
    margin: 20px auto;
}

form label {
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
}

form input[type="text"],
form textarea,
form input[type="file"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 0.95rem;
}

form textarea {
    min-height: 80px;
    resize: vertical;
}

form img {
    display: block;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #ddd;
}

form button[type="submit"] {
    background-color: #0d6efd;
    color: #fff;
    padding: 10px 25px;
    font-size: 1rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

form button[type="submit"]:hover {
    background-color: #084298;
}

/* Responsive row layout */
.form-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.form-row > div {
    flex: 1;
    min-width: 200px;
}
</style>

<form method="post" enctype="multipart/form-data">
    <div class="form-row">
        <div>
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($card['title']) ?>">
        </div>
        <div>
            <label>Button Text</label>
            <input type="text" name="button_text" value="<?= htmlspecialchars($card['button_text']) ?>">
        </div>
    </div>

    <label>Description 1</label>
    <textarea name="description1"><?= htmlspecialchars($card['description1']) ?></textarea>

    <label>Description 2</label>
    <textarea name="description2"><?= htmlspecialchars($card['description2']) ?></textarea>

    <div class="form-row">
        <div>
            <label>Principal Name</label>
            <input type="text" name="principal_name" value="<?= htmlspecialchars($card['principal_name']) ?>">
        </div>
        <div>
            <label>Principal Designation</label>
            <input type="text" name="principal_designation" value="<?= htmlspecialchars($card['principal_designation']) ?>">
        </div>
    </div>

    <label>Principal Image</label>
    <input type="file" name="principal_image">
    <?php if(!empty($card['principal_image'])): ?>
        <img src="<?= $card['principal_image'] ?>" width="100">
    <?php endif; ?>

    <div class="form-row">
        <div>
            <label>Image 1</label>
            <input type="file" name="image1">
            <?php if(!empty($card['image1'])): ?>
                <img src="<?= $card['image1'] ?>" width="100">
            <?php endif; ?>
        </div>
        <div>
            <label>Image 2</label>
            <input type="file" name="image2">
            <?php if(!empty($card['image2'])): ?>
                <img src="<?= $card['image2'] ?>" width="100">
            <?php endif; ?>
        </div>
        <div>
            <label>Image 3</label>
            <input type="file" name="image3">
            <?php if(!empty($card['image3'])): ?>
                <img src="<?= $card['image3'] ?>" width="100">
            <?php endif; ?>
        </div>
    </div>

    <button type="submit" name="update">Update Card Section</button>
</form>
