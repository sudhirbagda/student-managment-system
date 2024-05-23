**Campus Connect**
Project Overview
Campus Connect is a student management system developed using PHP and HTML. It enables teachers to add marks and attendance, while students can view their marks and attendance records. This project is designed for beginners to help them understand the basics of web development and database management.

Features
Teacher Functions:

Add marks for students
Add attendance records
Student Functions:

View marks
View attendance records
Installation
Prerequisites
A web server with PHP support (e.g., Apache, Nginx)
MySQL or MariaDB database
A web browser
Steps to Install
Clone the repository:

bash
Copy code
git clone https://github.com/yourusername/campus_connect.git
Navigate to the project directory:

bash
Copy code
cd Campus_Connect
Setup the Database:

Create a new database in MySQL:
sql
Copy code
CREATE DATABASE Campus_Connect;
Import the database schema:
bash
Copy code
mysql -u yourusername -p Campus_Connect < database/schema.sql
Deploy the Project:

Copy the project files to your web server's root directory.
Ensure your web server is running and navigate to http://localhost/campus_connect in your web browser.
Usage
Teacher Portal
Login: Teachers can log in using their credentials.
Add Marks: Navigate to the 'Add Marks' section, select a student, and enter their marks.
Add Attendance: Navigate to the 'Add Attendance' section, select a student, and mark their attendance.
Student Portal
Login: Students can log in using their credentials.
View Marks: Navigate to the 'View Marks' section to see the marks added by teachers.
View Attendance: Navigate to the 'View Attendance' section to see their attendance records.
Contributing
If you would like to contribute to this project, please fork the repository and submit a pull request. For major changes, please open an issue first to discuss what you would like to change.
