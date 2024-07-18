<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['loggedin']) || ($_SESSION['roll'] != 'Dean' && $_SESSION['roll'] != 'Lecturer')) {  
    header('Location: ../index.php');
    exit();
}

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

$userID = $_SESSION['userID'];
$sql = "SELECT news.NewsID, news.Title, news.Content, news.DatePublished, category.CategoryName, user.Name AS UserName, user.ProfilePicture AS UserProfilePicture 
        FROM news 
        JOIN category ON news.CategoryID = category.CategoryID 
        JOIN user ON news.UserID = user.UserID 
        WHERE news.UserID = ?
        ORDER BY news.DatePublished DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/images/ruhuna.png">
    <title>UOR - NEWSLINE</title>
    <link rel="stylesheet" href="../assets/CSS/style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<h1><img src="../assets/images/ruhuna.png" alt="Ruhuna University Logo" class="nav_logo_img">UOR - NEWSLINE</h1>

<div class="user_menu">
    <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
    <div class="center_buttons">
        <?php if ($_SESSION['roll'] == 'Dean'): ?>
            <a href="admin.php" class="button">Inbox</a>
        <?php elseif ($_SESSION['roll'] == 'Lecturer'): ?>
            <a href="lecturer.php" class="button">Inbox</a>
        <?php endif; ?>
        <a href="add_news.php" class="button">Create News</a>
    </div>
    <div class="profile_menu">
        <?php if (!empty($profilePicture)): ?>
            <a href="admin_dashboard.php">
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" class="profile_picture">
            </a>
        <?php else: ?>
            <a href="admin_dashboard.php">
                <img src="<?php echo htmlspecialchars('../assets/images/pro.png'); ?>" alt="Default Profile Picture" class="profile_picture">
            </a>
        <?php endif; ?>
        <a href="logout.php" class="button">Logout</a>
    </div>
</div>

<section>
    <h2>Send News</h2>
    <div class="news-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <article>
                <div class="news-user-info">
                    <?php if (!empty($row['UserProfilePicture'])): ?>
                        <img src="<?php echo htmlspecialchars($row['UserProfilePicture']); ?>" alt="User Profile Picture" class="news-user-picture">
                    <?php else: ?>
                        <img src="<?php echo htmlspecialchars('../assets/images/pro.png'); ?>" alt="Default Profile Picture" class="news-user-picture">
                    <?php endif; ?>
                    <span><?php echo htmlspecialchars($row['UserName']); ?></span>
                </div>
                <h3><?php echo htmlspecialchars($row['Title']); ?></h3>
                <p><?php echo htmlspecialchars($row['Content']); ?></p>
                <small>Category: <?php echo htmlspecialchars($row['CategoryName']); ?> | Published on: <?php echo htmlspecialchars($row['DatePublished']); ?></small>
                <div class="news-actions">
                    <a href="edit_news.php?id=<?php echo $row['NewsID']; ?>" class="abutton"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                    <a href="delete_news.php?id=<?php echo $row['NewsID']; ?>" class="abutton" onclick="return confirm('Are you sure you want to delete this news?');"><i class="fa fa-trash"></i> Delete</a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
