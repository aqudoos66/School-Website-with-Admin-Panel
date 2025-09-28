<?php
include 'file/session.php';
include 'db.php'; 

// -------------------- MARK MESSAGE AS READ --------------------
if (isset($_GET['mark_read'])) {
    $id = intval($_GET['mark_read']);
    mysqli_query($conn, "UPDATE messages SET status='read' WHERE id=$id");
    header("Location: messages.php");
    exit();
}

// -------------------- MARK MESSAGE AS UNREAD --------------------
if (isset($_GET['mark_unread'])) {
    $id = intval($_GET['mark_unread']);
    mysqli_query($conn, "UPDATE messages SET status='unread' WHERE id=$id");
    header("Location: messages.php");
    exit();
}

// -------------------- DELETE MESSAGE --------------------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM messages WHERE id=$id");
    header("Location: messages.php");
    exit();
}

// -------------------- FETCH MESSAGES --------------------
$result = mysqli_query($conn, "SELECT * FROM messages ORDER BY 
    CASE WHEN status='unread' THEN 0 ELSE 1 END, created_at ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages Management</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include 'file/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php include 'file/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Messages</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Manage Messages</li>
                    </ol>

                    <!-- Messages Table -->
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-envelope me-1"></i> Messages List</div>
                        <div class="card-body">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Received At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr class="<?= $row['status'] == 'unread' ? 'table-warning' : ''; ?>">
                                        <td><?= $row['id']; ?></td>
                                        <td><?= htmlspecialchars($row['name']); ?></td>
                                        <td><?= htmlspecialchars($row['email']); ?></td>
                                        <td><?= htmlspecialchars($row['subject']); ?></td>
                                        <td><?= htmlspecialchars($row['message']); ?></td>
                                        <td><?= ucfirst($row['status']); ?></td>
                                        <td><?= $row['created_at']; ?></td>
                                        <td>
                                            <?php if($row['status']=='unread'): ?>
                                                <a href="messages.php?mark_read=<?= $row['id']; ?>" class="btn btn-sm btn-success mb-1">Mark Read</a>
                                            <?php else: ?>
                                                <a href="messages.php?mark_unread=<?= $row['id']; ?>" class="btn btn-sm btn-warning mb-1">Mark Unread</a>
                                            <?php endif; ?>
                                            <a href="messages.php?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <?php if(mysqli_num_rows($result) == 0){ ?>
                                        <tr>
                                            <td colspan="8">No messages found.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
