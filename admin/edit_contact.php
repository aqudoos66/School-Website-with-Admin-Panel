<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --------------------- Fetch Contact Info ---------------------
$result = mysqli_query($conn, "SELECT * FROM contactus ORDER BY id DESC LIMIT 1");
if (mysqli_num_rows($result) > 0) {
    $contact = mysqli_fetch_assoc($result);
} else {
    // If no record exists, insert one
    mysqli_query($conn, "INSERT INTO contactus (address, phone, email, newsletter_text, map_url) 
                         VALUES ('', '', '', '', '')");
    $contact = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM contactus ORDER BY id DESC LIMIT 1"));
}

// --------------------- Update Contact ---------------------
if (isset($_POST['update_contact'])) {
    $id = $_POST['id'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $newsletter_text = $_POST['newsletter_text'];
    $map_url = $_POST['map_url'];

    mysqli_query($conn, "UPDATE contactus 
                         SET address='$address', phone='$phone', email='$email', 
                             newsletter_text='$newsletter_text', map_url='$map_url' 
                         WHERE id=$id");

    header("Location: index.php?page=edit_contact");
    exit();
}
?>

<!-- ✅ Custom CSS -->
<style>
    .contact-form {
        background: #ffffff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        max-width: 800px;
        margin: auto;
    }
    .form-label { font-weight: 600; }
</style>

<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">📌 Manage Contact Information</h2>

    <!-- ✅ Edit Contact Form -->
    <form method="POST" class="contact-form">
        <input type="hidden" name="id" value="<?= $contact['id'] ?? ''; ?>">

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">📍 Address</label>
                <input type="text" name="address" class="form-control" 
                       value="<?= htmlspecialchars($contact['address'] ?? ''); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">📞 Phone</label>
                <input type="text" name="phone" class="form-control" 
                       value="<?= htmlspecialchars($contact['phone'] ?? ''); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">📧 Email</label>
                <input type="email" name="email" class="form-control" 
                       value="<?= htmlspecialchars($contact['email'] ?? ''); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">📰 Newsletter Text</label>
                <input type="text" name="newsletter_text" class="form-control" 
                       value="<?= htmlspecialchars($contact['newsletter_text'] ?? ''); ?>">
            </div>
            <div class="col-12">
                <label class="form-label">🗺 Map URL (Google Maps Embed)</label>
                <textarea name="map_url" class="form-control" rows="3"><?= htmlspecialchars($contact['map_url'] ?? ''); ?></textarea>
            </div>
        </div>

        <button type="submit" name="update_contact" class="btn btn-primary btn-rounded mt-3">💾 Update Contact</button>
    </form>
</div>
