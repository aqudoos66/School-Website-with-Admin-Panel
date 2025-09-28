<?php
// Fetch unread messages count
$unreadQuery = mysqli_query($conn, "SELECT COUNT(*) AS unread_count FROM messages WHERE status='unread'");
$unreadRow = mysqli_fetch_assoc($unreadQuery);
$unreadCount = $unreadRow['unread_count'];
?>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Core Section -->
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- Website Management Section -->
                <div class="sb-sidenav-menu-heading">Website Management</div>
                <a class="nav-link" href="slider.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
                    Slider
                </a>
                <a class="nav-link" href="principal.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    Principal
                </a>
                <a class="nav-link" href="faculty.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Faculty
                </a>
                <a class="nav-link" href="facilities.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                    Facilities
                </a>
                <a class="nav-link" href="classes.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chalkboard"></i></div>
                    Classes
                </a>
                <a class="nav-link" href="events.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                    Events / News
                </a>
                <a class="nav-link" href="gallery.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-image"></i></div>
                    Gallery
                </a>
                <a class="nav-link" href="aboutus.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                    About Us
                </a>
                <a class="nav-link" href="testimonials.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-comment"></i></div>
                    Testimonials
                </a>
                <a class="nav-link" href="footer.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Footer
                </a>
                <a class="nav-link" href="contacts.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                    Contact Us
                </a>
                <a class="nav-link" href="messages.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-envelope-open-text"></i></div>
                    Messages
                    <?php if($unreadCount > 0): ?>
                        <span class="badge bg-danger ms-2"><?php echo $unreadCount; ?></span>
                    <?php endif; ?>
                </a>

                <!-- Settings Section -->
                <div class="sb-sidenav-menu-heading">Settings</div>
                <a class="nav-link" href="settings.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                    Settings
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Admin
        </div>
    </nav>
</div>
