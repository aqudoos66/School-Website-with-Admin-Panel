<?php
include 'admin/db.php';

// Fetch site settings
$settings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM settings ORDER BY id DESC LIMIT 1"));

// Default values if nothing is set
$site_name = !empty($settings['site_name']) ? $settings['site_name'] : "Kider";
$site_icon = !empty($settings['site_icon']) ? $settings['site_icon'] : "fa-book-reader";
$site_logo = !empty($settings['site_logo']) ? $settings['site_logo'] : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Facilities - <?= htmlspecialchars($site_name); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="admin/<?= htmlspecialchars($site_logo); ?>" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0">
           <a href="index.php" class="navbar-brand d-flex align-items-center">
    <?php if($site_logo): ?>
        <!-- Show logo image if uploaded -->
        <img src="admin/<?= htmlspecialchars($site_logo); ?>" alt="<?= htmlspecialchars($site_name); ?>" style="height:40px; width:40px; object-fit:cover; margin-right:10px;">
    <?php else: ?>
        <!-- Show font-awesome icon if no logo -->
        <i class="fa <?= htmlspecialchars($site_icon); ?> me-3"></i>
    <?php endif; ?>
    <h1 class="m-0 text-primary"><?= htmlspecialchars($site_name); ?></h1>
</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="about.php" class="nav-item nav-link">About Us</a>
                    <a href="faculty.php" class="nav-item nav-link">Faculty</a>
                    <a href="facilities.php" class="nav-item nav-link active">Facilities</a>
                    <a href="gallery.php" class="nav-item nav-link">Gallery</a>
                    <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                </div>
                <a href="" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">Join Us<i class="fa fa-arrow-right ms-3"></i></a>
            </div>
        </nav>
        <!-- Navbar End -->


        <!-- Page Header Start -->
        <div class="container-xxl py-5 page-header position-relative mb-5">
            <div class="container py-5">
                <h1 class="display-2 text-white animated slideInDown mb-4">Facilities</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Facilities</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header End -->


        <!-- Facilities Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">School Facilities</h1>
                    <p>Explore our modern school facilities designed to support student growth and learning.</p>
                </div>
                <div class="row g-4">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM facilities ORDER BY id DESC");
                    $delay = 0.1;
                    while($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                            <div class="facility-item">
                                <div class="facility-icon bg-<?= htmlspecialchars($row['color']); ?>">
                                    <span class="bg-<?= htmlspecialchars($row['color']); ?>"></span>
                                    <i class="<?= htmlspecialchars($row['icon']); ?> fa-3x text-<?= htmlspecialchars($row['color']); ?>"></i>
                                    <span class="bg-<?= htmlspecialchars($row['color']); ?>"></span>
                                </div>
                                <div class="facility-text bg-<?= htmlspecialchars($row['color']); ?>">
                                    <h3 class="text-<?= htmlspecialchars($row['color']); ?> mb-3"><?= htmlspecialchars($row['title']); ?></h3>
                                    <p class="mb-0"><?= htmlspecialchars($row['description']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                        $delay += 0.2;
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Facilities End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Get In Touch</h3>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Quick Links</h3>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <?php
// Fetch latest 6 images from gallery
$galleryResult = mysqli_query($conn, "SELECT `id`, `title`, `image` FROM `gallery` ORDER BY id DESC LIMIT 6");
?>

<div class="col-lg-3 col-md-6">
    <h3 class="text-white mb-4">Photo Gallery</h3>
    <div class="row g-2 pt-2">
        <?php while($row = mysqli_fetch_assoc($galleryResult)): ?>
            <?php 
                $imgPath = "admin/" . $row['image']; // path from DB
                // fallback if image missing
                if (!file_exists($imgPath) || empty($row['image'])) {
                    $imgPath = "img/default.png"; // default placeholder
                }
            ?>
            <div class="col-4">
                <img class="img-fluid rounded bg-light p-1" src="<?= htmlspecialchars($imgPath); ?>" alt="<?= htmlspecialchars($row['title']); ?>">
            </div>
        <?php endwhile; ?>
    </div>
</div>

                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Newsletter</h3>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved. 
							
							Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
