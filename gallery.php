<?php
include 'admin/db.php'; // Database connection

// Fetch footer data
$sql = "SELECT * FROM footer WHERE id = 1 LIMIT 1";
$result = $conn->query($sql);
$footerData = $result && $result->num_rows > 0 ? $result->fetch_assoc() : [
    'address' => '',
    'phone' => '',
    'email' => '',
    'quick_links' => '',
    'newsletter_text' => ''
];

// Quick links array
$quickLinks = !empty($footerData['quick_links']) ? explode('|', $footerData['quick_links']) : [];

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
    <title>Gallery - <?= htmlspecialchars($site_name); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="admin/<?= htmlspecialchars($site_logo); ?>" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@600&family=Lobster+Two:wght@700&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap & Custom Styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        /* Gallery hover effect */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
        }

        .gallery-item img {
            transition: transform 0.5s ease, filter 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
            filter: brightness(0.8);
        }

        .gallery-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.6);
            color: #fff;
            text-align: center;
            padding: 10px 5px;
            font-weight: 500;
            font-size: 1rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-title {
            opacity: 1;
        }

        .breadcrumb a {
            color: #fff;
        }

        .breadcrumb .active {
            color: #ffd700;
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"></div>
        </div>

        <!-- Navbar -->
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
                    <a href="facilities.php" class="nav-item nav-link">Facilities</a>
                    <a href="gallery.php" class="nav-item nav-link active">Gallery</a>
                    <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                </div>
                <a href="" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">Join Us<i class="fa fa-arrow-right ms-3"></i></a>
            </div>
        </nav>

        <!-- Page Header Start -->
        <div class="container-xxl py-5 page-header position-relative mb-5">
            <div class="container py-5">
                <h1 class="display-2 text-white animated slideInDown mb-4">Gallery</h1>
                <nav aria-label="breadcrumb animated slideInDown">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Gallery</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header End -->

        <!-- Gallery Section -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Photo Gallery</h1>
                    <p>Explore moments captured at our school, showing activities, classrooms, and events.</p>
                </div>
                <div class="row g-4">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC LIMIT 6");
                    $delay = 0.1;
                    while($row = mysqli_fetch_assoc($result)) {
                        $imgPath = "admin/" . $row['image'];
                        if(!file_exists($imgPath) || empty($row['image'])) $imgPath = "img/default.png";
                    ?>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="<?= $delay ?>s">
                            <div class="gallery-item shadow-sm">
                                <img class="img-fluid w-100" src="<?= htmlspecialchars($imgPath); ?>" alt="<?= htmlspecialchars($row['title']); ?>">
                                <div class="gallery-title"><?= htmlspecialchars($row['title']); ?></div>
                            </div>
                        </div>
                    <?php
                        $delay += 0.2;
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn">
            <div class="container py-5">
                <div class="row g-5">
                    <!-- Contact -->
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Get In Touch</h3>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><?php echo htmlspecialchars($footerData['address']); ?></p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><?php echo htmlspecialchars($footerData['phone']); ?></p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i><?php echo htmlspecialchars($footerData['email']); ?></p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Quick Links</h3>
                        <?php if(!empty($quickLinks)): ?>
                            <?php foreach($quickLinks as $link): ?>
                                <a class="btn btn-link text-white-50" href="#"><?= htmlspecialchars($link); ?></a>
                            <?php endforeach; ?>
                        <?php endif; ?>
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

                    <!-- Newsletter -->
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Newsletter</h3>
                        <p><?= htmlspecialchars($footerData['newsletter_text']); ?></p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="email" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="copyright py-4">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Kidder</a>, All Rights Reserved.<br>Developed by Abdulkhaliq Bhatti
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="#">Home</a>
                                <a href="#">Cookies</a>
                                <a href="#">Help</a>
                                <a href="#">FAQs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template JS -->
    <script src="js/main.js"></script>
</body>
</html>
