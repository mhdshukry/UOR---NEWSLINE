<?php
session_start();

$hostname = 'localhost';
$username = 'root';
$password = '';
$database_name = 'pnl';

// Establishing the connection
$conn = new mysqli($hostname, $username, $password, $database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    
    // Validate user credentials against the database
    $sql = "SELECT * FROM user WHERE Email = ?";
    $stmt = $conn->prepare($sql);

    // Check if the SQL statement was prepared successfully
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
                
                // Redirect to the home page
                header('Location: home.php');
                exit;
            } else {
                // Invalid credentials
                $error = 'Invalid username or password';
                header('Location: index.php');
                exit;
            }
        } else {
            // Invalid credentials
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
