<?php

session_start();
include "connection.php";


/* TEACHER LOGIN CHECK */

if(!isset($_SESSION['teacher']))
{
    header("Location: teacher-login.php");
    exit();
}


$teacher_email = $_SESSION['teacher'];


/* GET TEACHER */

$teacher_query = mysqli_query(
    $conn,
    "SELECT id, name
     FROM teachers
     WHERE email='$teacher_email'
     LIMIT 1"
);

if(!$teacher_query)
{
    die("Teacher Query Error: " . mysqli_error($conn));
}

$teacher = mysqli_fetch_assoc($teacher_query);

if(!$teacher)
{
    die("Teacher not found.");
}

$teacher_id = $teacher['id'];
$teacher_name = $teacher['name'];


/* GET ASSIGNMENTS */

$assignment_query = mysqli_query(
    $conn,
    "SELECT id, class, subject_id
     FROM teacher_assignments
     WHERE teacher_id='$teacher_id'"
);

if(!$assignment_query)
{
    die("Assignment Query Error: " . mysqli_error($conn));
}

if(mysqli_num_rows($assignment_query) == 0)
{
    die("No Class or Subject assigned to this teacher.");
}


/* SELECTED ASSIGNMENT */

$selected_class = "";
$selected_subject_id = "";
$selected_assignment_id = "";


