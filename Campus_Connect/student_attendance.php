<!DOCTYPE html>
<html>
<head>
    <title>Teacher</title>
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
            font-weight: bold;
            color: #0066cc;
        }
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }
        select:hover, select:focus {
            border-color: #0066cc;
            outline: none;
        }
        option {
            padding: 10px;
            background-color: #fff;
            color: #333;
        }
        input[type="submit"] {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #005bb5;
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
    <div>
    <?php
    session_start();
    require('teacher_database_connection.php');

    // Get teacher name from session
    $teacher_name = $_SESSION["username"];

    // Query to retrieve the subject taught by the teacher
    $sql123 = "SELECT subject FROM teacher_data WHERE name = '$teacher_name'";
    $result123 = mysqli_query($link, $sql123);

    if ($result123 && mysqli_num_rows($result123) > 0) {
        $row123 = mysqli_fetch_assoc($result123);
        $subject_name = $row123['subject'];

        // Query to retrieve branches associated with the subject
        $sql321 = "SELECT DISTINCT branches.branch_id, branches.branch_name 
                   FROM branches 
                   JOIN subjects ON branches.branch_id = subjects.branch_id 
                   WHERE subjects.subject_name = '$subject_name'";
        $result321 = mysqli_query($link, $sql321);

        if ($result321 && mysqli_num_rows($result321) > 0) {
            echo "<form method='GET' action='student_attendance1.php'>";
            echo "<label for='branch'>Select Branch:</label>";
            echo "<select name='branch_id' id='branch'>";
            while ($row = mysqli_fetch_assoc($result321)) {
                $branch_id = $row['branch_id'];
                $branch_name = $row['branch_name'];
                echo "<option value='$branch_id'>$branch_name</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Next'>";
            echo "</form>";
        } else {
            echo "No branches found for the subject.";
        }
    } else {
        echo "Subject data not found for the teacher.";
    }

    // Close the database connection
    mysqli_close($link);
    ?>
    </div>
</body>
</html>
