<?php
session_start();
include 'db.php';

// -------------------- SESSION CHECK --------------------
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// -------------------- ADD FACULTY --------------------
if (isset($_POST['save_faculty'])) {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = "uploads/faculty/" . time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $sql = "INSERT INTO faculty (name, designation, image, facebook, twitter, instagram, created_at) 
            VALUES ('$name', '$designation', '$image', '$facebook', '$twitter', '$instagram', NOW())";
    mysqli_query($conn, $sql);
    header("Location: faculty.php");
    exit();
}

// -------------------- UPDATE FACULTY --------------------
if (isset($_POST['update_faculty'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];

    if (!empty($_FILES['image']['name'])) {
        $image = "uploads/faculty/" . time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
        $sql = "UPDATE faculty 
                SET name='$name', designation='$designation', image='$image', 
                    facebook='$facebook', twitter='$twitter', instagram='$instagram' 
                WHERE id=$id";
    } else {
        $sql = "UPDATE faculty 
                SET name='$name', designation='$designation', 
                    facebook='$facebook', twitter='$twitter', instagram='$instagram' 
                WHERE id=$id";
    }

    mysqli_query($conn, $sql);
    header("Location: faculty.php");
    exit();
}

// -------------------- DELETE FACULTY --------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM faculty WHERE id=$id");
    header("Location: faculty.php");
    exit();
}

// -------------------- FETCH FACULTY --------------------
$result = mysqli_query($conn, "SELECT * FROM faculty ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Faculty Management</title>
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
                    <h1 class="mt-4">Faculty</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Faculty</li>
                    </ol>

                    <!-- Add Faculty Button -->
                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addFacultyModal">
                        <i class="fas fa-plus"></i> Add Faculty
                    </button>

                    <!-- Faculty Table -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-users"></i> Faculty List</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Facebook</th>
                                        <th>Twitter</th>
                                        <th>Instagram</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td>
                                                <?php if ($row['image']) { ?>
                                                    <img src="<?php echo $row['image']; ?>" width="50" height="50">
                                                <?php } else { ?>
                                                    <span>No Image</span>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['designation']; ?></td>
                                            <td><a href="<?php echo $row['facebook']; ?>" target="_blank">Facebook</a></td>
                                            <td><a href="<?php echo $row['twitter']; ?>" target="_blank">Twitter</a></td>
                                            <td><a href="<?php echo $row['instagram']; ?>" target="_blank">Instagram</a></td>
                                            <td>
                                                <!-- Edit button -->
                                                <button class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editFacultyModal<?php echo $row['id']; ?>">
                                                    Edit
                                                </button>

                                                <!-- Delete -->
                                                <a href="?delete=<?php echo $row['id']; ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Delete this faculty?')">Delete</a>
                                            </td>
                                        </tr>

                                        <!-- Edit Faculty Modal -->
                                        <div class="modal fade" id="editFacultyModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title">Edit Faculty</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                              </div>
                                              <form method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                  <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                      <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Designation</label>
                                                    <div class="col-sm-9">
                                                      <input type="text" name="designation" class="form-control" value="<?php echo $row['designation']; ?>" required>
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Facebook</label>
                                                    <div class="col-sm-9">
                                                      <input type="url" name="facebook" class="form-control" value="<?php echo $row['facebook']; ?>">
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Twitter</label>
                                                    <div class="col-sm-9">
                                                      <input type="url" name="twitter" class="form-control" value="<?php echo $row['twitter']; ?>">
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Instagram</label>
                                                    <div class="col-sm-9">
                                                      <input type="url" name="instagram" class="form-control" value="<?php echo $row['instagram']; ?>">
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
                                                  <button type="submit" name="update_faculty" class="btn btn-primary">Update</button>
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

    <!-- Add Faculty Modal -->
    <div class="modal fade" id="addFacultyModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg"> 
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Faculty</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                  <input type="text" name="name" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Designation</label>
                <div class="col-sm-9">
                  <input type="text" name="designation" class="form-control" required>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Facebook</label>
                <div class="col-sm-9">
                  <input type="url" name="facebook" class="form-control">
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Twitter</label>
                <div class="col-sm-9">
                  <input type="url" name="twitter" class="form-control">
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Instagram</label>
                <div class="col-sm-9">
                  <input type="url" name="instagram" class="form-control">
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Upload Image</label>
                <div class="col-sm-9">
                  <input type="file" name="image" class="form-control">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="save_faculty" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>