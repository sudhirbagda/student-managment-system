<?php
require('teacher_database_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST['date']; 
    $subject_id = $_POST['subject_id']; 
    $attendance_data = $_POST['attendance']; // array of student_id => status

    // Check if connection to the database is successful
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Debugging: Check if subject_id is set and not empty
    if (empty($subject_id)) {
        die("subject_id is not set or is empty.");
    }

    // Verify if subject_id exists in the subjects table
    $subject_check_query = "SELECT COUNT(*) FROM subjects WHERE subject_id = ? ";
    if ($subject_stmt = mysqli_prepare($link, $subject_check_query)) {
        mysqli_stmt_bind_param($subject_stmt, "i", $subject_id);
        mysqli_stmt_execute($subject_stmt);
        mysqli_stmt_bind_result($subject_stmt, $subject_exists);
        mysqli_stmt_fetch($subject_stmt);
        mysqli_stmt_close($subject_stmt);

        if ($subject_exists == 0) {
            die("Invalid subject_id: $subject_id. It does not exist in the subjects table.");
        }
    } else {
        die("Error preparing statement for subject check: " . mysqli_error($link));
    }
    require 'teacher.php';
    // Process each attendance record
    foreach ($attendance_data as $student_id => $status) {
        // Optional: Verify if student_id exists in the students table
        $student_check_query = "SELECT COUNT(*) FROM student_data WHERE student_id = ?";
        if ($student_stmt = mysqli_prepare($link, $student_check_query)) {
            mysqli_stmt_bind_param($student_stmt, "i", $student_id);
            mysqli_stmt_execute($student_stmt);
            mysqli_stmt_bind_result($student_stmt, $student_exists);
            mysqli_stmt_fetch($student_stmt);
            mysqli_stmt_close($student_stmt);

            if ($student_exists == 0) {
                echo "Invalid student_id: $student_id. It does not exist in the students table.<br>";
                continue;
            }
        } else {
            echo "Error preparing statement for student check: " . mysqli_error($link) . "<br>";
            continue;
        }

        // Prepare the attendance insert query
        $attendance_query = "
            INSERT INTO attendance (student_id, subject_id, date, status) 
            VALUES (?, ?, ?, ?);
        ";

        if ($stmt = mysqli_prepare($link, $attendance_query)) {
            mysqli_stmt_bind_param($stmt, "iiss", $student_id, $subject_id, $date, $status);
            if (mysqli_stmt_execute($stmt)) {
                echo "Record inserted for student_id: $student_id <br>";  
            } else {
                echo "Error inserting record for student_id: $student_id - " . mysqli_error($link) . "<br>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement for student_id: $student_id - " . mysqli_error($link) . "<br>";
        }
    }
  
    echo "Attendance process completed.";
} else {
    echo "Invalid request method.";
}
?>
