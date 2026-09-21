<?php

include "connection.php";

if(isset($_POST['save']))
{

$name=$_POST['name'];
$subject=$_POST['subject'];
$mobile=$_POST['mobile'];
$email=$_POST['email'];
$password=$_POST['password'];


$sql="INSERT INTO teachers
(name,subject,mobile,email,password)

VALUES

('$name','$subject','$mobile','$email','$password')";


if(mysqli_query($conn,$sql))
{
echo "Teacher Added Successfully";
}
else
{
echo "Error";
}

}

?>


<html>

<head>
<title>Add Teacher</title>
</head>


<body>

<h2>Add Teacher</h2>


<form method="POST">


Name:
<input type="text" name="name">

<br><br>


Subject:
<input type="text" name="subject">

<br><br>


Mobile:
<input type="text" name="mobile">

<br><br>


Email:
<input type="email" name="email">

<br><br>


Password:
<input type="password" name="password">

<br><br>


<button name="save">
Add Teacher
</button>


</form>


</body>

</html>