<?php
session_start();
include 'connection.php';

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
    header('Location: logout.php');
    exit();
}
?>
