<?php
// session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';



// --------------------- Add Comment ---------------------
if (isset($_POST['add_comment'])) {
    $client_name = $_POST['client_name'];
    $profession = $_POST['profession'];
    $comment = $_POST['comment'];

    // Default image
    $image = "admin/img/default.jpg";

    if (!empty($_FILES['image']['name'])) {
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = __DIR__ . "/../img/" . $fileName; // save inside /admin/img/

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = "img/" . $fileName; // DB path
        }
    }

    mysqli_query($conn, "INSERT INTO testimonials (client_name, profession, comment, image) 
                VALUES ('$client_name','$profession','$comment','$image')");
    header("Location: index.php?page=edit_comment");
    exit();
}

// --------------------- Update Comment ---------------------
if (isset($_POST['update_comment'])) {
    $id = $_POST['id'];
    $client_name = $_POST['client_name'];
    $profession = $_POST['profession'];
    $comment = $_POST['comment'];

    $image_query = "";
    if (!empty($_FILES['image']['name'])) {
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = __DIR__ . "/../img/" . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = "img/" . $fileName;
            $image_query = ", image='$image'";
        }
    }

    mysqli_query($conn, "UPDATE testimonials 
                         SET client_name='$client_name', profession='$profession', comment='$comment' $image_query
                         WHERE id=$id");
    header("Location: index.php?page=edit_comment");
    exit();
}

// --------------------- Delete Comment ---------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM testimonials WHERE id=$id");
    header("Location: index.php?page=edit_comment");
    exit();
}

// --------------------- Fetch All Comments ---------------------
$result = mysqli_query($conn, "SELECT * FROM testimonials ORDER BY id DESC");

// --------------------- Fetch Single for Editing ---------------------
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM testimonials WHERE id=$id"));
}
?>

<!-- ✅ Custom CSS -->
<style>
    .comment-form {
        background: #ffffff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .comment-card {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        transition: all 0.2s ease-in-out;
    }
    .comment-card:hover { transform: scale(1.02); }
    .comment-card img {
        width: 65px; height: 65px; object-fit: cover;
        border: 3px solid #0d6efd;
    }
    .comment-card h5 { font-size: 1.1rem; margin: 0; }
    .comment-card p { font-size: 0.95rem; margin: 2px 0 0; color: #555; }
    .btn-sm { font-size: 0.8rem; padding: 5px 12px; }
    .btn-rounded { border-radius: 8px; }
</style>

<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">✨ Manage Client Comments</h2>

    <!-- ✅ Add / Edit Comment Form -->
    <form method="POST" enctype="multipart/form-data" class="comment-form mb-5">
        <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">

        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Client Name</label>
                <input type="text" name="client_name" placeholder="Client Name" 
                       class="form-control" required
                       value="<?= $editData['client_name'] ?? ''; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Profession</label>
                <input type="text" name="profession" placeholder="Profession" 
                       class="form-control" required
                       value="<?= $editData['profession'] ?? ''; ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Comment</label>
                <input type="text" name="comment" placeholder="Comment" 
                       class="form-control" required
                       value="<?= $editData['comment'] ?? ''; ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Image</label>
                <input type="file" name="image" class="form-control">
                <?php if ($editData && !empty($editData['image'])): ?>
                    <img src="<?= $editData['image']; ?>" class="mt-2 rounded-circle" width="50" height="50">
                <?php endif; ?>
            </div>
        </div>

        <?php if ($editData) { ?>
            <button type="submit" name="update_comment" class="btn btn-primary btn-rounded mt-3">✏ Update Comment</button>
            <a href="index.php?page=edit_comment" class="btn btn-secondary btn-rounded mt-3">Cancel</a>
        <?php } else { ?>
            <button type="submit" name="add_comment" class="btn btn-success btn-rounded mt-3">➕ Add Comment</button>
        <?php } ?>
    </form>

    <!-- ✅ Comments List -->
    <div class="row">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-6">
                <div class="comment-card">
                    <img src="./../<?= $row['image']; ?>" class="rounded-circle me-3">
                    <div>
                        <h5><?= htmlspecialchars($row['client_name']); ?> 
                            <small class="text-muted">(<?= htmlspecialchars($row['profession']); ?>)</small>
                        </h5>
                        <p><?= htmlspecialchars($row['comment']); ?></p>
                    </div>
                    <div class="ms-auto">
                        <a href="index.php?page=edit_comment&edit=<?= $row['id']; ?>" class="btn btn-primary btn-sm me-2">✏ Edit</a>
                        <a href="index.php?page=edit_comment&delete=<?= $row['id']; ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this comment?');">🗑 Delete</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
