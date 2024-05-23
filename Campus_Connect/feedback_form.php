<?php
session_start();
$errors = [];
$inputs = [];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'GET') {
    $name = isset($_GET['name']) ? filter_var(trim($_GET['name']), FILTER_SANITIZE_STRING) : '';
    $email = isset($_GET['email']) ? filter_var(trim($_GET['email']), FILTER_SANITIZE_EMAIL) : '';
    $mobile = isset($_GET['mobile_no']) ? filter_var(trim($_GET['mobile_no']), FILTER_SANITIZE_STRING) : '';
    $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
    $rate = isset($_GET['rate']) ? $_GET['rate'] : '';
    $feedback = isset($_GET['feedback']) ? filter_var(trim($_GET['feedback']), FILTER_SANITIZE_STRING) : '';
    
    if (!$name) {
        $errors['name'] = 'Please enter name';
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email';
    }
    if (!$mobile || (strlen($mobile) !== 10)) {
        $errors['mobile_no'] = 'Please enter a valid mobile number';
    }
    if (!$gender) {
        $errors['gender'] = 'Please select gender';
    }
    if (!$rate) {
        $errors['rate'] = 'Please select rate';
    }
   
    if(!$feedback){
        $errors['feedback'] = 'Please enter feedback'; 
    }
    
    if (count($errors) === 0) {
        include 'teacher_database_connection.php';
        
        $sql = "INSERT INTO feedback (name, email, mobile_no, gender, rate, feedback) VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_email, $param_mobile, $param_gender, $param_rate, $param_feedback);
            
            $param_name = $name;
            $param_email = $email;
            $param_mobile = $mobile;
            $param_gender = $gender;
            $param_rate = $rate;
            $param_feedback = $feedback;
            
            if (mysqli_stmt_execute($stmt)) {
                header("location: feedback_form.php?feedback=success");
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
    <title>Feedback Form</title>
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
            h2{
                color:#0066cc;
            }
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
        h1, h2 {
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
        input[type="submit"],
        input[type="reset"] {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 5px;
        }
        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #0052a3;
        }
        .radio-group {
            display: flex;
            justify-content: space-around;
            margin: 10px 0;
        }
        .radio-group label {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div id="header0">
        <a href="feedback_form.php">Feedback</a>
        <a href="contact_form.php">Contact Us</a>
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
        <h1>CUSTOMER FEEDBACK FORM</h1>
        <p>Your opinion matters to us.<br>Please fill the following feedback form to give us valuable feedback.</p>
        <h2>Personal Info :</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Enter your name">
            <?php if(isset($errors['name'])) echo "<p class='error'>{$errors['name']}</p>"; ?>

            <label for="email">Email Id:</label>
            <input type="text" name="email" placeholder="abc@gmail.com">
            <?php if(isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?>

            <label for="mobile">Mobile Number:</label>
           <input type="tel" name="mobile_no" placeholder="+91 1234567890">
           <?php if(isset($errors['mobile_no'])) echo "<p class='error'>{$errors['mobile_no']}</p>"; ?>

            <label for="gender">Gender:</label>
            

            <div class="radio-group">
                <label for="male">Male</label>
                <input type="radio" name="gender" value="male">
                <label for="female">Female</label>
                <input type="radio" name="gender" value="female">
            </div>
            <?php if(isset($errors['gender'])) echo "<p class='error'>{$errors['gender']}</p>"; ?>
            

            <h2>Rate Our Site:</h2>
            <div class="radio-group">
                <label for="excellent">Excellent</label>
                <input type="radio" name="rate" value="excellent">
                <label for="average">Average</label>
                <input type="radio" name="rate" value="average">
                <label for="poor">Poor</label>
                <input type="radio" name="rate" value="poor">
            </div>
            <?php if(isset($errors['rate'])) echo "<p class='error'>{$errors['rate']}</p>"; ?>

            <h2>Give Detailed Feedback:</h2>
            <textarea name="feedback" rows="6" cols="60"></textarea>
            <?php if(isset($errors['feedback'])) echo "<p class='error'>{$errors['feedback']}</p>"; ?>

            <input type="submit" value="Submit">
            <input type="reset" value="Reset">
        </form>
    </div>
</body>
</html>