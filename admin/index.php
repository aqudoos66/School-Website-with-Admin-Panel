<?php
session_start();
include 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch site data
$about = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM about_us LIMIT 1"));
$contact = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM contactus ORDER BY id DESC LIMIT 1"));
$facilities = mysqli_query($conn, "SELECT * FROM facilities");
$faculty = mysqli_query($conn, "SELECT * FROM faculty ORDER BY id DESC LIMIT 4");
$classes = mysqli_query($conn, "SELECT * FROM classes ORDER BY id DESC LIMIT 4");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Overview</li>
                    </ol>

                    <!-- About Us -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-info-circle"></i> About Us</div>
                        <div class="card-body">
                            <h3><?php echo $about['title']; ?></h3>
                            <p><?php echo $about['description1']; ?></p>
                            <p><?php echo $about['description2']; ?></p>
                            <strong><?php echo $about['person_name']; ?> - <?php echo $about['designation']; ?></strong>
                        </div>
                    </div>

                    <!-- Facilities -->
                    <div class="row">
                        <?php while ($row = mysqli_fetch_assoc($facilities)) { ?>
                        <div class="col-md-3">
                            <div class="card text-center mb-4 border-<?php echo $row['color']; ?>">
                                <div class="card-body">
                                    <i class="<?php echo $row['icon']; ?> fa-2x mb-2 text-<?php echo $row['color']; ?>"></i>
                                    <h5><?php echo $row['title']; ?></h5>
                                    <p><?php echo $row['description']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Faculty -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-users"></i> Faculty</div>
                        <div class="card-body row">
                            <?php while ($row = mysqli_fetch_assoc($faculty)) { ?>
                            <div class="col-md-3 text-center">
                                <img src="<?php echo $row['image']; ?>" class="img-fluid rounded-circle mb-2" width="100" height="100">
                                <h6><?php echo $row['name']; ?></h6>
                                <p><?php echo $row['designation']; ?></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Classes -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-book"></i> Classes</div>
                        <div class="card-body row">
                            <?php while ($row = mysqli_fetch_assoc($classes)) { ?>
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <img src="<?php echo $row['class_image']; ?>" class="card-img-top" alt="">
                                    <div class="card-body">
                                        <h5><?php echo $row['title']; ?></h5>
                                        <p>Teacher: <?php echo $row['teacher_name']; ?></p>
                                        <p>Price: <?php echo $row['price']; ?></p>
                                        <p>Age: <?php echo $row['age_range']; ?></p>
                                        <p>Time: <?php echo $row['time']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-envelope"></i> Contact Info</div>
                        <div class="card-body">
                            <p><strong>Address:</strong> <?php echo $contact['address']; ?></p>
                            <p><strong>Phone:</strong> <?php echo $contact['phone']; ?></p>
                            <p><strong>Email:</strong> <?php echo $contact['email']; ?></p>
                        </div>
                    </div>

                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; School Website <?php echo date("Y"); ?></div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>