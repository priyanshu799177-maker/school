<?php

session_start();
include "connection.php";


/* ===============================
   STUDENT LOGIN CHECK
================================ */

if(!isset($_SESSION['student']))
{
    header("Location: student-login.php");
    exit();
}


/* ===============================
   STUDENT DETAILS
================================ */

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$student_class = $_SESSION['class'];


/* ===============================
   GET STUDENT REMARKS
================================ */

$sql = "SELECT *
        FROM remarks
        WHERE student_id='$student_id'
        ORDER BY id DESC";


$result = mysqli_query($conn, $sql);


if(!$result)
{
    die("Database Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>My Remarks</title>


<style>

body
{
    margin:0;
    font-family:Arial, sans-serif;
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
    margin:0 0 10px 0;
}


/* MAIN BOX */

.box
{
    width:90%;
    margin:30px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}


h2
{
    color:#004aad;
}


/* TABLE */

table
{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}


th
{
    background:#004aad;
    color:white;
    padding:12px;
    border:1px solid #ccc;
}


td
{
    padding:12px;
    border:1px solid #ccc;
    text-align:center;
}


/* BACK BUTTON */

.back
{
    display:inline-block;
    background:#004aad;
    color:white;
    padding:10px 15px;
    border-radius:5px;
    text-decoration:none;
}


.back:hover
{
    background:#003580;
}


/* NO REMARK */

.no-remark
{
    text-align:center;
    padding:30px;
    color:#777;
}

</style>

</head>


<body>


<!-- ===============================
     HEADER
================================ -->

<div class="header">

<h1>📝 My Remarks</h1>

<p>

Student:
<strong>

<?php

echo htmlspecialchars($student_name);

?>

</strong>

</p>

<p>

Class:

<strong>

<?php

echo htmlspecialchars($student_class);

?>

</strong>

</p>

</div>



<!-- ===============================
     REMARKS
================================ -->

<div class="box">

<h2>📚 Teacher Remarks</h2>


<?php

if(mysqli_num_rows($result) == 0)
{

?>

<div class="no-remark">

<h3>📭 No Remarks Found</h3>

<p>
Abhi teacher ne koi remark add nahi kiya hai.
</p>

</div>

<?php

}
else
{

?>


<table>

<tr>

<th>Subject</th>

<th>Teacher</th>

<th>Remark</th>

<th>Date</th>

</tr>


<?php

while($row = mysqli_fetch_assoc($result))
{

?>


<tr>


<td>

<?php

echo htmlspecialchars(
    $row['subject']
);

?>

</td>


<td>

<?php

echo htmlspecialchars(
    $row['teacher_name']
);

?>

</td>


<td>

<?php

echo nl2br(
    htmlspecialchars(
        $row['remark']
    )
);

?>

</td>


<td>

<?php

echo htmlspecialchars(
    $row['remark_date']
);

?>

</td>


</tr>


<?php

}

?>


</table>


<?php

}

?>

</div>



<!-- ===============================
     BACK
================================ -->

<div class="box">

<a
class="back"
href="student-dashboard.php"
>

⬅ Back to Student Dashboard

</a>

</div>


</body>

</html>