<?php
session_start();
include 'connection.php';

// Check if user is logged in and is a student
if (!isset($_SESSION['loggedin']) || $_SESSION['roll'] != 'Student') {
    header('Location: login.php');
    exit();
}

// Fetch the profile picture of the logged-in user
$sql = "SELECT ProfilePicture FROM user WHERE Email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$profilePicture = $row['ProfilePicture'];
$stmt->close();

$category = isset($_GET['category']) ? intval($_GET['category']) : 1;

$sql = "SELECT news.Title, news.Content, news.DatePublished, category.CategoryName, 
        user.Name AS UserName, user.ProfilePicture AS UserProfilePicture, user.Roll AS UserRole 
        FROM news 
        JOIN category ON news.CategoryID = category.CategoryID 
        JOIN user ON news.UserID = user.UserID 
        WHERE news.CategoryID = ? ORDER BY news.DatePublished DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $category);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/images/ruhuna.png">
    <title>UOR - NEWSLINE</title>
    <link rel="stylesheet" href="./assets/CSS/style2.css">
</head>
<body>
    <h1><img src="./assets/images/ruhuna.png" alt="Rajarata University Logo" class="nav_logo_img">UOR - NEWSLINE Student Panel</h1>
    <div class="user_menu">
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
        <nav>
            <a href="student.php?category=1" class="<?php echo $category == 1 ? 'active' : ''; ?>">General</a>
            <a href="student.php?category=2" class="<?php echo $category == 2 ? 'active' : ''; ?>">Sports</a>
            <a href="student.php?category=3" class="<?php echo $category == 3 ? 'active' : ''; ?>">Academic</a>
        </nav>
        <div class="profile_menu">
            <?php if (!empty($profilePicture)): ?>
                <a href="dashboard.php">
                    <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" class="profile_picture">
                </a>
            <?php else: ?>
                <a href="dashboard.php">
                    <img src="./assets/images/pro.png" alt="Default Profile Picture" class="profile_picture">
                </a>
            <?php endif; ?>
            <a href="logout.php" class="button">Logout</a>
        </div>
    </div>
    <section class="news-section">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="news-row">
                    <article>
                        <div class="news-user-info">
                            <?php 
                            $userProfilePicture = $row['UserProfilePicture'];
                            if ($row['UserRole'] == 'Dean' || $row['UserRole'] == 'Lecturer') {
                                $userProfilePicture = str_replace('../', '', $userProfilePicture); 
                            }
                            ?>
                            <?php if (!empty($userProfilePicture)): ?>
                                <img src="<?php echo htmlspecialchars($userProfilePicture); ?>" alt="User Profile Picture" class="news-user-picture">
                            <?php else: ?>
                                <img src="./assets/images/pro.png" alt="Default Profile Picture" class="news-user-picture">
                            <?php endif; ?>
                            <span><?php echo htmlspecialchars($row['UserName']); ?></span>
                        </div>
                        <h2><?php echo htmlspecialchars($row['Title']); ?></h2>
                        <p><?php echo htmlspecialchars($row['Content']); ?></p>
                        <small>Category: <?php echo htmlspecialchars($row['CategoryName']); ?> | Published on: <?php echo htmlspecialchars($row['DatePublished']); ?></small>
                    </article>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No news available in this category</p>
        <?php endif; ?>
    </section>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
