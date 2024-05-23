<?php
session_start();
require('teacher_database_connection.php');
require 'teacher.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = $_POST['subject_id'];
    $exam_type = $_POST['exam_type'];
    $marks = $_POST['marks'];
    $branch_id = $_POST['branch_id'];

    // Check if all required data is present
    if (empty($subject_id) || empty($exam_type) || empty($marks) || empty($branch_id)) {
        echo "Required data is missing.";
        exit;
    }

    // Prepare the insert statement
    $insert_query = "
        INSERT INTO student_marks (branch_id, student_id, subject_id, exam_type, marks)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE marks = VALUES(marks)
    ";

    if ($stmt = mysqli_prepare($link, $insert_query)) {
        mysqli_stmt_bind_param($stmt, "iiisi", $branch_id, $student_id, $subject_id, $exam_type, $mark);

        foreach ($marks as $student_id => $mark) {
            mysqli_stmt_execute($stmt);
        }

        echo "Marks recorded successfully.";
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($link);
    }

    mysqli_close($link);
} else {
    echo "Invalid request method.";
}

?>
