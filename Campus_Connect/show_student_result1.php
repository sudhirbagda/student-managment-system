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
            $student_id = $student['student_id'];
        } else {
            echo "No student found with this name.";
            header('Location: show_student_result.php');
            exit();
        }
    } else {
        echo "Something went wrong. Please try again later.";
        header('Location: show_student_result.php');
        exit();
    }
} else {
    echo "Something went wrong. Please try again later.";
    header('Location: show_student_result.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_id = $_POST['subject_id'];
    $exam_type = $_POST['exam_type'];

    // Fetch results based on selected subject and exam type
    $results_sql = "SELECT * FROM student_marks WHERE student_id = ? AND subject_id = ? AND exam_type = ?";
    if ($stmt = mysqli_prepare($link, $results_sql)) {
        mysqli_stmt_bind_param($stmt, "iis", $student_id, $subject_id, $exam_type);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $marks = mysqli_fetch_assoc($result);
            } else {
                echo "No results found for the selected subject and exam type.";
                header('Location: show_student_result.php');
                exit();
            }
        } else {
            echo "Something went wrong. Please try again later.";
            header('Location: show_student_result.php');
            exit();
        }
    } else {
        echo "Something went wrong. Please try again later.";
        header('Location: show_student_result.php');
        exit();
    }
} else {
    header('Location: show_student_result.php');
    exit();
}
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
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
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
        <h2>Your Results</h2>
        <table>
            <tr>
                <th>Subject</th>
                <th>Exam Type</th>
                <th>Marks</th>
            </tr>
            <tr>
                <?php 
                 switch ($subject_id) {
                        case 1:
                            $subject_id = 'Maths';
                            break;
                        case 2:
                            $subject_id = 'EGD';
                            break;
                        case 3:
                            $subject_id = 'Physics';
                            break;
                        case 4:
                            $subject_id = 'Maths';
                            break;
                        case 5:
                            $subject_id = 'Physics';
                            break;
                        case 6:
                            $subject_id = 'PPS';
                            break;
                        case 7:
                            $subject_id = 'Maths';
                            break;
                        case 8:
                            $subject_id= 'Physics';
                            break;
                        case 9:
                            $$subject_id= 'Chemistry';
                            break;
                    }
                ?>
                <td><?php echo htmlspecialchars($subject_id); ?></td>
                <td><?php echo htmlspecialchars($marks['exam_type']); ?></td>
                <td><?php echo htmlspecialchars($marks['marks']); ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
