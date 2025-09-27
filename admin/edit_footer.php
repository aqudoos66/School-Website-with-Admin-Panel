<?php
include 'db.php'; // Database connection
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$message = '';

// Fetch existing data for form
$sql = "SELECT * FROM footer WHERE id = 1 LIMIT 1";
$result = $conn->query($sql);
$footerData = $result && $result->num_rows > 0 ? $result->fetch_assoc() : [
    'address' => '',
    'phone' => '',
    'email' => '',
    'quick_links' => '',
    'newsletter_text' => ''
];

// Handle POST update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $newsletter_text = $_POST['newsletter_text'] ?? '';
    
    // Quick links as pipe-separated string
    $quick_texts = $_POST['quick_text'] ?? [];
    $quick_links = [];
    for ($i = 0; $i < count($quick_texts); $i++) {
        $text = trim($quick_texts[$i]);
        if ($text !== '') $quick_links[] = $text;
    }
    $quick_links_str = implode('|', $quick_links);

    // Update DB
    $stmt = $conn->prepare("UPDATE footer SET address=?, phone=?, email=?, quick_links=?, newsletter_text=? WHERE id=1");
    $stmt->bind_param("sssss", $address, $phone, $email, $quick_links_str, $newsletter_text);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Footer updated successfully!</div>";
        // Refresh data
        $footerData = [
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'quick_links' => $quick_links_str,
            'newsletter_text' => $newsletter_text
        ];
    } else {
        $message = "<div class='alert alert-danger'>Failed to update footer.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Edit Footer</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; padding: 30px 0; }
.footer-edit-container { max-width: 900px; margin: 0 auto 40px; background: #fff; padding: 30px 40px; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
h2 { margin-bottom: 30px; font-weight: 700; text-align: center; color: #343a40; }
h4 { margin-top: 30px; margin-bottom: 15px; font-weight: 600; color: #495057; border-bottom: 2px solid #0d6efd; padding-bottom: 8px; }
label { font-weight: 600; color: #495057; }
input[type="text"], input[type="url"], input[type="email"], textarea { border-radius: 6px; border: 1.5px solid #ced4da; padding: 12px 15px; font-size: 1rem; }
input:focus, textarea:focus { outline: none; border-color: #0d6efd; box-shadow: 0 0 5px #0d6efdaa; }
.btn-primary { background-color: #0d6efd; border: none; padding: 12px 28px; font-size: 1.1rem; font-weight: 600; border-radius: 6px; cursor: pointer; }
.btn-primary:hover { background-color: #0b5ed7; }
.row.mb-2 > .col-6 > input { margin-bottom: 6px; }
.alert { margin-top: 20px; font-weight: 600; }
p.text-muted { font-size: 0.9rem; font-style: italic; margin-top: 15px; color: #6c757d; }
</style>
</head>
<body>

<div class="footer-edit-container">
    <h2>Edit Footer Content</h2>
    <?= $message ?>

    <form method="POST" novalidate>

        <h4>Contact Details</h4>
        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?= htmlspecialchars($footerData['address']) ?>" required>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($footerData['phone']) ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($footerData['email']) ?>" required>

        <h4>Quick Links</h4>
        <div id="quick-links-container">
            <?php
            $links = !empty($footerData['quick_links']) ? explode('|', $footerData['quick_links']) : [];
            foreach ($links as $text):
            ?>
            <div class="row mb-2">
                <div class="col-12">
                    <input type="text" name="quick_text[]" placeholder="Link Text" value="<?= htmlspecialchars($text) ?>" required>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <h4>Newsletter</h4>
        <textarea name="newsletter_text" rows="3" required><?= htmlspecialchars($footerData['newsletter_text']) ?></textarea>

        <button type="submit" class="btn btn-primary mt-3">Save Footer</button>
    </form>
</div>

</body>
</html>
