<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['loggedin']) || ($_SESSION['roll'] != 'Dean' && $_SESSION['roll'] != 'Lecturer')) {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $newsID = $_GET['id'];
    $sql = "SELECT * FROM news WHERE NewsID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $newsID);
    $stmt->execute();
    $result = $stmt->get_result();
    $news = $result->fetch_assoc();
    $stmt->close();
}

$sqlProfile = "SELECT ProfilePicture FROM user WHERE Email = ?";
$stmtProfile = $conn->prepare($sqlProfile);
$stmtProfile->bind_param("s", $_SESSION['email']);
$stmtProfile->execute();
$resultProfile = $stmtProfile->get_result();
$rowProfile = $resultProfile->fetch_assoc();
$profilePicture = $rowProfile['ProfilePicture'];
$stmtProfile->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $newsID = $_POST['newsID'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    $sqlUpdate = "UPDATE news SET Title = ?, Content = ?, CategoryID = ?, LastUpdated = NOW() WHERE NewsID = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssii", $title, $content, $category, $newsID);

    if ($stmtUpdate->execute()) {
        if ($_SESSION['roll'] == 'Dean')
        {
            header('Location: admin.php');
        }else{
            header('Location: lecturer.php');
        }
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmtUpdate->close();
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
    <h1><img src="../assets/images/ruhuna.png" alt="Ruhuna University Logo" class="nav_logo_img">UOR - NEWSLINE</h1>
        
    <div class="user_menu">
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
        
        <!-- Profile Picture Display -->
        <div class="profile_menu">
            <?php if (!empty($profilePicture)): ?>
                <a href="admin_dashboard.php">
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" class="profile_picture">
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
            <input type="hidden" name="newsID" id="newsID" value="<?php echo htmlspecialchars($news['NewsID']); ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($news['Title']); ?>" required>
            <label for="content">Content:</label>
            <textarea name="content" id="content" required><?php echo htmlspecialchars($news['Content']); ?></textarea>
            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="1" <?php if ($news['CategoryID'] == 1) echo 'selected'; ?>>General</option>
                <option value="2" <?php if ($news['CategoryID'] == 2) echo 'selected'; ?>>Sports</option>
                <option value="3" <?php if ($news['CategoryID'] == 3) echo 'selected'; ?>>Academic</option>
            </select>
            <div class="btns">
                <button type="submit" name="update" class="btn-left">Update News</button>
                <button type="button" onClick="previous()" class="btn-right">Back</button>
            </div>
        </form>
    </section>

    <script>
        function previous() { 
            window.history.back(); 
        } 
    </script>
</body>
</html>

<?php
$conn->close();
?>
