<?php
require_once('teacher_database_connection.php');

const NAME_REQUIRED = "Please Enter Your Name.";
const ID_REQUIRED = "Please Enter Your ID.";
const ID_INVALID = "Please Enter Valid ID.";
const PASSWORD_REQUIRED = "Please Enter Your Password.";
const PASSWORD_INVALID = "Please Enter Valid Password.";
const SUBJECT_REQUIRED = "Please Enter Your Subject.";
const MOBILE_NO_REQUIRED = "Please Enter Your Mobile Number.";
const MOBILE_NO_INVALID = "Please Enter Valid Mobile Number.";
const EMAIL_REQUIRED = "Please Enter Your Email.";
const EMAIL_INVALID = "Please Enter Valid Email.";
const PHOTO_REQUIRED = "Please Upload Your Photo.";
const PHOTO_INVALID = "Please Upload a Valid Image File (JPG, JPEG, PNG, GIF).";

$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);
$mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

$inputs['name'] = $name;
$inputs['id'] = $id;
$inputs['password'] = $password;
$inputs['subject'] = $subject;
$inputs['mobile'] = $mobile;
$inputs['email'] = $email;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate name
    if (!$name) {
        $errors['name'] = NAME_REQUIRED;
    } elseif (trim($name) === '') {
        $errors['name'] = NAME_REQUIRED;
    }

    // Validate ID
    if (!$id) {
        $errors['id'] = ID_REQUIRED;
    } elseif (strlen($id) != 10) {
        $errors['id'] = ID_INVALID;
    }

    // Validate password
    if (!$password) {
        $errors['password'] = PASSWORD_REQUIRED;
    } elseif (strlen($password) != 4) {
        $errors['password'] = PASSWORD_INVALID;
    }

    // Validate subject
    if (!$subject) {
        $errors['subject'] = SUBJECT_REQUIRED;
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

    // Handle file upload
    if (!isset($_FILES["photo"]) || $_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
        $errors['photo'] = PHOTO_REQUIRED;
    } else {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check === false) {
            $errors['photo'] = PHOTO_INVALID;
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            $errors['photo'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errors['photo'] = PHOTO_INVALID;
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $errors['photo'] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // If no errors, proceed with registration (e.g., save to database)
    if (empty($errors)) {
        $sql = "INSERT INTO teacher_data (name, password, id, subject, mobile, email, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $password, $id, $subject, $mobile, $email, $target_file);
            if (mysqli_stmt_execute($stmt)) {
                echo "Data has been saved successfully";
                header('Location: teacherlogin.php');
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    }
}
?>
