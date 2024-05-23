<?php
$errors = [];
$inputs = [];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'GET') {
    require('teacher_registration.php'); // Update file name to the new form
} elseif ($request_method === 'POST') {
    require('teacher_registration1.php');
    
    if (count($errors) > 0) {
        require('teacher_registration.php'); // Update file name to the new form
    } else {
        header('Location: teacherlogin.php');
        exit();
    }
}
?>
