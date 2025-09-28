<?php
session_start();
include 'db.php';

// -------------------- SESSION CHECK --------------------
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// -------------------- ADD GALLERY IMAGE --------------------
if (isset($_POST['save_gallery'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = "uploads/gallery/" . time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $sql = "INSERT INTO gallery (title, image, description, created_at) 
            VALUES ('$title', '$image', '$description', NOW())";
    mysqli_query($conn, $sql);
    header("Location: gallery.php");
    exit();
}

// -------------------- UPDATE GALLERY IMAGE --------------------
if (isset($_POST['update_gallery'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($_FILES['image']['name'])) {
        $image = "uploads/gallery/" . time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
        $sql = "UPDATE gallery 
                SET title='$title', description='$description', image='$image' 
                WHERE id=$id";
    } else {
        $sql = "UPDATE gallery 
                SET title='$title', description='$description' 
                WHERE id=$id";
    }

    mysqli_query($conn, $sql);
    header("Location: gallery.php");
    exit();
}

// -------------------- DELETE GALLERY IMAGE --------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");
    header("Location: gallery.php");
    exit();
}

// -------------------- FETCH GALLERY IMAGES --------------------
$result = mysqli_query($conn, "SELECT `id`, `title`, `image`, `description`, `created_at` FROM `gallery` ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Gallery Management</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include 'file/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php include 'file/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Gallery</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Gallery</li>
                    </ol>

                    <!-- Add Gallery Button -->
                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                        <i class="fas fa-plus"></i> Add Image
                    </button>

                    <!-- Gallery Table -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-images"></i> Gallery List</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td>
                                                <?php if ($row['image'] && file_exists($row['image'])) { ?>
                                                    <img src="<?php echo $row['image']; ?>" width="50" height="50">
                                                <?php } else { ?>
                                                    <img src="img/default.png" width="50" height="50">
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td><?php echo $row['created_at']; ?></td>
                                            <td>
                                                <!-- Edit button -->
                                                <button class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editGalleryModal<?php echo $row['id']; ?>">
                                                    Edit
                                                </button>

                                                <!-- Delete -->
                                                <a href="?delete=<?php echo $row['id']; ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Delete this image?')">Delete</a>
                                            </td>
                                        </tr>

                                        <!-- Edit Gallery Modal -->
                                        <div class="modal fade" id="editGalleryModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title">Edit Image</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                              </div>
                                              <form method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                  <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Title</label>
                                                    <div class="col-sm-9">
                                                      <input type="text" name="title" class="form-control" value="<?php echo $row['title']; ?>" required>
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Description</label>
                                                    <div class="col-sm-9">
                                                      <textarea name="description" class="form-control" required><?php echo $row['description']; ?></textarea>
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Upload Image</label>
                                                    <div class="col-sm-9">
                                                      <input type="file" name="image" class="form-control">
                                                      <?php if ($row['image']) { ?>
                                                        <small>Current: <?php echo basename($row['image']); ?></small>
                                                      <?php } ?>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                  <button type="submit" name="update_gallery" class="btn btn-primary">Update</button>
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

    <!-- Add Gallery Modal -->
    <div class="modal fade" id="addGalleryModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg"> 
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-9">
                  <input type="text" name="title" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                  <textarea name="description" class="form-control" required></textarea>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Upload Image</label>
                <div class="col-sm-9">
                  <input type="file" name="image" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="save_gallery" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
