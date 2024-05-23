<?php
require('teacher_database_connection.php');

const NAME_REQUIRED = "Please Enter Your Name.";
const ID_REQUIRED = "Please Enter Your ID.";
const ID_INVALID = "Please Enter Valid ID.";
const PASSWORD_REQUIRED = "Please Enter Your Password.";
const PASSWORD_INVALID = "Please Enter Valid Password.";
const BRANCH_REQUIRED = "Please Enter Your Branch.";
const MOBILE_NO_REQUIRED = "Please Enter Your Mobile Number.";
const MOBILE_NO_INVALID = "Please Enter Valid Mobile Number.";
const EMAIL_REQUIRED = "Please Enter Your Email.";
const EMAIL_INVALID = "Please Enter Valid Email.";
const PHOTO_REQUIRED = "Please Upload Your Profile Photo.";
const PHOTO_INVALID = "Please Upload a Valid Image File.";

$errors = [];
$inputs = [];

$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$branch = filter_input(INPUT_POST, "branch", FILTER_SANITIZE_STRING);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

$inputs['student_name'] = $name;
$inputs['student_id'] = $id;
$inputs['password'] = $password;
$inputs['branch_id'] = $branch;
$inputs['mobile'] = $mobile;
$inputs['email'] = $email;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate name
    if (!$name) {
        $errors['student_name'] = NAME_REQUIRED;
    } elseif (trim($name) === '') {
        $errors['student_name'] = NAME_REQUIRED;
    }

    // Validate ID
    if (!$id) {
        $errors['student_id'] = ID_REQUIRED;
    } elseif (strlen($id) != 10) {
        $errors['student_id'] = ID_INVALID;
    }

    // Validate password
    if (!$password) {
        $errors['password'] = PASSWORD_REQUIRED;
    } elseif (strlen($password) != 4) {
        $errors['password'] = PASSWORD_INVALID;
    }

    // Validate branch
    if (!$branch) {
        $errors['branch_id'] = BRANCH_REQUIRED;
    }

    // Validate mobile
    if (!$mobile) {
        $errors['mobile'] = MOBILE_NO_REQUIRED;
    } elseif (!preg_match('/^\d{10}$/', $mobile)) {
        $errors['mobile'] = MOBILE_NO_INVALID;
    }

    // Validate email
    if (!$email) {
        $errors['email'] = EMAIL_REQUIRED;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = EMAIL_INVALID;
    }

    // Validate profile photo
    if (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] != UPLOAD_ERR_OK) {
        $errors['profile_photo'] = PHOTO_REQUIRED;
    } else {
        $photo = $_FILES['profile_photo'];
        $photo_name = basename($photo['name']);
        $photo_type = pathinfo($photo_name, PATHINFO_EXTENSION);
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($photo_type, $allowed_types)) {
            $errors['profile_photo'] = PHOTO_INVALID;
        }
    }

    // If no errors, proceed with registration (e.g., save to database)
    if (empty($errors)) {
        // Save the uploaded file
        $target_dir = "uploads/";
        $target_file = $target_dir . uniqid() . '.' . $photo_type;
        if (move_uploaded_file($photo['tmp_name'], $target_file)) {
            $sql = "INSERT INTO student_data (student_name, password, student_id, branch_id, mobile, email, profile_photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssssss", $name, $password, $id, $branch, $mobile, $email, $target_file);
            if(mysqli_stmt_execute($stmt)) {
                echo "Data has been saved successfully";
                header('Location: studentlogin.php');
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    }
}
}
?>
