<?php

session_start();

include 'connection.php';



if (!isset($_SESSION['loggedin']) || ($_SESSION['roll'] != 'Dean' && $_SESSION['roll'] != 'Lecturer')) {
    header('Location: ../login.php');
    exit();
}



$email = $_SESSION['email']; 


$sql = "SELECT * FROM user WHERE email = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

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
    <link rel="icon" type="image/png" href="../assets/images/ruhuna.png">
    <title>UOR - NEWSLINE</title>
    <link rel="stylesheet" href="../assets/CSS/admin_dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap">
</head>

<body>

    <h1><img src="../assets/images/ruhuna.png" alt="Rajarata University Logo" class="nav_logo_img">UOR - NEWSLINE</h1>

    <div class="user_menu">

        <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
        <nav>
        <?php if ($_SESSION['roll'] == 'Dean'): ?>
            <a href="admin.php">Inbox</a>
        <?php elseif ($_SESSION['roll'] == 'Lecturer'): ?>
            <a href="lecturer.php" class="button">Inbox</a>
        <?php endif; ?>
            <a href="add_news.php">Create News</a>
            <a href="sent_news.php">Send News</a>
        </nav>
        <div class="profile_menu">

        <a href="logout.php" class="button">Logout</a>

        </div>

    </div>


    <div class="dashboard_wrapper">
        <div class="dashboard_container">
            <div class="profile_section">
                <img src="<?php echo isset($user['ProfilePicture']) ? $user['ProfilePicture'] : '../assets/images/pro.png'; ?>" alt="Profile Picture" class="profile_picture">
                <h2><?php echo htmlspecialchars($user['Name']); ?></h2>
            </div>
            <div class="profile_details">
                <h3>User Details</h3>
                <p><i class="fas fa-user info-icon"></i> Name: <?php echo htmlspecialchars($user['Name']); ?></p>
                <p><i class="fas fa-envelope info-icon"></i> Email: <?php echo htmlspecialchars($user['Email']); ?></p>
                <p><i class="fas fa-id-badge info-icon"></i> UserID: <?php echo htmlspecialchars($user['UserID']); ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</body>

</html>