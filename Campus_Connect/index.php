<!DOCTYPE html>
<html>
<head>
    <title>CampusConnect.com</title>
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
        table {
            float: right; /* Float the table to the right */
            margin-top: 160px;
            margin-right: 80px;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.7);;
            border-radius: 20px;
            box-shadow:  0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Set a fixed width for the table */
        }
        th, td {
            padding: 15px 20px; /* Increase padding for better spacing */
            font-size: 28px; /* Decrease font size slightly */
            text-align: center; /* Center-align text */
        }
        th {
            color: #0066cc; /* Change header text color */
            font-weight: bold; /*Add font weight for emphasis */
        }
        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }
        button {
            padding: 10px 20px;
            background-color: #0066cc;
            color: white;
            border: none;
            cursor: pointer;
            font-family:  sans-serif;
            font-size: 18px;
            border-radius: 5px;
        }
        button:hover{
            background-color: #0052a3;
        }
    </style>
</head>
<body>
    <form action="index.php" method="POST">
    <table>
        <tr> 
            <th colspan="2" style="border: 0cm; ">Welcome To CampusConnect </th>
        </tr>
        <tr>
            <td>
                <img src="teacher.png" alt="teacher" >
            </td>
            <td>
                <img src="student.png" alt="student" >
            </td>
        </tr>
        <tr>
            <td style="border: 0cm;">
                <div class="buttons">
                    <button name="role" id="role" value="teacher">Teacher</button>
                </div>               
            </td>
            <td style="border: 0cm;">
                <div class="buttons">
                    <button name="role" id="role" value="student">Student</button>
                </div>               
            </td>
        </tr>
    </table>
    </form>
    <?php 
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST['role'])){
            $role = $_POST['role'];
            if($role === 'teacher'){
                ob_clean();
                require_once("teacherlogin.php");
            } 
            else if($role === 'student'){
                ob_clean();
                require_once("studentlogin.php");
            }
        }
    }
    ?>
</body>
</html>