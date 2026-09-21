<?php

session_start();
include "connection.php";


/* STUDENT LOGIN CHECK */

if(!isset($_SESSION['student']))
{
    header("Location: student-login.php");
    exit();
}


/* STUDENT ID */

$student_id = intval($_SESSION['student_id']);


/* GET STUDENT DETAILS */

$sql = "SELECT *
        FROM students
        WHERE id='$student_id'
        LIMIT 1";

$result = mysqli_query($conn, $sql);


if(!$result)
{
    die("Database Error: " . mysqli_error($conn));
}


$student = mysqli_fetch_assoc($result);


if(!$student)
{
    die("Student details not found.");
}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Student Profile</title>


<style>

body
{
    margin:0;
    font-family:Arial;
    background:#f2f2f2;
}


/* HEADER */

.header
{
    background:#004aad;
    color:white;
    padding:25px;
    text-align:center;
}


.header h1
{
    margin:0;
}


/* PROFILE BOX */

.profile
{
    width:600px;
    max-width:90%;
    margin:35px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}


.profile h2
{
    text-align:center;
    color:#004aad;
    margin-bottom:25px;
}


/* DETAILS */

.detail
{
    display:flex;
    border-bottom:1px solid #ddd;
    padding:14px 5px;
}


.label
{
    width:40%;
    font-weight:bold;
    color:#555;
}


.value
{
    width:60%;
}


/* BUTTON */

.back
{
    display:block;
    width:200px;
    margin:25px auto 0;
    padding:12px;
    text-align:center;
    background:#004aad;
    color:white;
    text-decoration:none;
    border-radius:5px;
}


.back:hover
{
    background:#003580;
}

</style>

</head>


<body>


<!-- HEADER -->

<div class="header">

<h1>👤 Student Profile</h1>

<p>S.K.L Public School</p>

</div>



<!-- PROFILE -->

<div class="profile">

<h2>📋 Personal Details</h2>


<div class="detail">

<div class="label">
Student ID
</div>

<div class="value">

<?php

echo htmlspecialchars(
    $student['id']
);

?>

</div>

</div>



<div class="detail">

<div class="label">
Name
</div>

<div class="value">

<?php

echo htmlspecialchars(
    $student['name']
);

?>

</div>

</div>



<div class="detail">

<div class="label">
Father Name
</div>

<div class="value">

<?php

echo htmlspecialchars(
    $student['father_name']
);

?>

</div>

</div>



<div class="detail">

<div class="label">
Class
</div>

<div class="value">

<?php

echo htmlspecialchars(
    $student['class']
);

?>

</div>

</div>



<div class="detail">

<div class="label">
Mobile
</div>

<div class="value">

<?php

echo htmlspecialchars(
    $student['mobile']
);

?>

</div>

</div>



<div class="detail">

<div class="label">
Address
</div>

<div class="value">

<?php

echo htmlspecialchars(
    $student['address']
);

?>

</div>

</div>



<div class="detail">

<div class="label">
Date of Birth
</div>

<div class="value">

<?php

echo htmlspecialchars(
    $student['dob']
);

?>

</div>

</div>



<a
class="back"
href="student-dashboard.php"
>

⬅ Back to Dashboard

</a>


</div>


</body>

</html>