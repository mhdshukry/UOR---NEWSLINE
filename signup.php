<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password confirmation
    if ($password !== $confirm_password) {
        die('Passwords do not match');
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection configuration
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "pnl";

    // Create connection
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email already exists
    $checkEmailSql = "SELECT * FROM user WHERE Email = ?";
    $checkEmailStmt = $conn->prepare($checkEmailSql);
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailResult = $checkEmailStmt->get_result();

    if ($checkEmailResult->num_rows > 0) {
        die('Email already exists');
    }

    // Handle profile picture upload
    $profilePicture = null;

    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];

        // Validate file type
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            die('Invalid file type. Only JPG, JPEG, PNG, GIF files are allowed.');
        }

        // Validate file size (max 5MB)
        if ($fileSize > 5242880) {
            die('File size exceeds the maximum limit of 5MB.');
        }

        $currentUserRole = 'Student'; 

        if (isset($_SESSION['Dean']) && $_SESSION['Dean'] === true) {
            $currentUserRole = 'Dean';
        }

        if (isset($_SESSION['Lecturer']) && $_SESSION['Lecturer'] === true) {
            $currentUserRole = 'Lecturer';
        }

        if ($currentUserRole === 'Dean' || $currentUserRole === 'Lecturer') {
            $uploadDir = '../uploads/'; 
        } else {
            $uploadDir = './uploads/'; 
        }

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $profilePicture = $uploadDir . uniqid() . '.' . $fileExtension;

        if (!move_uploaded_file($fileTmpPath, $profilePicture)) {
            die('Failed to move uploaded file.');
        }
    }

    $sql = "INSERT INTO user (Name, Email, Password, Roll, ProfilePicture) VALUES (?, ?, ?, 'Student', ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $profilePicture);

    if ($stmt->execute()) {
        echo "New record created successfully";
        header('Location: index.php');
        exit;
    } else {
        echo "Error executing the statement: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
