<?php
session_start();
$errors = [];
$inputs = [];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'POST') {
    $name = isset($_POST['name']) ? filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $mobile = isset($_POST['mobile']) ? filter_var(trim($_POST['mobile']), FILTER_SANITIZE_STRING) : '';
    $reason = isset($_POST['reason']) ? filter_var(trim($_POST['reason']), FILTER_SANITIZE_STRING) : '';
    
    if (!$name) {
        $errors['name'] = 'Please enter name';
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email';
    }
    if (!$mobile || (strlen($mobile) !== 10)) {
        $errors['mobile'] = 'Please enter a valid mobile number';
    }
   
    if(!$reason){
        $errors['reason'] = 'Please enter Reason'; 
    }
    
    if (count($errors) === 0) {
        include 'teacher_database_connection.php';
        
        $sql = "INSERT INTO contact (name, email, mobile, reason) VALUES (?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_email, $param_mobile, $param_reason);
            
            $param_name = $name;
            $param_email = $email;
            $param_mobile = $mobile;
            $param_reason = $reason; 
            
            if (mysqli_stmt_execute($stmt)) {
                header("location: teacher.php?contact=success");
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <style>
        .error{
            color:red;
            font: 1em sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background-image: url('welcome.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }
        #header {
            background-color: rgba(255, 255, 255, 0.7);
            color:#0066cc;
            margin-top: 2px;
            margin-bottom: 10px;
            text-align:center;
            padding: 2px;
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
            color: #0066cc;
            margin-right: 10px;
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
        }
        .container {
            background-color: rgba(255, 255, 255, 0.7);
            margin: 20px auto;
            padding: 20px;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #0066cc;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 5px;
        }
        input[type="submit"]:hover {
            background-color: #0052a3;
        }
    </style>
</head>
<body>
    <div id="header0">
        <a href="feedback_form.php">Feedback</a>
        <a href="contactus_form.php">Contact Us</a>
    </div>
    <div id="header">
        <h2>Welcome to CampusConnect</h2>
    </div>
    <div id="navbar">
        <a href="teacher.php">Home</a>
        <a href="student_attendance.php">Attendance</a>
        <a href="student_results.php">Results</a>
        <a href="index.php">Logout</a>
    </div>
    <div class="container">
        <h1>Contact Us Form</h1>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" placeholder="Enter your name" >
    <?php if(isset($errors['name'])) echo "<p class='error'>{$errors['name']}</p>"; ?>

    <label for="email">Email Id:</label>
    <input type="text" name="email" id="email" placeholder="abc@gmail.com" >
    <?php if(isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?>
    
    <label for="mobile">Mobile Number:</label>
    <input type="tel" name="mobile" placeholder="+91 1234567890" >
    <?php if(isset($errors['mobile'])) echo "<p class='error'>{$errors['mobile']}</p>"; ?>
   

    <label for="reason">Reason For Contact:</label>
    <textarea name="reason" rows="6" cols="60"></textarea>
    <?php if(isset($errors['reason'])) echo "<p class='error'>{$errors['reason']}</p>"; ?>

    <button type="submit">Submit</button>
</form>

    </div>
</body>
</html>