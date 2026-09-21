<?php
session_start();

if(!isset($_SESSION['student']))
{
    header("Location: student-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Student Dashboard</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f2f2f2;
}

header{
    background:#004aad;
    color:white;
    padding:20px;
    text-align:center;
}

.stats{
    width:90%;
    margin:30px auto;
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

.card{
    background:white;
    padding:20px;
    text-align:center;
    border-radius:10px;
    box-shadow:0 0 8px #ccc;
}

.card h2{
    color:#004aad;
}

.card a{
    display:inline-block;
    background:#004aad;
    color:white;
    text-decoration:none;
    padding:10px 15px;
    border-radius:5px;
}

.logout a{
    background:red;
}

</style>

</head>

<body>

<header>

<h1>
Student Dashboard
</h1>

</header>


<section class="stats">


<div class="card">

<h2>👤 Profile</h2>

<p>View Student Profile</p>

<a href="student-profile.php">
View Profile
</a>

</div>


<div class="card">

<h2>📚 Homework</h2>

<p>Daily Homework</p>

<a href="student-homework.php">
Open Homework
</a>

</div>



<div class="card">

<h2>📝 Remarks</h2>

<p>View Teacher Remarks</p>

<a href="student-remarks.php">

View Remarks

</a>

</div>


<div class="card">

<h2>📅 Attendance</h2>

<p>Monthly Attendance</p>

<a href="student-attendance.php">
View Attendance
</a>

</div>

<div class="card">

<h2>📄 Result</h2>

<a href="student-result.php">

📄 Result

</a>
</div>


<div class="card">

<h2>💰 Fee Status</h2>

<p>View Fee Details</p>

<a href="student-fee.php">
View Fee
</a>

</div>


<div class="card">

<h2>📢 Notice</h2>

<p>Latest School Notices</p>

<a href="student-notices.php">
View Notices
</a>

</div>


<div class="card">

<h2>📸 Gallery</h2>

<p>School Photos</p>

<a href="gallery.php">
    📸 View Gallery
</a>

</div>

<div class="card logout">

<h2>🚪 Logout</h2>

<p>Logout from Student Account</p>

<a href="student-login.php">
Logout
</a>

</div>


</section>


<footer>

<p style="text-align:center;">
© 2026 S.K.L Public School
</p>

</footer>

</body>

</html>