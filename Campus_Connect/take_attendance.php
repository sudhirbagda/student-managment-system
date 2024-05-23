<!DOCTYPE html>
<html>
<head>
    <title>Take Attendance</title>
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
            text-align: left;
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
        #attendance-form {
            margin: 20px auto;
            width: 80%;
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        #attendance-form table {
            width: 100%;
            border-collapse: collapse;
        }
        #attendance-form th, #attendance-form td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        #attendance-form th {
            background-color: #f2f2f2;
        }
        #attendance-form input[type='radio'] {
            margin-right: 10px;
        }
        #attendance-form input[type='submit'] {
            margin-top: 10px;
            padding: 8px 20px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        #attendance-form input[type='submit']:hover {
            background-color: #0056a4;
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
    <div id="attendance-form">
        <?php
        require('teacher_database_connection.php');

        if (isset($_GET['branch_id']) && isset($_GET['date']) && isset($_GET['subject_id'])) {
            $branch_id = $_GET['branch_id'];
            if($branch_id == 1){ $branch_id = 'Civil';}
            elseif($branch_id == 2){ $branch_id = 'Computer';}
            elseif($branch_id == 3){ $branch_id = 'Chemical';}
            $date = $_GET['date'];
            $subject_id = $_GET['subject_id'];
            $_SESSION['branch_id'] = $branch_id;
            $_SESSION['subject_id'] = $subject_id;
            $students_query = "
                SELECT student_id, student_name 
                FROM student_data 
                WHERE branch_id = ?;
            ";
            if ($stmt = mysqli_prepare($link, $students_query)) {
                mysqli_stmt_bind_param($stmt, "s", $branch_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $student_id, $student_name);

                echo "<form method='POST' action='record_attendance.php'>";
                echo "<table>";
                echo "<tr><th>Student Name</th><th>Attendance</th></tr>";

                while (mysqli_stmt_fetch($stmt)) {
                    echo "<tr>";
                    echo "<td>$student_name</td>";
                    echo "<td>";
                    echo "<input type='radio' name='attendance[$student_id]' value='Present' required> Present ";
                    echo "<input type='radio' name='attendance[$student_id]' value='Absent'> Absent ";
                    echo "<input type='radio' name='attendance[$student_id]' value='Leave'> Leave ";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                echo "<input type='hidden' name='date' value='$date'>";
                echo "<input type='hidden' name='subject_id' value='$subject_id'>";
                echo "<input type='submit' value='Submit Attendance'>";
                echo "</form>";

                mysqli_stmt_close($stmt);
            }
        }
        else{
            echo "something went wrong ";
        }
        ?>
    </div>
</body>
</html>
