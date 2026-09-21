<?php

session_start();
include "connection.php";


// Student ya Teacher login hona chahiye

if(
    !isset($_SESSION['student']) &&
    !isset($_SESSION['teacher'])
)
{
    header("Location: student-login.php");
    exit();
}


$result = mysqli_query(
    $conn,
    "SELECT *
     FROM gallery
     ORDER BY id DESC"
);


if(!$result)
{
    die("Database Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>School Gallery</title>

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


.gallery
{
    width:90%;
    margin:30px auto;

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));

    gap:20px;
}


.photo
{
    background:white;
    padding:15px;
    border-radius:10px;

    box-shadow:
    0 0 10px #ccc;

    text-align:center;
}


.photo img
{
    width:100%;
    height:200px;

    object-fit:cover;

    border-radius:8px;
}


.photo h3
{
    color:#004aad;
}


.date
{
    color:#777;
    font-size:14px;
}


.back
{
    display:block;

    width:220px;

    margin:30px auto;

    padding:12px;

    text-align:center;

    background:#004aad;

    color:white;

    text-decoration:none;

    border-radius:5px;
}


.no-photo
{
    text-align:center;
    padding:40px;
    color:#777;
}

</style>

</head>


<body>


<div class="header">

<h1>📸 S.K.L Public School Gallery</h1>

</div>


<div class="gallery">


<?php

if(mysqli_num_rows($result) == 0)
{

?>

<div class="no-photo">

<h2>📭 No Photos Found</h2>

</div>

<?php

}
else
{

while($row = mysqli_fetch_assoc($result))
{

?>

<div class="photo">


<img
src="uploads/gallery/<?php

echo htmlspecialchars(
    $row['image']
);

?>"

alt="School Photo"
>


<h3>

<?php

echo htmlspecialchars(
    $row['title']
);

?>

</h3>


<div class="date">

📅

<?php

echo htmlspecialchars(
    $row['upload_date']
);

?>

</div>


</div>


<?php

}

}

?>


</div>


<a
class="back"
href="<?php

if(isset($_SESSION['student']))
{
    echo 'student-dashboard.php';
}
else
{
    echo 'teacher-dashboard.php';
}

?>"
>

⬅ Back to Dashboard

</a>


</body>

</html>