# S.K.L Public School Management System

A PHP + MySQL based School Management System developed for **S.K.L Public School**.

The project provides separate portals for the **Admin, Principal, Teacher, and Student** users and supports day-to-day school management activities such as students, teachers, class assignments, attendance, homework, notices, fees, gallery, and results.

---

## 🏫 School Information

**School:** S.K.L Public School  
**Address:** Udvat Khera, Mohanlal Ganj, Lucknow, Uttar Pradesh  
**Phone:** 9005495660, 7355205844  
**Email:** sklpublicschool1@gmail.com

---

## 🚀 Main Features

### 1. Home Page
- School introduction
- School contact information
- Address and location
- Login/navigation options
- School management system entry point

### 2. Admin Panel
Admin-level school management can include:
- Student management
- Teacher management
- Class/subject management
- Teacher assignments
- School notices
- Fees
- Gallery
- Results
- Attendance-related management

### 3. Principal Portal
The Principal has a separate secure login and dashboard.

Features currently included:
- Principal authentication
- Principal dashboard
- Manage Teachers
- Add Students
- Notice Board
- View Notices
- Fees
- Gallery
- Result Approval
- Attendance Report section
- School contact information
- Logout/session protection

### 4. Teacher Portal
Teachers have a separate login and dashboard.

Teacher login currently uses:
- Registered email
- Password

Teacher session stores:
- Teacher ID
- Teacher name
- Teacher email

Teacher features include:
- Teacher dashboard
- Class/subject assignments
- Attendance
- Homework upload
- Student/result-related work
- Class-wise data access

### 5. Student Portal
Students have a separate login and dashboard.

Student login uses:
- Username
- Password

Student features include:
- Student dashboard
- Attendance
- Homework
- Results
- School notices
- Other student information

### 6. Teacher Class Assignment
A teacher can be assigned to more than one class.

The system uses the `teacher_assignments` table to connect:
- Teacher
- Class
- Subject

This allows a teacher to work with multiple assigned classes.

### 7. Class-wise Data
The system is designed to show data according to the selected/assigned class.

This is especially important for:
- Attendance
- Students
- Homework
- Results
- Teacher assignments

### 8. Homework
Teachers can upload homework with:
- Homework title
- Description
- Last date
- PDF file
- Class
- Subject
- Teacher name

Uploaded PDF files are stored in the `uploads/` directory.

### 9. Notices
The system supports:
- Adding notices
- Viewing notices
- Publishing school announcements

### 10. Fees
Fee-related pages are included for managing school fee information and payments.

### 11. Gallery
School photos can be uploaded and displayed through the gallery section.

### 12. Result Approval
The Principal has a dedicated result approval section.

---

## 👥 User Roles

| User | Login | Main Access |
|---|---|---|
| Admin | Admin Login | Overall system management |
| Principal | Principal Login | School administration |
| Teacher | Teacher Login | Assigned classes, attendance, homework, etc. |
| Student | Student Login | Attendance, homework, results, notices |

---

## 🗂️ Important Project Files

Typical important files in the project include:

```text
SKL_School_System/
│
├── index.php
├── connection.php
│
├── principal-login.php
├── principal-dashboard.php
│
├── teacher-login.php
├── teacher-dashboard.php
│
├── student-login.php
├── student-dashboard.php
│
├── add-student.php
├── manage-teachers.php
│
├── add-notice.php
├── view-notice.php
│
├── add-fee.php
├── add-gallery.php
│
├── principal-result-approval.php
│
├── student-attendance.php
├── add-homework.php
│
├── logout.php
│
├── uploads/
│
└── README.md
```

> The exact list may vary depending on the latest files in the project.

---

## 🗄️ Database

The project uses **MySQL**.

The database shown during development is:

```text
school_db
```

Important tables used by the project include:

```text
principals
teachers
teacher_assignments
students
subjects
homework
homework_status
notices
fees
fee_payments
gallery
results
remarks
student_fees
```

---

## 👨‍🏫 Teacher Database Structure

The current teacher table uses fields such as:

```text
id
name
subject
mobile
email
password
```

Teacher login therefore uses the registered:

```text
Email + Password
```

The teacher's database `id` is stored in the session after successful login.

---

## 🔐 Login & Session Security

The project uses PHP sessions to protect dashboards.

Example:

```php
session_start();

if(!isset($_SESSION['teacher_id']))
{
    header("Location: teacher-login.php");
    exit();
}
```

Similar session protection is used for Principal and Student areas.

After successful login, the system redirects the user to the appropriate dashboard.

Logout should destroy the active session and return the user to the login page.

---

## ⚙️ Requirements

To run the project locally:

- Windows
- XAMPP
- Apache
- MySQL
- PHP
- phpMyAdmin
- Modern web browser

---

## 💻 Installation

### Step 1 — Install XAMPP

Install XAMPP and start:

```text
Apache
MySQL
```

### Step 2 — Copy Project

Place the project folder inside:

```text
C:\xampp\htdocs\
```

Example:

```text
C:\xampp\htdocs\SKL_School_System\
```

### Step 3 — Create Database

Open:

```text
http://localhost/phpmyadmin/
```

