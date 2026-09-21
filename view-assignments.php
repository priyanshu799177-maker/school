<?php
include "connection.php";

$sql = "SELECT 
            teacher_assignments.id,
            teachers.name AS teacher_name,
            teacher_assignments.class,
            subjects.subject_name
        FROM teacher_assignments
        JOIN teachers 
        ON teacher_assignments.teacher_id = teachers.id
        JOIN subjects 
        ON teacher_assignments.subject_id = subjects.id
        ORDER BY teacher_assignments.id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>

<title>Teacher Assignments</title>

<style>

body{
    font-family:Arial;
    background:#f2f2f2;
}

h2{
    text-align:center;
}

table{
    width:90%;
    margin:30px auto;
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

</style>

</head>

<body>

<h2>👨‍🏫 Teacher Assignments</h2>

<table>

<tr>
    <th>ID</th>
    <th>Teacher</th>
    <th>Class</th>
    <th>Subject</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['teacher_name']; ?>
</td>

<td>
<?php echo $row['class']; ?>
</td>

<td>
<?php echo $row['subject_name']; ?>
</td>

</tr>

<?php
}

?>

</table>

</body>

</html>