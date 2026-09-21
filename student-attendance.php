<?php

session_start();

include "connection.php";


/* Student Login Check */

if(!isset($_SESSION['student_id']))
{
    header("Location: student-login.php");
    exit();
}


$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$class = $_SESSION['class'];


/* Total Present */

$present_query = mysqli_query($conn,

"SELECT COUNT(*) AS total
 FROM attendance
 WHERE student_id='$student_id'
 AND status='Present'"

);

$present_data = mysqli_fetch_assoc($present_query);

$present = $present_data['total'];


/* Total Absent */

$absent_query = mysqli_query($conn,

"SELECT COUNT(*) AS total
 FROM attendance
 WHERE student_id='$student_id'
 AND status='Absent'"

);

$absent_data = mysqli_fetch_assoc($absent_query);

$absent = $absent_data['total'];


/* Attendance Records */

$result = mysqli_query($conn,

"SELECT *
 FROM attendance
 WHERE student_id='$student_id'
 ORDER BY attendance_date DESC"

);

?>

<!DOCTYPE html>

<html>

<head>

<title>My Attendance</title>

<style>

body{
    font-family:Arial;
    background:#f2f2f2;
    margin:0;
}

.header{
    background:#004aad;
    color:white;
    padding:20px;
    text-align:center;
}

.info{
    width:90%;
    margin:20px auto;
    background:white;
    padding:20px;
    box-shadow:0 0 8px #ccc;
    border-radius:10px;
}

.cards{
    width:90%;
    margin:20px auto;
    display:flex;
    gap:20px;
}

.card{
    background:white;
    padding:20px;
    flex:1;
    text-align:center;
    border-radius:10px;
    box-shadow:0 0 8px #ccc;
}

.card h2{
    margin:5px;
}

table{
    width:90%;
    margin:20px auto;
    border-collapse:collapse;
    background:white;
}

th,td{
    border:1px solid #ccc;
    padding:12px;
    text-align:center;
}

th{
    background:#004aad;
    color:white;
}

.present{
    color:green;
    font-weight:bold;
}

.absent{
    color:red;
    font-weight:bold;
}

.back{
    text-align:center;
    margin:30px;
}

.back a{
    background:#004aad;
    color:white;
    padding:10px 20px;
    text-decoration:none;
    border-radius:5px;
}

</style>

</head>


<body>


<div class="header">

<h1>📅 My Attendance</h1>

</div>


<div class="info">

<h3>
Student Name:
<?php echo htmlspecialchars($student_name); ?>
</h3>

<h3>
Class:
<?php echo htmlspecialchars($class); ?>
</h3>

</div>


<div class="cards">


<div class="card">

<h2>🟢 Present</h2>

<h2>
<?php echo $present; ?>
</h2>

</div>


<div class="card">

<h2>🔴 Absent</h2>

<h2>
<?php echo $absent; ?>
</h2>

</div>


<div class="card">

<h2>📊 Total</h2>

<h2>
<?php echo $present + $absent; ?>
</h2>

</div>


</div>


<table>

<tr>

<th>Date</th>

<th>Class</th>

<th>Status</th>

</tr>


<?php

if(mysqli_num_rows($result) > 0)
{

    while($row = mysqli_fetch_assoc($result))
    {

?>

<tr>

<td>
<?php echo $row['attendance_date']; ?>
</td>

<td>
<?php echo $row['class']; ?>
</td>

<td>

<?php

if($row['status'] == "Present")
{
    echo "<span class='present'>Present</span>";
}
else
{
    echo "<span class='absent'>Absent</span>";
}

?>

</td>

</tr>

<?php

    }

}
else
{

?>

<tr>

<td colspan="3">
No Attendance Record Found
</td>

</tr>

<?php

}

?>

</table>


<div class="back">

<a href="student-dashboard.php">
⬅ Back to Dashboard
</a>

</div>


</body>

</html>