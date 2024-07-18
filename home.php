<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

// Redirect based on user role
if ($_SESSION['roll'] == 'Dean') {
    header('Location: ./Admin/admin.php');
    exit();
} elseif ($_SESSION['roll'] == 'Student') {
    header('Location: student.php');
    exit();
} elseif ($_SESSION['roll'] == 'Lecturer') {
    header('Location: ./Admin/lecturer.php');
    exit();
} else {
    // If role is undefined, log out
    header('Location: logout.php');
    exit();
}
?>
