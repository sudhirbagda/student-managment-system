<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
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
        /* Style for the form */
        form {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 8px;
            margin: 20px auto;
            max-width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056a3;
        }
    </style>
</head>
<body>
    <div id="header0">
        <a href="feedback_form.php">Feedback</a>
        &nbsp;
        <a href="contact_form.php">Contact Us</a>
        <h2 style="text-align:center;">Welcome to CampusConnect</h2>
    </div>
    <div id="navbar">
        <a href="teacher.php">Home</a>
        <a href="student_attendance.php">Attendance</a>
        <a href="student_results.php">Results</a>
        <a href="index.php">Logout</a>
    </div>
    <div>
    <?php
session_start();
require('teacher_database_connection.php');

if (isset($_GET['branch_id'])) {
    $branch_id = $_GET['branch_id'];

    // Assuming the teacher's name is stored in the session
    if (isset($_SESSION['username'])) {
        $teacher_name = $_SESSION['username'];

        // Query to retrieve the subject id associated with the teacher's name
        $subject_id_query = "
            SELECT no 
            FROM teacher_data 
            WHERE name = ?;
        ";

        if ($stmt = mysqli_prepare($link, $subject_id_query)) {
            mysqli_stmt_bind_param($stmt, "s", $teacher_name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $subject_id);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($link);
        }
    } else {
        echo "Teacher name is not set in session.";
    }

    echo "<form method='GET' action='take_attendance.php'>";
    echo "<label for='date'>Select Date:</label>";
    echo "<input type='date' name='date' id='date' required>";
    echo "<input type='hidden' name='branch_id' value='$branch_id'>";
    echo "<input type='hidden' name='subject_id' value='$subject_id'>";
    echo "<input type='submit' value='Check Attendance'>";
    echo "</form>";
}
?>
    </div>
</body>
</html>
