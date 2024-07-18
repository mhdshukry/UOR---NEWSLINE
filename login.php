<?php
session_start();

$hostname = 'localhost';
$username = 'root';
$password = '';
$database_name = 'pnl';

$conn = new mysqli($hostname, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    
    $sql = "SELECT * FROM user WHERE Email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['Password'])) {
                // Authentication successful, start session
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $row['Email'];
                $_SESSION['name'] = $row['Name'];
                $_SESSION['roll'] = $row['Roll'];
                $_SESSION['userID'] = $row['UserID'];
                $_SESSION['profile_picture'] = $row['ProfilePicture'];
                
                header('Location: home.php');
                exit;
            } else {
                $error = 'Invalid username or password';
                header('Location: index.php');
                exit;
            }
        } else {
            $error = 'Invalid username or password'; 
            header('Location: index.php');
            exit;
        }
        
    } else {
        $error = 'Error in SQL statement: ' . $conn->error;
    }
    
    $conn->close();
}
?>
