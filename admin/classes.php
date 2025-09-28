<?php
session_start();
include 'db.php';

// -------------------- SESSION CHECK --------------------
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// -------------------- ADD CLASS --------------------
if (isset($_POST['save_class'])) {
    $title = $_POST['title'];
    $teacher_name = $_POST['teacher_name'];
    $price = $_POST['price'];
    $age_range = $_POST['age_range'];
    $time = $_POST['time'];
    $capacity = $_POST['capacity'];

    // upload class image
    $class_image = '';
    if (!empty($_FILES['class_image']['name'])) {
        $class_image = "uploads/classes/" . time() . "_" . $_FILES['class_image']['name'];
        move_uploaded_file($_FILES['class_image']['tmp_name'], $class_image);
    }

    // upload teacher image
    $teacher_image = '';
    if (!empty($_FILES['teacher_image']['name'])) {
        $teacher_image = "uploads/teachers/" . time() . "_" . $_FILES['teacher_image']['name'];
        move_uploaded_file($_FILES['teacher_image']['tmp_name'], $teacher_image);
    }

    $sql = "INSERT INTO classes (title, teacher_name, teacher_image, price, age_range, time, capacity, class_image) 
            VALUES ('$title', '$teacher_name', '$teacher_image', '$price', '$age_range', '$time', '$capacity', '$class_image')";
    mysqli_query($conn, $sql);
    header("Location: classes.php");
    exit();
}

// -------------------- UPDATE CLASS --------------------
if (isset($_POST['update_class'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $teacher_name = $_POST['teacher_name'];
    $price = $_POST['price'];
    $age_range = $_POST['age_range'];
    $time = $_POST['time'];
    $capacity = $_POST['capacity'];

    // handle images
    $update_sql = "UPDATE classes 
                   SET title='$title', teacher_name='$teacher_name', price='$price', 
                       age_range='$age_range', time='$time', capacity='$capacity'";

    if (!empty($_FILES['class_image']['name'])) {
        $class_image = "uploads/classes/" . time() . "_" . $_FILES['class_image']['name'];
        move_uploaded_file($_FILES['class_image']['tmp_name'], $class_image);
        $update_sql .= ", class_image='$class_image'";
    }

    if (!empty($_FILES['teacher_image']['name'])) {
        $teacher_image = "uploads/teachers/" . time() . "_" . $_FILES['teacher_image']['name'];
        move_uploaded_file($_FILES['teacher_image']['tmp_name'], $teacher_image);
        $update_sql .= ", teacher_image='$teacher_image'";
    }

    $update_sql .= " WHERE id=$id";
    mysqli_query($conn, $update_sql);
    header("Location: classes.php");
    exit();
}

// -------------------- DELETE CLASS --------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM classes WHERE id=$id");
    header("Location: classes.php");
    exit();
}

// -------------------- FETCH CLASSES --------------------
$result = mysqli_query($conn, "SELECT * FROM classes ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Class Management</title>
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
                <h1 class="mt-4">Classes</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Manage Classes</li>
                </ol>

                <!-- Add Class Button -->
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addClassModal">
                    <i class="fas fa-plus"></i> Add Class
                </button>

                <!-- Classes Table -->
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-chalkboard"></i> Class List</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Teacher</th>
                                    <th>Teacher Image</th>
                                    <th>Price</th>
                                    <th>Age Range</th>
                                    <th>Time</th>
                                    <th>Capacity</th>
                                    <th>Class Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['teacher_name']; ?></td>
                                    <td>
    <?php if (!empty($row['teacher_image'])) { ?>
        <img src="<?php echo $row['teacher_image']; ?>" style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
    <?php } ?>
</td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['age_range']; ?></td>
                                    <td><?php echo $row['time']; ?></td>
                                    <td><?php echo $row['capacity']; ?></td>
                                    <td>
    <?php if (!empty($row['class_image'])) { ?>
        <img src="<?php echo $row['class_image']; ?>" style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
    <?php } ?>
</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editClassModal<?php echo $row['id']; ?>">Edit</button>
                                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this class?')">Delete</a>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editClassModal<?php echo $row['id']; ?>" tabindex="-1">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-header">
                                          <h5 class="modal-title">Edit Class</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                          <div class="mb-3">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control" value="<?php echo $row['title']; ?>" required>
                                          </div>
                                          <div class="mb-3">
                                            <label>Teacher Name</label>
                                            <input type="text" name="teacher_name" class="form-control" value="<?php echo $row['teacher_name']; ?>" required>
                                          </div>
                                          <div class="mb-3">
                                            <label>Teacher Image</label>
                                            <input type="file" name="teacher_image" class="form-control">
                                          </div>
                                          <div class="mb-3">
                                            <label>Price</label>
                                            <input type="text" name="price" class="form-control" value="<?php echo $row['price']; ?>">
                                          </div>
                                          <div class="mb-3">
                                            <label>Age Range</label>
                                            <input type="text" name="age_range" class="form-control" value="<?php echo $row['age_range']; ?>">
                                          </div>
                                          <div class="mb-3">
                                            <label>Time</label>
                                            <input type="text" name="time" class="form-control" value="<?php echo $row['time']; ?>">
                                          </div>
                                          <div class="mb-3">
                                            <label>Capacity</label>
                                            <input type="text" name="capacity" class="form-control" value="<?php echo $row['capacity']; ?>">
                                          </div>
                                          <div class="mb-3">
                                            <label>Class Image</label>
                                            <input type="file" name="class_image" class="form-control">
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" name="update_class" class="btn btn-primary">Update</button>
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

<!-- Add Class Modal -->
<div class="modal fade" id="addClassModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Add Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3"><label>Title</label><input type="text" name="title" class="form-control" required></div>
          <div class="mb-3"><label>Teacher Name</label><input type="text" name="teacher_name" class="form-control" required></div>
          <div class="mb-3"><label>Teacher Image</label><input type="file" name="teacher_image" class="form-control"></div>
          <div class="mb-3"><label>Price</label><input type="text" name="price" class="form-control"></div>
          <div class="mb-3"><label>Age Range</label><input type="text" name="age_range" class="form-control"></div>
          <div class="mb-3"><label>Time</label><input type="text" name="time" class="form-control"></div>
          <div class="mb-3"><label>Capacity</label><input type="text" name="capacity" class="form-control"></div>
          <div class="mb-3"><label>Class Image</label><input type="file" name="class_image" class="form-control"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="save_class" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
