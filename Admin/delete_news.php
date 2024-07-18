<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['loggedin']) || ($_SESSION['roll'] != 'Dean' && $_SESSION['roll'] != 'Lecturer')) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $newsID = $_GET['id'];

    $sql = "DELETE FROM news WHERE NewsID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $newsID);

    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
} else {
    header('Location: admin.php');
    exit();
}

$conn->close();
?>
