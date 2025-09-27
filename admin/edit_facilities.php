<?php
include 'db.php';

// --------------------- Add Facility ---------------------
if (isset($_POST['add_facility'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];
    $color = $_POST['color'];

    mysqli_query($conn, "INSERT INTO facilities (title, description, icon, color) 
                         VALUES ('$title','$description','$icon','$color')");
    header("Location: dashboard.php?page=edit_facilities");
    exit();
}

// --------------------- Update Facility ---------------------
if (isset($_POST['update_facility'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];
    $color = $_POST['color'];

    mysqli_query($conn, "UPDATE facilities 
                         SET title='$title', description='$description', icon='$icon', color='$color'
                         WHERE id=$id");
    header("Location: dashboard.php?page=edit_facilities");
    exit();
}

// --------------------- Delete Facility ---------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM facilities WHERE id=$id");
    header("Location: dashboard.php?page=edit_facilities");
    exit();
}

// --------------------- Fetch All Facilities ---------------------
$result = mysqli_query($conn, "SELECT * FROM facilities ORDER BY id DESC");

// --------------------- Fetch Single Facility for Editing ---------------------
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM facilities WHERE id=$id"));
}
?>

<!-- ✅ Custom CSS -->
<style>
    .facility-form {
        background: #ffffff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .table-custom {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .table-custom th {
        background: #f8f9fa;
        font-weight: 600;
    }
    .btn-sm { font-size: 0.8rem; padding: 5px 12px; }
    .btn-rounded { border-radius: 8px; }
</style>

<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">🏫 Manage Facilities</h2>

    <!-- ✅ Add / Edit Facility Form -->
    <form method="POST" class="facility-form mb-5">
        <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">

        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" placeholder="Facility Title" 
                       class="form-control" required
                       value="<?= $editData['title'] ?? ''; ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold">Description</label>
                <input type="text" name="description" placeholder="Description" 
                       class="form-control" required
                       value="<?= $editData['description'] ?? ''; ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Icon (FontAwesome)</label>
                <input type="text" name="icon" placeholder="fa fa-bus-alt" 
                       class="form-control" required
                       value="<?= $editData['icon'] ?? ''; ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Color (Bootstrap)</label>
                <select name="color" class="form-control" required>
                    <?php 
                        $colors = ['primary','success','warning','info','danger','secondary'];
                        $selectedColor = $editData['color'] ?? 'primary';
                        foreach($colors as $c){
                            echo "<option value='$c' ".($selectedColor==$c?'selected':'').">$c</option>";
                        }
                    ?>
                </select>
            </div>
        </div>

        <?php if ($editData) { ?>
            <!-- Agar edit mode hai to Update button dikhayega -->
            <button type="submit" name="update_facility" class="btn btn-primary btn-rounded mt-3">✏ Update Facility</button>
            <a href="dashboard.php?page=edit_facilities" class="btn btn-secondary btn-rounded mt-3">Cancel</a>
        <?php } else { ?>
            <!-- Nahi to Add button dikhayega -->
            <button type="submit" name="add_facility" class="btn btn-success btn-rounded mt-3">➕ Add Facility</button>
        <?php } ?>
    </form>

    <!-- ✅ Facilities Table -->
    <div class="table-responsive table-custom">
        <table class="table table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Icon</th>
                    <th width="20%">Title</th>
                    <th>Description</th>
                    <th width="10%">Color</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><i class="<?= htmlspecialchars($row['icon']); ?> text-<?= $row['color']; ?> fa-2x"></i></td>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td><?= htmlspecialchars($row['description']); ?></td>
                            <td><span class="badge bg-<?= $row['color']; ?>"><?= $row['color']; ?></span></td>
                            <td>
                                <a href="dashboard.php?page=edit-facilities&edit=<?= $row['id']; ?>" 
                                   class="btn btn-primary btn-sm me-2">✏ Edit</a>
                                <a href="dashboard.php?page=edit_facilities&delete=<?= $row['id']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this facility?');">🗑 Delete</a>
                            </td>
                        </tr>
                    <?php } 
                } else { ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No facilities added yet.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
