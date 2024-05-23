<?php
// Database connection
require_once('teacher_database_connection.php');

// Start session to access session variables
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: teacherlogin.php');
    exit();
}

// Fetch teacher's details using name from session
$name = $_SESSION['username'];

$sql = "SELECT * FROM teacher_data WHERE name = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $name);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            $teacher = mysqli_fetch_assoc($result);
        } else {
            echo "No teacher found with this name.";
            exit();
        }
    } else {
        echo "Something went wrong. Please try again later.";
        exit();
    }
} else {
    echo "Something went wrong. Please try again later.";
    exit();
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Profile</title>
    <style>
      body {
            margin: 0;
            padding: 0;
            background-image: url('welcome.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }
        #header0 {
            background-color: rgba(255, 255, 255, 0.7);
            color: #0066cc;
            text-align: right;
            font-size: small;
            margin-top: 3px;
            margin-bottom: 0;
            padding: 1px 5px;
        }
        #header0 a {
            text-decoration: none;
        }
        #header0 h2 {
            font-size: 32px;
            text-align: center;
        }
        #navbar {
            background-color: rgb(87, 194, 226);
            padding: 6px;
        }
        #navbar a {
            color: white;
            margin-left: 10px;
            margin-right: 10px;
            text-decoration: none;
        }
        #navbar a:hover {
            color: #0066cc;
            background-color: aliceblue;
            padding: 8px;
            overflow: hidden;
            text-decoration: none;
        }
        .profile-container {
            background-color: rgba(255, 255, 255, 0.7);
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }
        .profile-container img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .profile-container h2 {
            color: #0066cc;
            margin-bottom: 20px;
        }
        .profile-container p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div id="header0">
        <a href="feedback_form.php">Feedback</a>
        &nbsp;
        <a href="contact_form.php">Contact Us</a>
        <h2>Welcome to CampusConnect</h2>
    </div>
    <div id="navbar">
        <a href="teacher.php">Home</a>
        <a href="student_attendance.php">Attendance</a>
        <a href="student_results.php">Results</a>
        <a href="index.php">Logout</a>
    </div>
    <div class="profile-container">
        <img src="<?php echo htmlspecialchars($teacher['photo']); ?>" alt="Teacher Photo">
        <h2><?php echo htmlspecialchars($teacher['name']); ?></h2>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($teacher['ID']); ?></p>
        <p><strong>Subject:</strong> <?php echo htmlspecialchars($teacher['subject']); ?></p>
        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($teacher['mobile']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($teacher['email']); ?></p>
    </div>
</body>
</html>