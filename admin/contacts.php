<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// -------------------- UPDATE CONTACT US SECTION --------------------
if (isset($_POST['update_contact'])) {
    $id = $_POST['id'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $newsletter_text = $_POST['newsletter_text'];
    $map_url = $_POST['map_url'];

    $sql = "UPDATE contactus SET 
                address='$address',
                phone='$phone',
                email='$email',
                newsletter_text='$newsletter_text',
                map_url='$map_url'
            WHERE id=$id";

    mysqli_query($conn, $sql);
    header("Location: contacts.php");
    exit();
}

// -------------------- FETCH CONTACT US DATA --------------------
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `id`, `address`, `phone`, `email`, `newsletter_text`, `map_url`, `created_at` FROM `contactus` LIMIT 1"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Contact Us Management</title>
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
                    <h1 class="mt-4">Contact Us Section</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Contact Us Section</li>
                    </ol>

                    <div class="card">
                        <div class="card-header">Update Contact Us Section</div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                                <div class="mb-3">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo $data['address']; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo $data['phone']; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label>Newsletter Text</label>
                                    <textarea name="newsletter_text" class="form-control" required><?php echo $data['newsletter_text']; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label>Google Map URL</label>
                                    <input type="text" name="map_url" class="form-control" value="<?php echo $data['map_url']; ?>" placeholder="Paste Google Map embed URL here">
                                </div>

                                <div class="mb-3">
                                    <label>Created At</label>
                                    <input type="text" class="form-control" value="<?php echo $data['created_at']; ?>" readonly>
                                </div>

                                <button type="submit" name="update_contact" class="btn btn-success">Update Contact Us</button>
                            </form>
                        </div>
                    </div>

                    <?php if(!empty($data['map_url'])) { ?>
                        <div class="mt-4">
                            <h5>Map Preview:</h5>
                            <iframe src="<?php echo $data['map_url']; ?>" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    <?php } ?>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; School Website 2025</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
