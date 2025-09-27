<?php
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';  // your DB connection

$message = '';
$upload_dir = 'img/';  // Folder to store slider images
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
$maxFileSize = 2 * 1024 * 1024; // 2MB max size
$requiredWidth = 1366;
$requiredHeight = 768;

// Ensure upload directory exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    for ($i = 1; $i <= 2; $i++) {
        // Form inputs
        $heading = $_POST["heading_$i"] ?? '';
        $paragraph = $_POST["paragraph_$i"] ?? '';
        $btn1_text = $_POST["btn1_text_$i"] ?? '';
        $btn1_url = $_POST["btn1_url_$i"] ?? '';
        $btn2_text = $_POST["btn2_text_$i"] ?? '';
        $btn2_url = $_POST["btn2_url_$i"] ?? '';

        // Sanitize input
        $heading = $conn->real_escape_string($heading);
        $paragraph = $conn->real_escape_string($paragraph);
        $btn1_text = $conn->real_escape_string($btn1_text);
        $btn1_url = $conn->real_escape_string($btn1_url);
        $btn2_text = $conn->real_escape_string($btn2_text);
        $btn2_url = $conn->real_escape_string($btn2_url);

        $new_image_filename = null;

        if (isset($_FILES["image_$i"]) && $_FILES["image_$i"]['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES["image_$i"]['tmp_name'];
            $file_name = basename($_FILES["image_$i"]['name']);
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $file_size = $_FILES["image_$i"]['size'];

            // Validate extension and file size
            if (!in_array($ext, $allowed_extensions)) {
                $message .= "<div class='alert alert-warning'>Slide $i image must be jpg, jpeg, png, or gif.</div>";
            } elseif ($file_size > $maxFileSize) {
                $message .= "<div class='alert alert-warning'>Slide $i image exceeds 2MB size limit.</div>";
            } else {
                // Validate image dimensions
                $dimensions = getimagesize($file_tmp);
                if ($dimensions === false) {
                    $message .= "<div class='alert alert-warning'>Slide $i file is not a valid image.</div>";
                } else {
                    list($width, $height) = $dimensions;
                    if ($width != $requiredWidth || $height != $requiredHeight) {
                        $message .= "<div class='alert alert-warning'>Slide $i image must be exactly {$requiredWidth}px by {$requiredHeight}px. Uploaded image is {$width}px by {$height}px.</div>";
                    } else {
                        // Passed all checks, move file
                        $new_image_filename = 'carousel-' . $i . '-' . time() . '.' . $ext;
                        $destination = $upload_dir . $new_image_filename;

                        if (!move_uploaded_file($file_tmp, $destination)) {
                            $message .= "<div class='alert alert-warning'>Slide $i image upload failed.</div>";
                            $new_image_filename = null;
                        }
                    }
                }
            }
        }

        // If no new image uploaded, keep existing image
        if (!$new_image_filename) {
            $res = $conn->query("SELECT image FROM slider WHERE slide_number = $i");
            $row = $res ? $res->fetch_assoc() : null;
            $new_image_filename = $row['image'] ?? '';
        }

        // Update DB
        $update_query = "UPDATE slider SET 
            image='$new_image_filename',
            heading='$heading',
            paragraph='$paragraph',
            btn1_text='$btn1_text',
            btn1_url='$btn1_url',
            btn2_text='$btn2_text',
            btn2_url='$btn2_url'
            WHERE slide_number=$i";

        if (!$conn->query($update_query)) {
            $message .= "<div class='alert alert-danger'>Failed to update slide $i: " . $conn->error . "</div>";
        }
    }

    if (!$message) {
        $message = "<div class='alert alert-success'>Sliders updated successfully!</div>";
    }
}

// Fetch current slider data
$slides = [];
$result = $conn->query("SELECT * FROM slider ORDER BY slide_number ASC");
while ($row = $result->fetch_assoc()) {
    $slides[$row['slide_number']] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Slider</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .slider-edit-card {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            box-shadow: 0 4px 15px rgb(0 0 0 / 0.1);
            border-radius: 8px;
        }
        .slide-section {
            border-bottom: 1px solid #ddd;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .slide-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .slide-img-preview {
            max-height: 150px;
            margin-bottom: 1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        label {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="slider-edit-card">
        <h2>Edit Sliders</h2>
        <?= $message ?>

        <form method="POST" enctype="multipart/form-data">
    <?php for ($i = 1; $i <= 2; $i++): 
        $slide = $slides[$i] ?? [];
    ?>
    <div class="slide-section">
        <h4 class="mb-3">Slide <?= $i ?></h4>
        <div class="row g-4">
            <!-- Column 1: Image -->
            <div class="col-md-4">
                <label>Current Image:</label><br>
                <?php if (!empty($slide['image'])): ?>
                    <img src="img/<?= htmlspecialchars($slide['image']) ?>" 
                         alt="Slide <?= $i ?>" class="slide-img-preview img-fluid mb-2">
                <?php else: ?>
                    <p>No image uploaded yet.</p>
                <?php endif; ?>

                <label for="image_<?= $i ?>" class="form-label">Change Image (1366x768 px)</label>
                <input type="file" name="image_<?= $i ?>" id="image_<?= $i ?>" 
                       accept=".jpg,.jpeg,.png,.gif" class="form-control">
            </div>

            <!-- Column 2: Heading + Paragraph -->
            <div class="col-md-4">
                <label for="heading_<?= $i ?>" class="form-label">Heading</label>
                <input type="text" name="heading_<?= $i ?>" id="heading_<?= $i ?>" 
                       class="form-control mb-2" required 
                       value="<?= htmlspecialchars($slide['heading'] ?? '') ?>">

                <label for="paragraph_<?= $i ?>" class="form-label">Paragraph Text</label>
                <textarea name="paragraph_<?= $i ?>" id="paragraph_<?= $i ?>" 
                          rows="6" class="form-control" required><?= htmlspecialchars($slide['paragraph'] ?? '') ?></textarea>
            </div>

            <!-- Column 3: Buttons -->
            <div class="col-md-4">
                <label for="btn1_text_<?= $i ?>" class="form-label">Button 1 Text</label>
                <input type="text" name="btn1_text_<?= $i ?>" id="btn1_text_<?= $i ?>" 
                       class="form-control mb-2" required 
                       value="<?= htmlspecialchars($slide['btn1_text'] ?? '') ?>">

                <label for="btn1_url_<?= $i ?>" class="form-label">Button 1 URL</label>
                <input type="url" name="btn1_url_<?= $i ?>" id="btn1_url_<?= $i ?>" 
                       class="form-control mb-3" value="<?= htmlspecialchars($slide['btn1_url'] ?? '#') ?>">

                <label for="btn2_text_<?= $i ?>" class="form-label">Button 2 Text</label>
                <input type="text" name="btn2_text_<?= $i ?>" id="btn2_text_<?= $i ?>" 
                       class="form-control mb-2" required 
                       value="<?= htmlspecialchars($slide['btn2_text'] ?? '') ?>">

                <label for="btn2_url_<?= $i ?>" class="form-label">Button 2 URL</label>
                <input type="url" name="btn2_url_<?= $i ?>" id="btn2_url_<?= $i ?>" 
                       class="form-control" value="<?= htmlspecialchars($slide['btn2_url'] ?? '#') ?>">
            </div>
        </div>
    </div>
    <?php endfor; ?>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>

    </div>
</body>
</html>
