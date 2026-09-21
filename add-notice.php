<?php

session_start();
include "connection.php";


/* PRINCIPAL LOGIN CHECK */

if(!isset($_SESSION['principal']))
{
    header("Location: principal-login.php");
    exit();
}


if(isset($_POST['save']))
{
    $title = mysqli_real_escape_string(
        $conn,
        $_POST['title']
    );

    $notice = mysqli_real_escape_string(
        $conn,
        $_POST['notice']
    );

    $notice_date = $_POST['notice_date'];


    $sql = "INSERT INTO notices
    (title, notice, notice_date)

    VALUES
    ('$title', '$notice', '$notice_date')";


    if(mysqli_query($conn, $sql))
    {
        echo "<script>
        alert('Notice Added Successfully');
        window.location.href='add-notice.php';
        </script>";
        exit();
    }
    else
    {
        echo "<script>
        alert('Database Error: " .
        mysqli_error($conn) .
        "');
        </script>";
    }
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Add Notice</title>


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
    width:500px;
    max-width:90%;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}


label
{
    display:block;
    margin-top:15px;
    font-weight:bold;
}


input,
textarea
{
    width:100%;
    box-sizing:border-box;
    padding:10px;
    margin-top:7px;
    border:1px solid #aaa;
    border-radius:5px;
}


textarea
{
    height:150px;
    resize:vertical;
}


button
{
    width:100%;
    margin-top:20px;
    padding:12px;
    background:#004aad;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:16px;
}


button:hover
{
    background:#003580;
}


.back
{
    display:block;
    margin-top:20px;
    text-align:center;
    color:#004aad;
    text-decoration:none;
    font-weight:bold;
}

</style>

</head>


<body>


<div class="header">

<h1>📢 Add School Notice</h1>

<p>Principal Panel</p>

</div>


<div class="box">

<h2>📝 Create New Notice</h2>


<form method="POST">


<label>
Notice Title
</label>

<input
type="text"
name="title"
placeholder="Enter notice title"
required
>


<label>
Notice
</label>

<textarea
name="notice"
placeholder="Write your notice here..."
required
></textarea>


<label>
Notice Date
</label>

<input
type="date"
name="notice_date"
value="<?php echo date('Y-m-d'); ?>"
required
>


<button
type="submit"
name="save"
>

📢 Publish Notice

</button>


</form>


<a
class="back"
href="principal-dashboard.php"
>

⬅ Back to Principal Dashboard

</a>


</div>


</body>

</html>