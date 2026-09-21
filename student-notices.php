<?php
session_start();
include "connection.php";

if(!isset($_SESSION['student']))
{
    header("Location: student-login.php");
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM notices ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>

<title>School Notices</title>

<style>

body{
font-family:Arial;
background:#f2f2f2;
margin:0;
}

.header{
background:#004aad;
color:white;
padding:15px;
text-align:center;
font-size:30px;
}

.notice{
width:80%;
margin:20px auto;
background:white;
padding:20px;
box-shadow:0px 0px 8px gray;
border-left:8px solid blue;
}

.notice h2{
color:#004aad;
}

.date{
color:red;
font-weight:bold;
margin-top:10px;
}

.back{
text-align:center;
margin:30px;
}

.back a{
text-decoration:none;
background:#004aad;
color:white;
padding:10px 20px;
border-radius:5px;
}

</style>

</head>

<body>

<div class="header">

📢 School Notices

</div>

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<div class="notice">

<h2><?php echo $row['title']; ?></h2>

<p><?php echo nl2br($row['notice']); ?></p>

<div class="date">

Published :
<?php echo $row['notice_date']; ?>

</div>

</div>

<?php

}

}
else
{

echo "<h2 align='center'>No Notice Found</h2>";

}

?>

<div class="back">

<a href="student-dashboard.php">

⬅ Back to Dashboard

</a>

</div>

</body>

</html>