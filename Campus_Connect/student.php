<?php
// Start session to access session variables
session_start();

require('teacher_database_connection.php');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: studentlogin.php');
    exit();
}

// Fetch student data based on session ID or other identifier
$name = $_SESSION['username']; // Assuming the student ID is stored in the session

$sql = "SELECT * FROM student_data WHERE student_name = ? ";
if ($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $name);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            $student = mysqli_fetch_assoc($result);
        } else {
            echo "No student found with this name.";
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
mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student</title>
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
        #header {
            background-color: rgba(255, 255, 255, 0.7);
            color: #0066cc;
            margin-top: 2px;
            margin-bottom: 10px;
            padding: 2px;
            text-align: center;
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
            color: #0066cc;
            margin-left: 10px;
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
        }
        #profile {
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #profile img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        #profile h2 {
            margin: 10px 0;
            color: #0066cc;
        }
        #profile p {
            margin: 5px 0;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div id="header0">
        <a href="feedback_form.php">Feedback</a>
        <a href="contact_form.php">Contact Us</a>
    </div>
    <div id="header">
        <h2>Welcome to CampusConnect</h2>
    </div>
    <div id="navbar">
        <a href="student.php">Home</a>
        <a href="show_student_attendance.php">Attendance</a>
        <a href="show_student_result.php">Results</a>
        <a href="index.php">Logout</a>
    </div>

    <div id="profile">
        <img src="<?php echo $student['profile_photo']; ?>" alt="Profile Photo">
        <h2><?php echo $student['student_name']; ?></h2>
        <p><strong>ID:</strong> <?php echo $student['student_id']; ?></p>
        <p><strong>Branch:</strong> <?php echo $student['branch_id']; ?></p>
        <p><strong>Mobile:</strong> <?php echo $student['mobile']; ?></p>
        <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
    </div>
</body>
</html>