if(isset($_GET['assignment']))
{
    $assignment_id = intval($_GET['assignment']);

    $one_assignment = mysqli_query(
        $conn,
        "SELECT id, class, subject_id
         FROM teacher_assignments
         WHERE id='$assignment_id'
         AND teacher_id='$teacher_id'
         LIMIT 1"
    );

    if(!$one_assignment)
    {
        die("Assignment Error: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($one_assignment) > 0)
    {
        $assignment = mysqli_fetch_assoc($one_assignment);

        $selected_assignment_id = $assignment['id'];
        $selected_class = $assignment['class'];
        $selected_subject_id = $assignment['subject_id'];
    }
}


/* SAVE MARKS */

if(isset($_POST['save_marks']))
{
    $student_id = intval($_POST['student_id']);

    $class = mysqli_real_escape_string(
        $conn,
        $_POST['class']
    );

    $subject_id = intval($_POST['subject_id']);

    $marks = intval($_POST['marks']);

    $total_marks = intval($_POST['total_marks']);

    $assignment_id = intval($_POST['assignment_id']);

    $result_date = date("Y-m-d");


    /* CHECK MARKS */

    if($marks < 0 || $marks > $total_marks)
    {
        echo "<script>
        alert('Invalid Marks');
        </script>";
    }
    else
    {

        /* CHECK ASSIGNMENT */

        $check_assignment = mysqli_query(
            $conn,
            "SELECT id
             FROM teacher_assignments
             WHERE id='$assignment_id'
             AND teacher_id='$teacher_id'
             LIMIT 1"
        );


        if(mysqli_num_rows($check_assignment) == 0)
        {
            die("You are not allowed to enter marks for this assignment.");
        }


        /* GET STUDENT */

        $student_query = mysqli_query(
            $conn,
            "SELECT id, name, class
             FROM students
             WHERE id='$student_id'
             AND class='$class'
             LIMIT 1"
        );


        if(!$student_query)
        {
            die("Student Query Error: " . mysqli_error($conn));
        }


        $student = mysqli_fetch_assoc($student_query);


        if(!$student)
        {
            die("Student not found.");
        }


        $student_name = $student['name'];


        /* GET SUBJECT */

        $subject_query = mysqli_query(
            $conn,
            "SELECT id, subject_name
             FROM subjects
             WHERE id='$subject_id'
             LIMIT 1"
        );


        if(!$subject_query)
        {
            die("Subject Query Error: " . mysqli_error($conn));
        }


        $subject = mysqli_fetch_assoc($subject_query);


        if(!$subject)
        {
            die("Subject not found.");
        }


        $subject_name = $subject['subject_name'];


        /* CALCULATE PERCENTAGE */

        $percentage =
            ($marks / $total_marks) * 100;


        /* GRADE */

        if($percentage >= 90)
        {
            $grade = "A+";
        }
        elseif($percentage >= 80)
        {
            $grade = "A";
        }
        elseif($percentage >= 70)
        {
            $grade = "B+";
        }
        elseif($percentage >= 60)
        {
            $grade = "B";
        }
        elseif($percentage >= 50)
        {
            $grade = "C";
        }
        elseif($percentage >= 33)
        {
            $grade = "D";
        }
        else
        {
            $grade = "F";
        }


        /* CHECK OLD RESULT */

        $check_result = mysqli_query(
            $conn,
            "SELECT id
             FROM results
             WHERE student_id='$student_id'
             AND subject='$subject_name'
             LIMIT 1"
        );


        if(mysqli_num_rows($check_result) > 0)
        {

            /* UPDATE */

            mysqli_query(
                $conn,
                "UPDATE results

                 SET
                 student_name='$student_name',
                 class='$class',
                 teacher_name='$teacher_name',
                 marks='$marks',
                 total_marks='$total_marks',
                 grade='$grade',
                 result_date='$result_date'

                 WHERE student_id='$student_id'
                 AND subject='$subject_name'"
            );

        }
        else
        {

            /* INSERT */

            mysqli_query(
                $conn,
                "INSERT INTO results
                (
                    student_id,
                    student_name,
                    class,
                    subject,
                    teacher_name,
                    marks,
                    total_marks,
                    grade,
                    result_date
                )

                VALUES
                (
                    '$student_id',
                    '$student_name',
                    '$class',
                    '$subject_name',
                    '$teacher_name',
                    '$marks',
                    '$total_marks',
                    '$grade',
                    '$result_date'
                )"
            );

        }


        echo "<script>

        alert('Marks Saved Successfully');

        window.location.href =
        'add-marks.php?assignment=$assignment_id';

        </script>";

        exit();

    }
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Add Marks</title>


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
    margin:25px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}


table
{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}


th
{
    background:#004aad;
    color:white;
    padding:12px;
    border:1px solid #ccc;
}


td
{
    padding:10px;
    border:1px solid #ccc;
    text-align:center;
}


input
{
    padding:8px;
}


button
{
    background:#004aad;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:5px;
    cursor:pointer;
}


button:hover
{
    background:#003580;
}


.select-link
{
    background:#004aad;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:5px;
}


.back
{
    text-decoration:none;
    color:#004aad;
    font-weight:bold;
}

</style>

</head>


<body>


<div class="header">

<h1>📊 Add Marks</h1>

<p>

Teacher:
<strong>

<?php

echo htmlspecialchars($teacher_name);

?>

</strong>

</p>

</div>



<!-- ASSIGNMENTS -->

<div class="box">

<h2>📚 My Classes & Subjects</h2>


<table>

<tr>

<th>Class</th>

<th>Subject</th>

<th>Action</th>

</tr>


<?php

mysqli_data_seek(
    $assignment_query,
    0
);


while(
    $assignment =
    mysqli_fetch_assoc(
        $assignment_query
    )
)
{

    $assignment_id =
        $assignment['id'];

    $assignment_class =
        $assignment['class'];

    $subject_id =
        $assignment['subject_id'];


    $sub_query = mysqli_query(
        $conn,
        "SELECT subject_name
         FROM subjects
         WHERE id='$subject_id'
         LIMIT 1"
    );


    $sub = mysqli_fetch_assoc(
        $sub_query
    );


    $subject_name =
        $sub
        ? $sub['subject_name']
        : "Unknown Subject";

?>


<tr>

<td>

<?php

echo htmlspecialchars(
    $assignment_class
);

?>

</td>


<td>

<?php

echo htmlspecialchars(
    $subject_name
);

?>

</td>


<td>

<a
class="select-link"
href="add-marks.php?assignment=<?php

echo $assignment_id;

?>"
>

📊 Enter Marks

</a>

</td>

</tr>


<?php

}

?>


</table>

</div>



<!-- STUDENTS -->

<?php

if(
    $selected_class != "" &&
    $selected_subject_id != ""
)
{

    /* SELECTED SUBJECT */

    $selected_subject_query =
        mysqli_query(
            $conn,
            "SELECT subject_name
             FROM subjects
             WHERE id='$selected_subject_id'
             LIMIT 1"
        );


    $selected_subject =
        mysqli_fetch_assoc(
            $selected_subject_query
        );


    if(!$selected_subject)
    {
        die("Subject not found.");
    }


    $selected_subject_name =
        $selected_subject['subject_name'];


    /* STUDENTS */

    $students =
        mysqli_query(
            $conn,
            "SELECT id, name, class
             FROM students
             WHERE class='$selected_class'
             ORDER BY id ASC"
        );

?>


<div class="box">

<h2>👨‍🎓 Students</h2>


<p>

<strong>Class:</strong>

<?php

echo htmlspecialchars(
    $selected_class
);

?>

</p>


<p>

<strong>Subject:</strong>

<?php

echo htmlspecialchars(
    $selected_subject_name
);

?>

</p>


<table>

<tr>

<th>ID</th>

<th>Student Name</th>

<th>Class</th>

<th>Marks</th>

<th>Total</th>

<th>Save</th>

</tr>


<?php

while(
    $student =
    mysqli_fetch_assoc(
        $students
    )
)
{

?>


<tr>

<td>

<?php

echo $student['id'];

?>

</td>


<td>

<?php

echo htmlspecialchars(
    $student['name']
);

?>

</td>


<td>

<?php

echo htmlspecialchars(
    $student['class']
);

?>

</td>


<td>

<form method="POST">


<input
type="number"
name="marks"
min="0"
max="100"
required
>


</td>


<td>

<input
type="number"
name="total_marks"
value="100"
min="1"
required
>


<input
type="hidden"
name="student_id"
value="<?php

echo $student['id'];

?>"
>


<input
type="hidden"
name="class"
value="<?php

echo htmlspecialchars(
    $selected_class
);

?>"
>


<input
type="hidden"
name="subject_id"
value="<?php

echo $selected_subject_id;

?>"
>


<input
type="hidden"
name="assignment_id"
value="<?php

echo $selected_assignment_id;

?>"
>


</td>


<td>

<button
type="submit"
name="save_marks"
>

💾 Save

</button>


</form>

</td>

</tr>


<?php

}

?>


</table>

</div>


<?php

}

?>


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