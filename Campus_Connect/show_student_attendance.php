<!DOCTYPE html>
<html>
<head>
    <title>Student Attendance</title>
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
        #header {
            background-color: rgba(255, 255, 255, 0.7);
            color: #0066cc;
            margin-top: 2px;
            margin-bottom: 10px;
            padding: 2px;
            text-align: center;
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
            margin-left: 10px;
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
        #profile {
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 20px auto;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #profile img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        #profile h2 {
            margin: 10px 0;
            color: #0066cc;
        }
        #profile p {
            margin: 5px 0;
            font-size: 18px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        .low-attendance {
            color: red;
        }
        .high-attendance {
            color: blue;
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
        <a href="student.php">Home</a>
        <a href="show_student_attendance.php">Attendance</a>
        <a href="show_student_result.php">Results</a> 
        <a href="index.php">Logout</a>
    </div>
    <div id="profile">
        <h2>Student Attendance</h2>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Subject ID</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php
          session_start();
            require 'teacher_database_connection.php';
            $student_name=$_SESSION['username'];
            $sql234="SELECT student_id FROM student_data WHERE student_name='$student_name'";
            $result234=mysqli_query($link,$sql234);
            if ($result234 && mysqli_num_rows($result234) > 0) {
                $row1 = mysqli_fetch_assoc($result234);
                $student_id= $row1['student_id'];
            } else {
                echo "Error retrieving student_id or no data found: " . mysqli_error($link);
                exit;
            }
            // Fetch attendance data
            $sql = "SELECT * FROM attendance WHERE student_id= '$student_id'";
            $result = $link->query($sql);
            
            $attendance_data = [];
            $total_classes = 0;
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $student_id = $row['student_id'];
                    $subject_id = $row['subject_id'];
                    // Replace subject ID with subject name
                    switch ($subject_id) {
                        case 1:
                            $subject_id = 'Maths';
                            break;
                        case 2:
                            $subject_id = 'EGD';
                            break;
                        case 3:
                            $subject_id = 'Physics';
                            break;
                        case 4:
                            $subject_id = 'Maths';
                            break;
                        case 5:
                            $subject_id = 'Physics';
                            break;
                        case 6:
                            $subject_id = 'PPS';
                            break;
                        case 7:
                            $subject_id = 'Maths';
                            break;
                        case 8:
                            $subject_id = 'Physics';
                            break;
                        case 9:
                            $subject_id = 'Chemistry';
                            break;
                    }
                    $row['subject_id'] = $subject_id;
                    $status = $row['status'];
                    
                    if (!isset($attendance_data[$student_id][$subject_id])) {
                        $attendance_data[$student_id][$subject_id] = ['Present' => 0, 'Total' => 0];
                    }
                    
                    if ($status == 'Present') {
                        $attendance_data[$student_id][$subject_id]['Present']++;
                    }
                    $attendance_data[$student_id][$subject_id]['Total']++;
                    $total_classes++;
                    
                    echo "<tr>";
                    echo "<td>{$row['student_id']}</td>";
                    echo "<td>{$row['subject_id']}</td>";
                    echo "<td>{$row['date']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No attendance records found.</td></tr>";
            }
            ?>
        </table>
        <h2>Attendance Percentage</h2>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Subject ID</th>
                <th>Attendance Percentage</th>
            </tr>
            <?php
            foreach ($attendance_data as $student_id => $subjects) {
                foreach ($subjects as $subject_id => $data) {
                    $percentage = ($data['Present'] / $data['Total']) * 100;
                    $class = $percentage < 75 ? 'low-attendance' : 'high-attendance';
                    
                    echo "<tr>";
                    echo "<td>{$student_id}</td>";
                    echo "<td>{$subject_id}</td>";
                    echo "<td class='{$class}'>" . number_format($percentage, 2) . "%</td>";
                    echo "</tr>";
                }
            }
            
            $link->close();
            ?>
        </table>
        <?php
        // Play audio based on attendance percentage
        $audio_file = ($percentage < 75) ? 'Tuta_hua_saaz.mp3' : 'Nacho_Nacho.mp3';
        echo "<audio src='{$audio_file}' type='audio/mp3' autoplay></audio>";
        ?>
</body>
</html>
