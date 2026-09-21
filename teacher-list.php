<?php

include "connection.php";

$result = mysqli_query($conn,"SELECT * FROM teachers");

?>


<!DOCTYPE html>
<html>

<head>

<title>Teacher List</title>

<style>

table{

width:90%;
border-collapse:collapse;

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

</style>

</head>


<body>


<h2>Teacher List - S.K.L Public School</h2>


<table>


<tr>

<th>ID</th>

<th>Name</th>

<th>Subject</th>

<th>Mobile</th>

<th>Email</th>

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
<?php echo $row['name']; ?>
</td>


<td>
<?php echo $row['subject']; ?>
</td>


<td>
<?php echo $row['mobile']; ?>
</td>


<td>
<?php echo $row['email']; ?>
</td>


<td>

<a href="delete-teacher.php?id=<?php echo $row['id']; ?>">

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