Create/import the database:

```text
school_db
```

Import the project's SQL database file if available.

### Step 4 — Configure Database Connection

Open:

```text
connection.php
```

Make sure the database connection matches your local MySQL configuration.

Typical local configuration:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "school_db";
```

Use the actual values configured on your XAMPP installation.

### Step 5 — Run Project

Open:

```text
http://localhost/SKL_School_System/
```

The home page should open.

---

## 🔑 Login Flow

### Principal

```text
Home
  ↓
Principal Login
  ↓
Principal Dashboard
```

### Teacher

```text
Home
  ↓
Teacher Login
  ↓
Teacher Dashboard
```

Teacher login:

```text
Email + Password
```

### Student

```text
Home
  ↓
Student Login
  ↓
Student Dashboard
```

Student login:

```text
Username + Password
```

---

## 📚 Teacher Assignment Flow

The intended flow is:

```text
Principal/Admin
      ↓
Assign Teacher
      ↓
Select Class
      ↓
Select Subject
      ↓
Teacher Login
      ↓
Teacher Dashboard
      ↓
Assigned Class Data
```

A teacher can have multiple assignments, for example:

```text
Teacher
 ├── Class 6 → English
 ├── Class 7 → English
 └── Class 8 → English
```

The application should use the selected/assigned class when displaying class-specific records.

---

## 📝 Homework Flow

```text
Teacher Login
      ↓
Teacher Dashboard
      ↓
Upload Homework
      ↓
Select/Use Assigned Class
      ↓
Enter Title
      ↓
Enter Description
      ↓
Set Last Date
      ↓
Upload PDF
      ↓
Save Homework
      ↓
Student Dashboard
      ↓
View Homework
```

---

## 📊 Result Flow

```text
Teacher/Admin
      ↓
Enter Result
      ↓
Principal
      ↓
Result Approval
      ↓
Student
      ↓
View Result
```

---

## 📅 Attendance Flow

```text
Teacher Login
      ↓
Select Assigned Class
      ↓
Select Students
      ↓
Mark Attendance
      ↓
Save
      ↓
Student Dashboard
      ↓
View Attendance
```

Class filtering is important so that selecting **Class 6** does not display **Class 7** students.

---

## 🔧 Common Troubleshooting

### 1. Page shows PHP code instead of the website

Make sure the file is being opened through Apache:

```text
http://localhost/SKL_School_System/
```

Do **not** open the PHP file directly from Windows Explorer.

Also make sure Apache is running in XAMPP.

---

### 2. Login says Invalid Username/Password

Check:
- Database name
- Table name
- Column names
- Email/username
- Password
- Database connection

For teachers, the current table structure uses:

```text
email
password
```

not a `username` field.

---

### 3. Dashboard opens without login

Make sure the dashboard contains the correct session check.

Example:

```php
if(!isset($_SESSION['principal']))
{
    header("Location: principal-login.php");
    exit();
}
```

---

### 4. Logout does not return to login

`logout.php` should destroy the session and redirect to the appropriate login/home page.

---

### 5. Wrong class data appears

Check that database queries use the selected class or the teacher's assignment.

For example, a class-specific query should filter by class instead of loading all students.

---

### 6. Homework does not appear for students

Check:
- Homework class
- Student class
- Subject
- Database record
- `uploads/` directory
- Student dashboard query

The homework query should match the student's class.

---

## 📁 Upload Directory

Homework PDF files are uploaded to:

```text
uploads/
```

Make sure this folder exists:

```text
C:\xampp\htdocs\SKL_School_System\uploads\
```

---

## 🔒 Security Improvements Recommended

For a production deployment, improve the current authentication system by:

- Using `password_hash()` for passwords
- Using `password_verify()` for login
- Using prepared statements instead of directly inserting user input into SQL
- Validating uploaded files
- Restricting PDF upload size/type
- Adding CSRF protection
- Validating user permissions on every protected page
- Preventing unauthorized access to another class's data
- Disabling detailed database errors on production

---

## 🌐 School Location

School location:

**Udvat Khera, Mohanlal Ganj, Lucknow, Uttar Pradesh**

Google Maps location can be linked from the school's Home/Contact page.

---

## 📞 Contact

**S.K.L Public School**

Phone:

```text
9005495660
7355205844
```

Email:

```text
sklpublicschool1@gmail.com
```

Address:

```text
Udvat Khera,
Mohanlal Ganj,
Lucknow, Uttar Pradesh
```

---

## 🎯 Project Objective

The main objective of the S.K.L Public School Management System is to provide a centralized web-based platform for managing school activities and providing separate access to administrators, principals, teachers, and students.

The system is intended to reduce manual work and make school information easier to manage and access.

---

## 🛠️ Technology Stack

```text
Frontend:
HTML
CSS
JavaScript

Backend:
PHP

Database:
MySQL

Local Server:
XAMPP / Apache

Database Management:
phpMyAdmin
```

---

## 📌 Development Notes

This project is being developed locally under:

```text
C:\xampp\htdocs\SKL_School_System\
```

The application uses PHP sessions for role-based login access and MySQL for storing school data.

