<?php

include "connection.php";

if(isset($_POST['login']))
{

$username = $_POST['username'];
$password = $_POST['password'];


$query = "SELECT * FROM admin 
WHERE username='$username' 
AND password='$password'";


$result = mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)
{

header("Location: admin-dashboard.php");

}
else
{

echo "Invalid Username or Password";

}

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Admin Login</title>

</head>

<body>


<h2>Admin Login</h2>


<form method="POST">


Username:

<input type="text" name="username">


<br><br>


Password:

<input type="password" name="password">


<br><br>


<button name="login">
Login
</button>


</form>


</body>

</html>