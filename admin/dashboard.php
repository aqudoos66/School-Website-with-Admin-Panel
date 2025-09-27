<?php
session_start();

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Get requested page, default to home
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Allowed pages
$allowed_pages = [
    'home',
    'edit-about_us',
    'edit-faculty',
    'edit-facilities',
    'edit-gallery',
    'edit-contact_us',
    'edit_footer',
    'edit_slider',
    'edit_classes',
    'edit_comment',
    'edit_card',
    'edit-teacher' // ✅ new teacher section
];
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white sidebar position-fixed" style="width:250px; height:100vh; background:#343a40;">
        <a href="?page=home" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4 fw-bold">Admin Panel</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Home Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle <?= ($page === 'edit_card' || $page === 'edit_slider' || $page === 'edit_classes' || $page === 'edit_comment') ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Home
                </a>
                <ul class="dropdown-menu bg-dark border-0">
                    <li><a class="dropdown-item text-white <?= ($page === 'edit_slider') ? 'active bg-primary' : '' ?>" href="?page=edit_slider">Edit Slider</a></li>
                    <li><a class="dropdown-item text-white <?= ($page === 'edit_card') ? 'active bg-primary' : '' ?>" href="?page=edit_card">Edit Card</a></li>
                    <li><a class="dropdown-item text-white <?= ($page === 'edit_comment') ? 'active bg-primary' : '' ?>" href="?page=edit_comment">Edit Comments</a></li>
                    <li><a class="dropdown-item text-white <?= ($page === 'edit_classes') ? 'active bg-primary' : '' ?>" href="?page=edit_classes">Edit Classes</a></li>
                </ul>
            </li>

            <!-- About Us Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle <?= ($page === 'edit-about_us' || $page === 'edit-teacher') ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    About Us
                </a>
                <ul class="dropdown-menu bg-dark border-0">
                    <li><a class="dropdown-item text-white <?= ($page === 'edit-about_us') ? 'active bg-primary' : '' ?>" href="?page=edit-about_us">Edit About Us</a></li>
                    <li><a class="dropdown-item text-white <?= ($page === 'edit-teacher') ? 'active bg-primary' : '' ?>" href="?page=edit-teacher">Edit Teacher Section</a></li>
                </ul>
            </li>

            <!-- Other pages -->
            <?php
            $pages = [
                'Faculty' => 'edit-faculty',
                'Facilities' => 'edit-facilities',
                'Gallery' => 'edit-gallery',
                'Contact Us' => 'edit-contact_us',
            ];
            foreach ($pages as $name => $page_link) {
                $active = ($page === $page_link) ? 'active' : '';
                echo "<li class='nav-item'>
                        <a class='nav-link text-white $active' href='?page=$page_link'>$name</a>
                      </li>";
            }
            ?>
            <li class="nav-item mt-3">
                <a class="nav-link text-white <?= ($page === 'edit_footer') ? 'active' : '' ?>" href="?page=edit_footer">Edit Footer</a>
            </li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="p-4 w-100 main-area" style="margin-left:250px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">
                <?php
                if ($page === 'home') echo "Home";
                elseif ($page === 'edit_slider') echo "Edit Slider";
                elseif ($page === 'edit_card') echo "Edit Card";
                elseif ($page === 'edit_comment') echo "Edit Comments";
                elseif ($page === 'edit_footer') echo "Edit Footer";
                elseif ($page === 'edit_classes') echo "Edit Classes";
                elseif ($page === 'edit-about_us') echo "Edit About Us";
                elseif ($page === 'edit-teacher') echo "Edit Teacher Section";
                elseif ($page === 'edit-faculty') echo "Edit Faculty";
                elseif ($page === 'edit_facilities') echo "Edit Facilities";
                elseif ($page === 'edit-gallery') echo "Edit Gallery";
                elseif ($page === 'edit-contact_us') echo "Edit Contact Us";
                else echo ucfirst(str_replace('_', ' ', str_replace('edit-', '', $page)));
                ?>
            </h1>
            <form method="POST" action="" style="margin:0;">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>

        <div class="main-content p-3 bg-white shadow-sm rounded">
            <?php
            if ($page === 'home') echo "<p>Manage your website content here.</p>";
            elseif ($page === 'edit_footer') include 'edit_footer.php';
            elseif ($page === 'edit_slider') include 'edit_slider.php';
            elseif ($page === 'edit_card') include 'card_edit.php';
            elseif ($page === 'edit_comment') include 'edit_comment.php';
            elseif ($page === 'edit_classes') include 'edit_classes.php';
            elseif ($page === 'edit-about_us') include 'edit_aboutus.php';
            elseif ($page === 'edit-teacher') include 'edit_teacher.php';
            elseif ($page === 'edit-faculty') include 'edit_faculty.php';   // ✅ Added Faculty Page
            elseif ($page === 'edit-facilities') include 'edit_facilities.php';
            elseif ($page === 'edit-gallery') include 'edit_gallery.php';
            elseif ($page === 'edit-contact_us') include 'edit_contact_us.php';
            ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
