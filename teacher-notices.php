<?php

session_start();
include "connection.php";


/* TEACHER LOGIN CHECK */

if(!isset($_SESSION['teacher']))
{
    header("Location: teacher-login.php");
    exit();
}


/* GET NOTICES */

$sql = "SELECT *
        FROM notices
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

<title>School Notices</title>


<style>

body
{
    margin:0;
    font-family:Arial;
    background:#f2f2f2;
}


.header
{
    background:#004aad;
    color:white;
    padding:25px;
    text-align:center;
}


.box
{
    width:90%;
    margin:30px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}


.notice
{
    border:1px solid #ddd;
    border-left:5px solid #004aad;
    padding:18px;
    margin-bottom:15px;
    border-radius:5px;
}


.notice h2
{
    color:#004aad;
    margin-top:0;
}


.date
{
    color:#777;
    font-size:14px;
    margin-bottom:10px;
}


.back
{
    display:inline-block;
    background:#004aad;
    color:white;
    padding:10px 15px;
    text-decoration:none;
    border-radius:5px;
}


.back:hover
{
    background:#003580;
}


.no-notice
{
    text-align:center;
    padding:30px;
    color:#777;
}

</style>

</head>


<body>


<!-- HEADER -->

<div class="header">

<h1>📢 School Notices</h1>

<p>

Teacher:
<strong>

<?php

echo htmlspecialchars(
    $_SESSION['teacher']
);

?>

</strong>

</p>

</div>



<!-- NOTICES -->

<div class="box">

<h2>📢 Latest Notices</h2>


<?php

if(mysqli_num_rows($result) == 0)
{

?>

<div class="no-notice">

<h3>📭 No Notice Found</h3>

<p>
Abhi koi school notice available nahi hai.
</p>

</div>

<?php

}
else
{

    while($row = mysqli_fetch_assoc($result))
    {

?>


<div class="notice">


<h2>

📢

<?php

echo htmlspecialchars(
    $row['title']
);

?>

</h2>


<div class="date">

📅 Date:

<?php

echo htmlspecialchars(
    $row['notice_date']
);

?>

</div>


<p>

<?php

echo nl2br(
    htmlspecialchars(
        $row['notice']
    )
);

?>

</p>


</div>


<?php

    }

}

?>


</div>



<!-- BACK -->

<div class="box">

<a
class="back"
href="teacher-dashboard.php"
>

⬅ Back to Teacher Dashboard

</a>

</div>


</body>

</html>