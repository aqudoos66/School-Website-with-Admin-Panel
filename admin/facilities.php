<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// -------------------- ADD FACILITY (Only if < 4) --------------------
if (isset($_POST['add_facility'])) {
    $countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM facilities");
    $countRow = mysqli_fetch_assoc($countResult);

    if ($countRow['total'] < 4) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $icon = $_POST['icon'];
        $color = $_POST['color'];

        $sql = "INSERT INTO facilities (title, description, icon, color) 
                VALUES ('$title', '$description', '$icon', '$color')";
        mysqli_query($conn, $sql);
    }
    header("Location: facilities.php");
    exit();
}

// -------------------- UPDATE FACILITY --------------------
if (isset($_POST['update_facility'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];
    $color = $_POST['color'];

    $sql = "UPDATE facilities SET title='$title', description='$description', icon='$icon', color='$color' WHERE id=$id";
    mysqli_query($conn, $sql);

    header("Location: facilities.php");
    exit();
}

// -------------------- DELETE FACILITY --------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM facilities WHERE id=$id");
    header("Location: facilities.php");
    exit();
}

// -------------------- FETCH FACILITIES --------------------
$result = mysqli_query($conn, "SELECT * FROM facilities ORDER BY id ASC");
$count = mysqli_num_rows($result);

// Predefined 20 School/Education Icons
$schoolIcons = [
    "fas fa-book", "fas fa-book-open", "fas fa-graduation-cap", "fas fa-chalkboard-teacher",
    "fas fa-school", "fas fa-pencil-alt", "fas fa-pen", "fas fa-ruler",
    "fas fa-ruler-combined", "fas fa-laptop", "fas fa-laptop-code", "fas fa-flask",
    "fas fa-microscope", "fas fa-dna", "fas fa-bus", "fas fa-futbol",
    "fas fa-music", "fas fa-palette", "fas fa-theater-masks", "fas fa-lightbulb"
];

// Predefined Bootstrap Colors
$colors = [
    "primary" => "Primary (Blue)",
    "success" => "Success (Green)",
    "danger" => "Danger (Red)",
    "warning" => "Warning (Yellow)",
    "info" => "Info (Cyan)",
    "secondary" => "Secondary (Gray)",
    "dark" => "Dark (Black)"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Facilities Management</title>
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
                    <h1 class="mt-4">Facilities</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Facilities (Max 4)</li>
                    </ol>

                    <!-- Show Add Button Only if < 4 -->
                    <?php if ($count < 4) { ?>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Add Facility</button>
                    <?php } else { ?>
                        <div class="alert alert-warning">You already have 4 facilities. Cannot add more.</div>
                    <?php } ?>

                    <!-- Facilities List -->
                    <div class="row">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card text-center shadow-sm border-0 border-top border-4 border-<?= $row['color']; ?>">
                                <div class="card-body">
                                    <i class="<?= $row['icon']; ?> fa-2x mb-2 text-<?= $row['color']; ?>"></i>
                                    <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($row['description']); ?></p>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">Edit</button>
                                    <a href="facilities.php?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this facility?')">Delete</a>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Facility</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <div class="mb-3">
                                                <label>Title</label>
                                                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control" required><?= htmlspecialchars($row['description']); ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label>Icon</label>
                                                <select name="icon" class="form-control" required>
                                                    <?php foreach ($schoolIcons as $icon) { ?>
                                                        <option value="<?= $icon; ?>" <?= ($row['icon'] == $icon) ? 'selected' : ''; ?>>
                                                            <?= $icon; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Color</label>
                                                <select name="color" class="form-control" required>
                                                    <?php foreach ($colors as $class => $label) { ?>
                                                        <option value="<?= $class; ?>" <?= ($row['color'] == $class) ? 'selected' : ''; ?>>
                                                            <?= $label; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="update_facility" class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Facility</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Icon</label>
                            <select name="icon" class="form-control" required>
                                <?php foreach ($schoolIcons as $icon) { ?>
                                    <option value="<?= $icon; ?>"><?= $icon; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Color</label>
                            <select name="color" class="form-control" required>
                                <?php foreach ($colors as $class => $label) { ?>
                                    <option value="<?= $class; ?>"><?= $label; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_facility" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
