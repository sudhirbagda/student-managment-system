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
$name = $_SESSION['username']; // Assuming the student name is stored in the session

$sql = "SELECT * FROM student_data WHERE student_name = ?";
if ($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $name);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            $student = mysqli_fetch_assoc($result);
            $branch = $student['branch_id']; // Assuming branch is stored in the student_data table
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
if($branch=='Civil') { $branch = 1;}
if($branch=='Computer') { $branch = 2;}
if($branch=='Chemical') { $branch = 3;}
// Fetch subjects related to the student's branch
$subjects_sql = "SELECT * FROM subjects WHERE branch_id = ?";
$stmt = mysqli_prepare($link, $subjects_sql);
mysqli_stmt_bind_param($stmt, "s", $branch);
mysqli_stmt_execute($stmt);
$subjects_result = mysqli_stmt_get_result($stmt);

// Fetch exam types (assumed to be fixed types for simplicity)
$exam_types = ['sessional1', 'sessional2','sessional3','external'];

mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Results</title>
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
            margin: 0;
            padding: 10px 0;
            text-align: center;
        }
        #navbar {
            background-color: rgb(87, 194, 226);
            padding: 10px 0;
        }
        #navbar a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }
        #navbar a:hover {
            color: #0066cc;
            background-color: aliceblue;
            padding: 8px 12px;
            border-radius: 5px;
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
        #profile h2 {
            margin: 20px 0;
            color: #0066cc;
        }
        form {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #0066cc;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056aa;
        }
    </style>
</head>
<body>
    <div id="header">
        <h2>Welcome to CampusConnect</h2>
    </div>
    <div id="navbar">
        <a href="student.php">Home</a>
        <a href="show_student_attendance.php">Attendance</a>
        <a href="show_student_result1.php">Results</a>
        <a href="index.php">Logout</a>
    </div>
    <div id="profile">
        <h2>Check Your Results</h2>
        <form action="show_student_result1.php" method="post">
            <label for="subject">Select Subject:</label>
            <select id="subject" name="subject_id" required>
                <option value="">Select Subject</option>
                <?php while ($subject = mysqli_fetch_assoc($subjects_result)): ?>
                    <option value="<?php echo $subject['subject_id']; ?>"><?php echo $subject['subject_name']; ?></option>
                    
                <?php endwhile; ?>
            </select>
            <?php while ($subject = mysqli_fetch_assoc($subjects_result)): ?>
            <?php echo $subject['subject_id']; ?>
            <?php endwhile; ?>
            <label for="exam_type">Select Exam Type:</label>
            <select id="exam_type" name="exam_type" required>
                <option value="">Select Exam Type</option>
                <?php foreach ($exam_types as $exam_type): ?>
                    <option value="<?php echo $exam_type; ?>"><?php echo $exam_type; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Show Results</button>
        </form>
    </div>
</body>
</html>
