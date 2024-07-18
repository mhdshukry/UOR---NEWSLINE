<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email']; 


$sql = "SELECT student.*, user.ProfilePicture, user.Name AS UserName 
        FROM student 
        JOIN user ON student.UserID = user.UserID 
        WHERE user.Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    die('User not found');
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/images/ruhuna.png">
    <title>UOR - NEWSLINE</title>
    <link rel="stylesheet" href="./assets/CSS/dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>
<body>
    <h1><img src="./assets/images/ruhuna.png" alt="Rajarata University Logo" class="nav_logo_img">UOR - NEWSLINE Student Panel</h1>
    <div class="user_menu">
        <span>Welcome, <?php echo htmlspecialchars($student['UserName']); ?></span>
        <nav>
            <a href="student.php?category=1" class="<?php echo isset($_GET['category']) && $_GET['category'] == '1' ? 'active' : ''; ?>">General</a>
            <a href="student.php?category=2" class="<?php echo isset($_GET['category']) && $_GET['category'] == '2' ? 'active' : ''; ?>">Sports</a>
            <a href="student.php?category=3" class="<?php echo isset($_GET['category']) && $_GET['category'] == '3' ? 'active' : ''; ?>">Academic</a>
        </nav>
        <div class="profile_menu">
            <a href="logout.php" class="button">Logout</a>
        </div>
    </div>

    <div class="dashboard_wrapper">
        <div class="dashboard_container">
            <div class="profile_section">
                <img src="<?php echo isset($student['ProfilePicture']) ? $student['ProfilePicture'] : './assets/images/pro.png'; ?>" alt="Profile Picture" class="profile_picture">
                <h2><?php echo htmlspecialchars($student['Name']); ?></h2>
            </div>
            <div class="profile_details">
                <h3>User Details</h3>
                <p><i class="fas fa-user info-icon"></i> Name: <?php echo htmlspecialchars($student['Name']); ?></p>
                <p><i class="fas fa-envelope info-icon"></i> Email: <?php echo htmlspecialchars($student['Email']); ?></p>
                <p><i class="fas fa-id-badge info-icon"></i> UserID: <?php echo htmlspecialchars($student['UserID']); ?></p>
                <p><i class="fas fa-calendar info-icon"></i> Date of Birth: <?php echo htmlspecialchars($student['DOB']); ?></p>
                <p><i class="fas fa-map-marker-alt info-icon"></i> Address: <?php echo htmlspecialchars($student['Address']); ?></p>
                <p><i class="fas fa-phone info-icon"></i> Contact No: <?php echo htmlspecialchars($student['Contact_No']); ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
