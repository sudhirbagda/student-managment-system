<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Record Marks</title>
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
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
            border-radius: 5px;
        }
        th {
            background-color: #0066cc;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #0066cc;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }
        input[type="number"]:hover, input[type="number"]:focus {
            border-color: #0066cc;
            outline: none;
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

    // Ensure branch_id and exam_type are set
    if (!isset($_GET['branch_id']) || !isset($_GET['exam_type'])) {
        echo "Branch ID or Exam Type not set.";
        exit;
    }

    $branch_id = intval($_GET['branch_id']);
    $exam_type = $_GET['exam_type'];

    // Retrieve teacher's name and subject_id from session
    if (!isset($_SESSION['username'])) {
        echo "User not logged in.";
        exit;
    }

    $teacher_name = $_SESSION['username'];

    // Query to retrieve the subject id associated with the teacher's name
    $subject_id_query = "SELECT subject FROM teacher_data WHERE name = ?";
    if ($stmt = mysqli_prepare($link, $subject_id_query)) {
        mysqli_stmt_bind_param($stmt, "s", $teacher_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $subject_id);
        if (mysqli_stmt_fetch($stmt)) {
            // Subject ID fetched successfully
        } else {
            echo "Error fetching subject ID: " . mysqli_error($link);
            exit;
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($link);
        exit;
    }

    // Retrieve subject name
    $subject_name_query = "SELECT subject_id FROM subjects WHERE subject_name = '$subject_id' AND branch_id = '$branch_id'";
    $subject_name_result = mysqli_query($link, $subject_name_query);
    if ($subject_name_result && mysqli_num_rows($subject_name_result) > 0) {
        $row = mysqli_fetch_assoc($subject_name_result);
        $subject_name = $row['subject_id'];
    } else {
        echo "Error retrieving subject name or no data found: " . mysqli_error($link);
        exit;
    }

    // Query to retrieve branch name
    $sql123 = "SELECT branch_name FROM branches WHERE branch_id = '$branch_id'";
    $result_123 = mysqli_query($link, $sql123);
    if ($result_123 && mysqli_num_rows($result_123) > 0) {
        $row_123 = mysqli_fetch_assoc($result_123);
        $branch_name = $row_123['branch_name'];
    } else {
        echo "Error retrieving branch name or no data found: " . mysqli_error($link);
        exit;
    }

    // Query to retrieve students in the selected branch
    $students_query = "SELECT student_id, student_name FROM student_data WHERE branch_id = '$branch_name'";
    $students_result = mysqli_query($link, $students_query);

    if ($students_result && mysqli_num_rows($students_result) > 0) {
        echo "<form method='POST' action='record_marks.php'>";
        echo "<table>";
        echo "<tr><th colspan='2' style='text-align:center;'>$subject_name</th></tr>";
        echo "<tr><th>Student Name</th><th>Marks</th></tr>";

        // Display marks input fields based on exam type
        $max_marks = ($exam_type == 'external') ? 60 : 36;

        while ($row = mysqli_fetch_assoc($students_result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
            echo "<td><input type='number' name='marks[" . $row['student_id'] . "]' min='0' max='$max_marks' required></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<input type='hidden' name='subject_id' value='$subject_name'>";
        echo "<input type='hidden' name='branch_id' value='$branch_id'>";
        echo "<input type='hidden' name='exam_type' value='$exam_type'>";
        echo "<input type='submit' value='Submit Marks'>";
        echo "</form>";
    } else {
        echo "No students found for this branch.";
    }

    mysqli_close($link);
    ?>
    </div>
</body>
</html>
