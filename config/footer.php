<footer class="footer">
    <h4>Designed by Tyler Ramey for CPSC 365 - Muskingum University</h4>
    <div class="nav-links">
        <?php
        session_start();
        echo '<a href="index.php">Home</a>';
        if ($_SESSION['admin'] == 1) {
            echo '<a href="admin.php">Admin Page</a>';
        }
        ?>
    </div>
</footer>
