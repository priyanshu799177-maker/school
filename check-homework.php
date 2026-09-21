<?php
include "connection.php";
if(isset($_POST['save']))
{
    $student = $_POST['student_id'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    for($i=0; $i<count($student); $i++)
    {
        mysqli_query($conn,
        "INSERT INTO homework_status
        (student_id,status,remark,checked_date)
        VALUES
        ('$student[$i]','$status[$i]','$remark[$i]',CURDATE())");
    }

    echo "<script>alert('Homework Status Saved Successfully');</script>";
}

$result = mysqli_query($conn,"SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
<title>Check Homework</title>

<style>
table{
width:100%;
border-collapse:collapse;
}

table,th,td{
border:1px solid black;
padding:10px;
text-align:center;
}

th{
background:#004aad;
color:white;
}

select,input{
padding:5px;
}
</style>

</head>

<body>

<h2>Homework Checking</h2>
<form method="POST">

<table>
<br><br>

<button type="submit" name="save">Save Homework Status</button>

</form>

<tr>

<th>ID</th>
<th>Name</th>
<th>Class</th>
<th>Status</th>
<th>Remark</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['class']; ?></td>

<td>

<input type="hidden" name="student_id[]" value="<?php echo $row['id']; ?>">

<select name="status[]">
<option value="Complete">Complete</option>
<option value="Incomplete">Incomplete</option>
</select>

<input type="text" name="remark[]" placeholder="Teacher Remark">
</td>

</tr>

<?php

}

?>

</table>

</body>
</html>