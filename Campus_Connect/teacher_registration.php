<!DOCTYPE HTML>
<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('welcome.png');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }
        form {
            border: 1px solid black;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.7);
            width: 800px;
            max-width: 600px;
        }
        form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0066cc;
        }
        form div {
            margin-bottom: 10px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="file"],
        select,
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
            width: 100px;
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
    </style>
</head>
<body>
<div class="container">
    <form action="teacher_registration_process.php" method="POST" enctype="multipart/form-data">
        <h2>Teacher Registration</h2>
        <div>
            <label for="name">Name:</label><br>
            <input type="text" name="name" id="name" placeholder="Full Name" value="<?php echo htmlspecialchars($inputs['name'] ?? ''); ?>"><br>
            <small class="error"><?php echo $errors['name'] ?? ''; ?></small>
        </div>

        <div>
            <label for="id">ID:</label><br>
            <input type="text" name="id" id="id" placeholder="ID (10 characters)" value="<?php echo htmlspecialchars($inputs['id'] ?? ''); ?>"><br>
            <small class="error"><?php echo $errors['id'] ?? ''; ?></small>
        </div>

        <div>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" placeholder="Password (4 characters)" value="<?php echo htmlspecialchars($inputs['password'] ?? ''); ?>"><br>
            <small class="error"><?php echo $errors['password'] ?? ''; ?></small>
        </div>

        <div>
            <label for="subject">Subject:</label><br>
            <select name="subject" id="subject">
                <option value="">Select Subject</option>
                <option value="Maths" <?php echo isset($inputs['subject']) && $inputs['subject'] == 'maths' ? 'selected' : ''; ?>>Maths</option>
                <option value="Physics" <?php echo isset($inputs['subject']) && $inputs['subject'] == 'physics' ? 'selected' : ''; ?>>Physics</option>
                <option value="PPS" <?php echo isset($inputs['subject']) && $inputs['subject'] == 'pps' ? 'selected' : ''; ?>>PPS</option>
                <option value="EGD" <?php echo isset($inputs['subject']) && $inputs['subject'] == 'EGD' ? 'selected' : ''; ?>>EGD</option>
                <option value="Chemistry" <?php echo isset($inputs['subject']) && $inputs['subject'] == 'Chemistry' ? 'selected' : ''; ?>>Chemistry</option>
            </select><br>
            <small class="error"><?php echo $errors['subject'] ?? ''; ?></small>
        </div>

        <div>
            <label for="mobile">Mobile No.:</label><br>
            <input type="text" name="mobile" id="mobile" placeholder="Mobile Number" value="<?php echo htmlspecialchars($inputs['mobile'] ?? ''); ?>"><br>
            <small class="error"><?php echo $errors['mobile'] ?? ''; ?></small>
        </div>

        <div>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" placeholder="Email Address" value="<?php echo htmlspecialchars($inputs['email'] ?? ''); ?>"><br>
            <small class="error"><?php echo $errors['email'] ?? ''; ?></small>
        </div>

        <div>
            <label for="photo">Upload Photo:</label><br>
            <input type="file" name="photo" id="photo"><br>
            <small class="error"><?php echo $errors['photo'] ?? ''; ?></small>
        </div>

        <div>
            <input type="submit" name="register" value="Register">
        </div>
    </form>
</div>
</body>
</html>
