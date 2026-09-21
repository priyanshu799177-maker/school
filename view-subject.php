<?php
include "connection.php";

$result = mysqli_query($conn,"SELECT * FROM subjects ORDER BY id DESC");

?>

<!DOCTYPE html>
<html>
<head>
<title>View Subjects</title>

<style>

body{
font-family:Arial;
background:#f2f2f2;
}

table{
width:80%;
margin:30px auto;
border-collapse:collapse;
background:white;
}

th,td{
border:1px solid black;
padding:10px;
text-align:center;
}

th{
background:#004aad;
color:white;
}

a{
text-decoration:none;
padding:5px 10px;
background:#004aad;
color:white;
border-radius:5px;
}

.delete{
background:red;
}

</style>

</head>

<body>

<h2 align="center">📚 Subject List</h2>

<table>

<tr>
<th>ID</th>
<th>Subject Name</th>
<th>Subject Code</th>
<th>Action</th>
</tr>


<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['subject_name']; ?>
</td>

<td>
<?php echo $row['subject_code']; ?>
</td>

<td>

<a href="edit-subject.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<a class="delete" href="delete-subject.php?id=<?php echo $row['id']; ?>">
Delete
</a>

</td>

</tr>

<?php
}
?>

</table>

</body>
</html>