<?php
session_start();
include "connection.php";

$result = mysqli_query($conn,"SELECT * FROM notices ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Notices</title>

<style>

body{
font-family:Arial;
background:#f2f2f2;
}

table{
width:90%;
margin:auto;
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
padding:6px 10px;
background:red;
color:white;
border-radius:5px;
}

</style>

</head>

<body>

<h2 align="center">📢 All Notices</h2>

<table>

<tr>

<th>ID</th>
<th>Title</th>
<th>Notice</th>
<th>Date</th>
<th>Edit</th>
<th>Delete</th>

</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['notice']; ?></td>

<td><?php echo $row['notice_date']; ?></td>

<td>
<a href="edit-notice.php?id=<?php echo $row['id']; ?>">
✏️ Edit
</a>
</td>

<td>
<a href="delete-notice.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this notice?');">
🗑️ Delete
</a>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>