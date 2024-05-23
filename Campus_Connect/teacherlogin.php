<?php
// Start the session and include the database connection
session_start();
include('teacher_database_connection.php');

// Initialize variables
$username = "";
$password = "";
$error = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'username' and 'password' keys exist in the POST request
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Escape the input data to prevent SQL injection
        $username = mysqli_real_escape_string($link, $_POST['username']);
        $password = mysqli_real_escape_string($link, $_POST['password']);
        
        // Simple SQL query to check the user's credentials
        $sql = "SELECT * FROM teacher_data WHERE name = '$username' AND password = '$password'";
        $result = mysqli_query($link, $sql);
        
        // Check if the user exists
        if (mysqli_num_rows($result) == 1) {
            // Store the username in the session
            $_SESSION["username"] = $username;
            
            // Redirect to the teacher page
            header('Location: teacher.php');
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please enter both username and password.";
    }
}

// Close the database connection
mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('welcome.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #333;
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
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table td {
            padding: 10px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #0066cc;
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
            background-color: #0066cc;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0052a3;
        }

        .error {
            color: red;
            text-align: center;
        }

        h4 {
            margin-top: 10px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="teacherlogin.php" method="POST" >
            <table>
                <tr>
                    <td colspan="2">
                        <h1>Teacher Login</h1>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        <small>Note : Please enter a password consisting of exactly 4 digits.</small>
                    </td>
                </tr>
                <tr>
                <td colspan="2" class="error" syle="color:red;">
                        <?php 
                            echo $error;
                        ?>
                    </td>
                </tr>
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
                       <a href="teacher_registration_process.php" alt="registration" style="text-decoration:none; color:#0066cc">Register</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
