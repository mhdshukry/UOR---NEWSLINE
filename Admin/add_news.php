<?php
session_start();
include 'connection.php';

date_default_timezone_set('Asia/Colombo');

if (!isset($_SESSION['loggedin']) || ($_SESSION['roll'] != 'Dean' && $_SESSION['roll'] != 'Lecturer')) {
    header('Location: ../student/login.php');
    exit();
}

$sql = "SELECT ProfilePicture FROM user WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$_SESSION['profilePicture'] = $row['ProfilePicture']; // Set profile picture in session variable
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $userID = $_SESSION['userID'];
    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO news (Title, Content, DatePublished, CategoryID, UserID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $content, $date, $category, $userID);

    if ($stmt->execute()) {
        echo "News posted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="../assets/images/ruhuna.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOR - NEWSLINE</title>
    <link rel="stylesheet" href="../assets/CSS/style4.css">
</head>
<body>

<h1><img src="../assets/images/ruhuna.png" alt="Rajarata University Logo" class="nav_logo_img">UOR - NEWSLINE</h1>
        
<div class="user_menu">
    <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
    
    <div class="center_menu">
        <?php if ($_SESSION['roll'] == 'Dean'): ?>
            <a href="admin.php" class="button">Inbox</a>
        <?php elseif ($_SESSION['roll'] == 'Lecturer'): ?>
            <a href="lecturer.php" class="button">Inbox</a>
        <?php endif; ?>
        <a href="sent_news.php" class="button">Send News</a>
    </div>

    <div class="profile_menu">
        <?php if (!empty($_SESSION['profilePicture'])): ?>
            <a href="admin_dashboard.php">
                <img src="<?php echo htmlspecialchars($_SESSION['profilePicture']); ?>" alt="Profile Picture" class="profile_picture">
            </a>
        <?php else: ?>
            <a href="admin_dashboard.php">
                <img src="../assets/images/pro.png" alt="Default Profile Picture" class="profile_picture">
            </a>
        <?php endif; ?>
        <a href="logout.php" class="button">Logout</a>
    </div>
</div>

<section class="home">
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <label for="content">Content:</label>
        <textarea name="content" id="content" required></textarea>
        <label for="category">Category:</label>
        <select name="category" id="category">
            <option value="1">General</option>
            <option value="2">Sports</option>
            <option value="3">Academic</option>
        </select>
        <div class="btns">
            <button type="submit">Post News</button>
        </div>
    </form>
</section>

</body>
</html>
