<?php

session_start();
include "connection.php";

/* =========================
   STUDENT LOGIN CHECK
========================= */

if (!isset($_SESSION['student'])) {
    header("Location: student-login.php");
    exit();
}


/* =========================
   GET STUDENT CLASS
========================= */

if (!isset($_SESSION['class']) || empty($_SESSION['class'])) {
    die("Student class not found. Please login again.");
}

$class = mysqli_real_escape_string(
    $conn,
    $_SESSION['class']
);


/* =========================
   GET HOMEWORK
========================= */

$sql = "
SELECT *
FROM homework
WHERE class='$class'
ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>My Homework</title>

<style>

body{
    font-family:Arial, sans-serif;
    background:#f2f2f2;
    margin:0;
    padding:20px;
}

.container{
    width:95%;
    margin:auto;
}

h2{
    text-align:center;
    color:#004aad;
}

.class-box{
    background:#e8f1ff;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
    text-align:center;
    font-size:18px;
    font-weight:bold;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 0 8px #ccc;
}

th,
td{
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}

th{
    background:#004aad;
    color:white;
}

tr:nth-child(even){
    background:#f8f8f8;
}

.pdf-btn{
    display:inline-block;
    background:#008000;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:5px;
}

.pdf-btn:hover{
    background:#006400;
}

.back-btn{
    display:inline-block;
    margin-top:20px;
    background:#555;
    color:white;
    padding:10px 20px;
    text-decoration:none;
    border-radius:5px;
}

.no-homework{
    background:white;
    padding:30px;
    text-align:center;
    box-shadow:0 0 8px #ccc;
    border-radius:8px;
}

@media(max-width:700px){

    table{
        font-size:13px;
    }

    th,
    td{
        padding:7px;
    }

}

</style>

</head>


<body>


<div class="container">


<h2>📚 My Homework</h2>


<div class="class-box">

    👨‍🎓 My Class:
    <?php echo htmlspecialchars($class); ?>

</div>


<?php

if (mysqli_num_rows($result) > 0) {

?>

<table>

<tr>

    <th>Subject</th>

    <th>Title</th>

    <th>Description</th>

    <th>Last Date</th>

    <th>Teacher</th>

    <th>PDF</th>

</tr>


<?php

while ($row = mysqli_fetch_assoc($result)) {

?>

<tr>

    <td>
        <?php
        echo htmlspecialchars($row['subject']);
        ?>
    </td>


    <td>
        <?php
        echo htmlspecialchars($row['title']);
        ?>
    </td>


    <td>
        <?php
        echo nl2br(
            htmlspecialchars($row['description'])
        );
        ?>
    </td>


    <td>
        <?php
        echo htmlspecialchars($row['last_date']);
        ?>
    </td>


    <td>
        <?php
        echo htmlspecialchars($row['teacher_name']);
        ?>
    </td>


    <td>

        <?php

        if (!empty($row['pdf_file'])) {

        ?>

            <a
                class="pdf-btn"
                href="uploads/<?php
                    echo rawurlencode($row['pdf_file']);
                ?>"
                target="_blank"
            >
                📄 View PDF
            </a>

        <?php

        } else {

            echo "No PDF";

        }

        ?>

    </td>

</tr>

<?php

}

?>

</table>


<?php

} else {

?>

<div class="no-homework">

    <h3>📚 No Homework Found</h3>

    <p>
        Abhi aapki class ke liye koi homework upload nahi hua hai.
    </p>

</div>

<?php

}

?>


<a
    class="back-btn"
    href="student-dashboard.php"
>
    ⬅ Back to Dashboard
</a>


</div>

</body>

</html>