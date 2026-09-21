<?php

session_start();
include "connection.php";

/* ==============================
   TEACHER LOGIN CHECK
============================== */

if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher-login.php");
    exit();
}

$teacher_id = intval($_SESSION['teacher_id']);


/* ==============================
   ASSIGNMENT ID
============================== */

if (!isset($_GET['assignment_id']) || !is_numeric($_GET['assignment_id'])) {
    die("Invalid class assignment.");
}

$assignment_id = intval($_GET['assignment_id']);


/* ==============================
   GET SELECTED ASSIGNMENT
============================== */

$sql = "
SELECT
    teacher_assignments.id,
    teacher_assignments.class,
    teacher_assignments.subject_id,
    teacher_assignments.is_class_teacher,
    teachers.name AS teacher_name,
    subjects.subject_name

FROM teacher_assignments

JOIN teachers
    ON teacher_assignments.teacher_id = teachers.id

JOIN subjects
    ON teacher_assignments.subject_id = subjects.id

WHERE teacher_assignments.id = ?
AND teacher_assignments.teacher_id = ?

LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $assignment_id,
    $teacher_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$assignment = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* ==============================
   ASSIGNMENT NOT FOUND
============================== */

if (!$assignment) {
    die("Invalid class assignment.");
}


/* ==============================
   ASSIGNMENT DATA
============================== */

$class = $assignment['class'];
$subject = $assignment['subject_name'];
$teacher = $assignment['teacher_name'];


/* ==============================
   SAVE HOMEWORK
============================== */

if (isset($_POST['save'])) {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $last_date = trim($_POST['last_date']);

    $title = mysqli_real_escape_string($conn, $title);
    $description = mysqli_real_escape_string($conn, $description);
    $last_date = mysqli_real_escape_string($conn, $last_date);

    $pdf = "";


    /* ==============================
       UPLOAD FOLDER
    ============================== */

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }


    /* ==============================
       PDF UPLOAD
    ============================== */

    if (
        isset($_FILES['pdf_file']) &&
        $_FILES['pdf_file']['error'] == 0
    ) {

        $file_name = $_FILES['pdf_file']['name'];
        $tmp_name = $_FILES['pdf_file']['tmp_name'];

        $extension = strtolower(
            pathinfo($file_name, PATHINFO_EXTENSION)
        );

        if ($extension != "pdf") {

            echo "<script>
                alert('Only PDF file is allowed.');
                window.history.back();
            </script>";

            exit();
        }


        $pdf = time() . "_" .
            preg_replace(
                "/[^a-zA-Z0-9._-]/",
                "_",
                basename($file_name)
            );


        $target = "uploads/" . $pdf;


        if (!move_uploaded_file($tmp_name, $target)) {

            echo "<script>
                alert('PDF upload failed.');
                window.history.back();
            </script>";

            exit();
        }
    }


    /* ==============================
       INSERT HOMEWORK
    ============================== */

    $insert_sql = "
    INSERT INTO homework
    (
        class,
        subject,
        title,
        description,
        last_date,
        teacher_name,
        pdf_file
    )

    VALUES
    (
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?
    )
    ";


    $stmt = mysqli_prepare($conn, $insert_sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $class,
        $subject,
        $title,
        $description,
        $last_date,
        $teacher,
        $pdf
    );


    if (mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        echo "<script>
            alert('Homework Uploaded Successfully');
            window.location='add-homework.php?assignment_id=$assignment_id';
        </script>";

        exit();

    } else {

        $error = mysqli_error($conn);

        mysqli_stmt_close($stmt);

        echo "<script>
            alert('Database Error: " .
            htmlspecialchars($error, ENT_QUOTES) .
            "');
        </script>";
    }
}


/* ==============================
   GET THIS TEACHER'S HOMEWORK
============================== */

$homework_sql = "
SELECT
    id,
    title,
    description,
    last_date,
    pdf_file

FROM homework

WHERE class = ?
AND subject = ?
AND teacher_name = ?

ORDER BY id DESC
";

$stmt = mysqli_prepare($conn, $homework_sql);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $class,
    $subject,
    $teacher
);

mysqli_stmt_execute($stmt);

$homework_result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Upload Homework</title>

<style>

*{
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;
    background:#f2f2f2;
    margin:0;
    padding:20px;
}

.box{
    width:600px;
    max-width:95%;
    margin:30px auto;
    background:white;
    padding:25px;
    box-shadow:0 0 10px #ccc;
    border-radius:10px;
}

