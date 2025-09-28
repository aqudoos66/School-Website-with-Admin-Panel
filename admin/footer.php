<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// -------------------- UPDATE FOOTER SECTION --------------------
if (isset($_POST['update_footer'])) {
    $id = $_POST['id'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $quick_links = $_POST['quick_links'];
    $newsletter_text = $_POST['newsletter_text'];

    $sql = "UPDATE footer SET 
                address='$address',
                phone='$phone',
                email='$email',
                quick_links='$quick_links',
                newsletter_text='$newsletter_text'
            WHERE id=$id";

    mysqli_query($conn, $sql);
    header("Location: footer.php");
    exit();
}

// -------------------- FETCH FOOTER DATA --------------------
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT `id`, `address`, `phone`, `email`, `quick_links`, `newsletter_text` FROM `footer` LIMIT 1"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Footer Management</title>
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
                    <h1 class="mt-4">Footer Section</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Footer Section</li>
                    </ol>

                    <div class="card">
                        <div class="card-header">Update Footer Section</div>
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
                                    <label>Quick Links (| Separated)</label>
                                    <textarea name="quick_links" class="form-control" required><?php echo $data['quick_links']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Newsletter Text</label>
                                    <textarea name="newsletter_text" class="form-control" required><?php echo $data['newsletter_text']; ?></textarea>
                                </div>

                                <button type="submit" name="update_footer" class="btn btn-success">Update Footer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            <?php echo $data['address']; ?> | <?php echo $data['phone']; ?> | <?php echo $data['email']; ?>
                        </div>
                        <div>
                            &copy; School Website 2025
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
