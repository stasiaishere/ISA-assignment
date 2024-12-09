<?php
session_start();
session_unset(); // Unsets all session variables
session_destroy(); // Destroys the session
header("Location: login.php"); // Redirects to login page after logout
exit();
?>