h2{
    text-align:center;
    color:#004aad;
}

h3{
    color:#004aad;
    margin-top:30px;
}

.info{
    background:#e8f1ff;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
    line-height:1.5;
}

label{
    font-weight:bold;
}

input,
textarea{
    width:100%;
    padding:10px;
    margin-top:5px;
    box-sizing:border-box;
    border:1px solid #ccc;
    border-radius:5px;
}

textarea{
    resize:vertical;
}

button{
    background:#004aad;
    color:white;
    border:none;
    padding:12px 20px;
    cursor:pointer;
    width:100%;
    border-radius:5px;
    font-size:16px;
}

button:hover{
    background:#003580;
}

.back{
    display:block;
    text-align:center;
    text-decoration:none;
    background:#555;
    color:white;
    padding:10px;
    border-radius:5px;
}

.homework-list{
    margin-top:20px;
}

.homework-card{
    border:1px solid #ddd;
    border-radius:8px;
    padding:15px;
    margin-bottom:15px;
    background:#fafafa;
}

.homework-card h4{
    margin:0 0 10px;
    color:#004aad;
    font-size:18px;
}

.homework-card p{
    color:#555;
    line-height:1.5;
}

.date{
    font-size:13px;
    color:#777;
}

.pdf{
    display:inline-block;
    background:#004aad;
    color:white;
    padding:8px 12px;
    border-radius:5px;
    text-decoration:none;
    margin-top:8px;
}

.pdf:hover{
    background:#003580;
}

.delete{
    display:inline-block;
    background:#dc2626;
    color:white;
    padding:8px 12px;
    border-radius:5px;
    text-decoration:none;
    margin-top:8px;
    margin-left:5px;
}

.delete:hover{
    background:#b91c1c;
}

.no-homework{
    background:#f8f8f8;
    padding:15px;
    border-radius:7px;
    color:#777;
    text-align:center;
}

</style>

</head>

<body>


<div class="box">

<h2>📚 Upload Homework</h2>


<div class="info">

<b>Teacher:</b>
<?php echo htmlspecialchars($teacher); ?>

<br><br>

<b>Class:</b>
<?php echo htmlspecialchars($class); ?>

<br><br>

<b>Subject:</b>
<?php echo htmlspecialchars($subject); ?>

</div>


<form
    method="POST"
    enctype="multipart/form-data"
>


<label>Homework Title</label>

<input
    type="text"
    name="title"
    placeholder="Enter homework title"
    required
>

<br><br>


<label>Description</label>

<textarea
    name="description"
    rows="5"
    placeholder="Enter homework description"
    required
></textarea>

<br><br>


<label>Last Date</label>

<input
    type="date"
    name="last_date"
    required
>

<br><br>


<label>Homework PDF</label>

<input
    type="file"
    name="pdf_file"
    accept=".pdf,application/pdf"
>

<br><br>


<button
    type="submit"
    name="save"
>
📤 Upload Homework
</button>

</form>


<!-- ==============================
     HOMEWORK LIST
============================== -->

<h3>📋 My Uploaded Homework</h3>


<div class="homework-list">

<?php

if(mysqli_num_rows($homework_result) > 0)
{

    while($hw = mysqli_fetch_assoc($homework_result))
    {

?>

<div class="homework-card">

<h4>
📚 <?php echo htmlspecialchars($hw['title']); ?>
</h4>

<p>
<?php echo nl2br(
    htmlspecialchars($hw['description'])
); ?>
</p>

<div class="date">

📅 Last Date:
<?php echo htmlspecialchars($hw['last_date']); ?>

</div>


<?php

if(!empty($hw['pdf_file']))
{

?>

<a
    class="pdf"
    href="uploads/<?php echo htmlspecialchars($hw['pdf_file']); ?>"
    target="_blank"
>
📄 View PDF
</a>

<?php

}

?>


<a
    class="delete"
    href="delete-homework.php?id=<?php echo $hw['id']; ?>&assignment_id=<?php echo $assignment_id; ?>"
    onclick="return confirm('Are you sure you want to delete this homework?');"
>
🗑 Delete
</a>


</div>

<?php

    }

}
else
{

?>

<div class="no-homework">

No homework uploaded yet.

</div>

<?php

}

?>

</div>


<br>


<a
    class="back"
    href="teacher-dashboard.php"
>
⬅ Back to Dashboard
</a>


</div>


</body>

</html>

<?php

mysqli_stmt_close($stmt);

?>