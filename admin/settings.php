<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// -------------------- UPDATE SETTINGS --------------------
if (isset($_POST['save_settings'])) {
    $id = $_POST['id'];
    $site_name = $_POST['site_name'];
    $site_icon = $_POST['site_icon'];

    // Upload logo if provided
    $uploadDir = "uploads/settings/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $site_logo = $_POST['current_logo']; // existing logo
    if (!empty($_FILES['site_logo']['name'])) {
        $fileName = time() . "_" . basename($_FILES['site_logo']['name']);
        $filePath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $filePath)) {
            $site_logo = $filePath;
        }
    }

    $sql = "UPDATE settings SET site_name='$site_name', site_icon='$site_icon', site_logo='$site_logo' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: settings.php?success=1");
    exit();
}

// -------------------- FETCH SETTINGS DATA --------------------
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM settings ORDER BY id DESC LIMIT 1"));

// -------------------- ICONS ARRAY --------------------
$icons = [
    "fa-book-reader","fa-graduation-cap","fa-university","fa-school","fa-chalkboard",
    "fa-chalkboard-teacher","fa-user-graduate","fa-lightbulb","fa-laptop","fa-pencil-alt",
    "fa-book","fa-book-open","fa-pen-nib","fa-atom","fa-rocket",
    "fa-globe","fa-cogs","fa-bolt","fa-flask","fa-microscope",
    "fa-magic","fa-palette","fa-music","fa-film","fa-camera",
    "fa-heart","fa-star","fa-tree","fa-sun","fa-moon",
    "fa-cloud","fa-mountain","fa-water","fa-fire","fa-leaf",
    "fa-bicycle","fa-car","fa-plane","fa-ship","fa-train",
    "fa-phone","fa-envelope","fa-comments","fa-smile","fa-frown",
    "fa-user","fa-users","fa-crown","fa-gem","fa-gift"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Settings</title>
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
                <h1 class="mt-4">Site Settings</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Manage Site Name & Logo</li>
                </ol>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Settings saved successfully!</div>
                <?php endif; ?>

                <div class="card mb-4">
                    <div class="card-header">Update Site Settings</div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $data['id']; ?>">
                            <input type="hidden" name="current_logo" value="<?= htmlspecialchars($data['site_logo']); ?>">

                            <div class="mb-3">
                                <label>Site Name</label>
                                <input type="text" name="site_name" class="form-control" value="<?= htmlspecialchars($data['site_name']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Choose Icon (50 options)</label>
                                <div class="d-flex flex-wrap gap-2 border p-2" style="max-height:250px; overflow-y:auto;">
                                    <?php foreach ($icons as $icon): ?>
                                        <label style="width:60px; text-align:center; cursor:pointer;">
                                            <input type="radio" name="site_icon" value="<?= $icon; ?>" style="display:none;" <?= ($data['site_icon']==$icon?'checked':''); ?>>
                                            <i class="fa <?= $icon; ?> fa-2x <?= ($data['site_icon']==$icon?'text-primary':''); ?>"></i>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Or Upload Logo Image</label><br>
                                <?php if (!empty($data['site_logo'])): ?>
                                    <img src="<?= htmlspecialchars($data['site_logo']); ?>" style="height:50px; margin-bottom:10px;">
                                <?php endif; ?>
                                <input type="file" name="site_logo" class="form-control">
                            </div>

                            <button type="submit" name="save_settings" class="btn btn-success">Save Settings</button>
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
