<?php
include('teacher_database_connection.php');

$username = "";
$password = "";
$error = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'username' and 'password' keys exist in the POST request
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = mysqli_real_escape_string($link, $_POST['username']);
        $password = mysqli_real_escape_string($link, $_POST['password']);
        
        // Simple SQL query
        $sql = "SELECT * FROM student_data WHERE student_name = '$username' AND password = '$password'";
        $result = mysqli_query($link, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            session_start();
            // Store the username in the session
            $_SESSION["username"] = $username;
            
            // Redirect to the student page
            header('Location: student.php');
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "";
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
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
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        table {
            border-collapse: collapse;
            width: 300px;
            background-color: rgba(255, 255, 255, 0.7); /* Background color with transparency */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
        }
        table td {
            padding: 10px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #0066cc; /* Heading color */
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #0066cc; /* Button background color */
            color: #fff; /* Button text color */
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0052a3; /* Button background color on hover */
        }
        h4 {
            margin-top: 10px;
            font-size: 17px;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <form action="studentlogin.php" method="POST">
        <div class="container">
            <table>
                <tr>
                    <td colspan="2">
                        <h1>Student Login</h1>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" >
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>"/>
                        <small>Note: Please enter a password consisting of exactly 4 digits.</small>
                    </td>
                </tr>
                <?php if (!empty($error)): ?>
                <tr>
                    <td colspan="2" class="error">
                        <?php echo htmlspecialchars($error); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td colspan="2">
                        <input type="submit" id="button" name="button" value="Login">
                    </td>
                </tr>
                
                <tr>
                    <td><br>
                        <h4>Are you a new user?</h4>
                    </td>
                    <td>
                        <a href="student_registration_process.php" alt="registration" style="text-decoration:none; color:#0066cc">Register</a>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</body>
</html>
