<?php
$errors = [];
$inputs = [];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if($request_method === 'GET') {
    require('student_registration.php'); // Update file name to the new form
} elseif ($request_method === 'POST') {
    require('student_registration1.php');
    
    if (count($errors) > 0) {
        require('student_registration.php'); // Update file name to the new form
    } else {
        header('Location: studentlogin.php');
        exit();
    }
}
?>
