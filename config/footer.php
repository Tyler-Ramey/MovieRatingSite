<footer class="footer">
    <h4>Designed by Tyler Ramey for CPSC 365 - Muskingum University</h4>
    <?php
    session_start();
    if ($_SESSION['admin'] == 1) {
        echo '<a href="admin.php">Admin Page</a>';
    }
    ?>
</footer>
