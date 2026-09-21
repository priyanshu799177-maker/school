<?php

session_start();
include "connection.php";

/* ==============================
   TEACHER LOGIN CHECK
============================== */

if(!isset($_SESSION['teacher_id']))
{
    header("Location: teacher-login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];


/* ==============================
   GET ASSIGNMENT ID
============================== */

if(isset($_GET['assignment_id']))
{
    $assignment_id = intval($_GET['assignment_id']);
}
elseif(isset($_SESSION['selected_assignment_id']))
{
    $assignment_id = intval($_SESSION['selected_assignment_id']);
}
else
{
    header("Location: teacher-dashboard.php");
    exit();
}


/* ==============================
   GET SELECTED ASSIGNMENT
============================== */

$assignment_query = mysqli_query($conn,

"SELECT 
    teacher_assignments.id,
    teacher_assignments.teacher_id,
    teacher_assignments.class,
    teacher_assignments.subject_id,
    teacher_assignments.is_class_teacher,
    subjects.subject_name

 FROM teacher_assignments

 INNER JOIN subjects
 ON teacher_assignments.subject_id = subjects.id

 WHERE teacher_assignments.id='$assignment_id'
 AND teacher_assignments.teacher_id='$teacher_id'

 LIMIT 1"
);


$assignment = mysqli_fetch_assoc($assignment_query);


/* ==============================
   ASSIGNMENT CHECK
============================== */

if(!$assignment)
{
    die("Invalid class assignment for this teacher.");
}


/* ==============================
   SELECTED CLASS DETAILS
============================== */

$class = $assignment['class'];

$subject_id = $assignment['subject_id'];

$subject_name = $assignment['subject_name'];

$is_class_teacher = $assignment['is_class_teacher'];


/* ==============================
   SAVE SESSION
============================== */

$_SESSION['selected_assignment_id'] = $assignment_id;

$_SESSION['selected_class'] = $class;

$_SESSION['selected_subject_id'] = $subject_id;

$_SESSION['selected_subject_name'] = $subject_name;

$_SESSION['selected_is_class_teacher'] = $is_class_teacher;


/* ==============================
   GET TEACHER NAME
============================== */

$teacher_query = mysqli_query($conn,

"SELECT name
 FROM teachers
 WHERE id='$teacher_id'
 LIMIT 1"
);

$teacher = mysqli_fetch_assoc($teacher_query);

$teacher_name = $teacher ? $teacher['name'] : "Teacher";


/* ==============================
   SAVE ATTENDANCE
============================== */

if(isset($_POST['save_attendance']))
{

    /* Security Check */

    $posted_assignment_id = intval($_POST['assignment_id']);

    if($posted_assignment_id != $assignment_id)
    {
        die("Invalid assignment.");
    }


    /* Attendance Date */

    $attendance_date = mysqli_real_escape_string(
        $conn,
        $_POST['attendance_date']
    );


    /* Check Status */

    if(isset($_POST['status']) && is_array($_POST['status']))
    {

        foreach($_POST['status'] as $student_id => $status)
        {

            $student_id = intval($student_id);

            $status = mysqli_real_escape_string(
                $conn,
                $status
            );


            /* Only Present / Absent allowed */

            if($status != "Present" && $status != "Absent")
            {
                continue;
            }


            /* ==============================
               GET STUDENT ONLY FROM SELECTED CLASS
            ============================== */

            $student_query = mysqli_query($conn,

            "SELECT id,name,class
             FROM students
             WHERE id='$student_id'
             AND class='$class'
             LIMIT 1"
            );


            $student = mysqli_fetch_assoc($student_query);


            /* Student must belong to selected class */

            if(!$student)
            {
                continue;
            }


            $student_name = mysqli_real_escape_string(
                $conn,
                $student['name']
            );


            $student_class = mysqli_real_escape_string(
                $conn,
                $student['class']
            );


            /* ==============================
               CHECK EXISTING ATTENDANCE
            ============================== */

            $check = mysqli_query($conn,

            "SELECT id
             FROM attendance
             WHERE student_id='$student_id'
             AND attendance_date='$attendance_date'
             LIMIT 1"
            );


            if(mysqli_num_rows($check) > 0)
            {

                /* ==============================
                   UPDATE
                ============================== */

                mysqli_query($conn,

                "UPDATE attendance

                 SET status='$status',
                     student_name='$student_name',
                     class='$student_class'

                 WHERE student_id='$student_id'
                 AND attendance_date='$attendance_date'"
                );

            }
            else
            {

                /* ==============================
                   INSERT
                ============================== */

                mysqli_query($conn,

                "INSERT INTO attendance
                (
                    student_id,
                    student_name,
                    class,
                    attendance_date,
                    status
                )

                VALUES
                (
                    '$student_id',
                    '$student_name',
                    '$student_class',
                    '$attendance_date',
                    '$status'
                )"
                );

            }

        }

    }


    /* ==============================
       SUCCESS
    ============================== */

    echo "<script>

    alert('Attendance Saved Successfully');

    window.location='attendance.php?assignment_id=$assignment_id';

    </script>";

    exit();
}


/* ==============================
   GET STUDENTS ONLY SELECTED CLASS
============================== */

$students = mysqli_query($conn,

"SELECT id,name,class

 FROM students

 WHERE class='$class'

 ORDER BY id ASC"
);

?>


<!DOCTYPE html>

<html>

<head>

<title>Take Attendance</title>


<style>

body{
    font-family:Arial;
    background:#f2f2f2;
    margin:0;
}


.header{
    background:#004aad;
    color:white;
    padding:20px;
    text-align:center;
}


.box{
    width:90%;
    margin:30px auto;
    background:white;
    padding:20px;
    box-shadow:0 0 10px #ccc;
    border-radius:10px;
}


.info{
    background:#e8f1ff;
    padding:15px;
    margin-bottom:20px;
    border-radius:8px;
}


.info p{
    margin:8px 0;
}


input[type="date"]{
    padding:10px;
    font-size:16px;
}


table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}


th,td{
    border:1px solid #ccc;
    padding:12px;
    text-align:center;
}


th{
    background:#004aad;
    color:white;
}


.present{
    color:green;
    font-weight:bold;
}


.absent{
    color:red;
    font-weight:bold;
}


button{
    margin-top:20px;
    padding:12px 25px;
    background:#004aad;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:16px;
}


button:hover{
    background:#003580;
}


.back{
    margin-top:20px;
}


.back a{
    text-decoration:none;
    color:#004aad;
    font-weight:bold;
}


.badge{
    display:inline-block;
    padding:5px 10px;
    background:#198754;
    color:white;
    border-radius:5px;
}


@media(max-width:700px){

    .box{
        width:95%;
        padding:10px;
    }

    table{
        font-size:13px;
    }

    th,td{
        padding:8px;
    }

}

</style>

</head>


<body>


<div class="header">

<h1>📅 Take Attendance</h1>

</div>



<div class="box">


<div class="info">

<h3>Teacher Attendance</h3>


<p>

<b>Teacher:</b>

<?php

echo htmlspecialchars($teacher_name);

?>

</p>


<p>

<b>Assigned Class:</b>

<?php

echo htmlspecialchars($class);

?>

</p>


<p>

<b>Subject:</b>

<?php

echo htmlspecialchars($subject_name);

?>

</p>


<p>

<b>Class Teacher:</b>

<?php

if($is_class_teacher == 1)
{
    echo '<span class="badge">YES</span>';
}
else
{
    echo "NO";
}

?>

</p>


</div>



<form method="POST">


<!-- ASSIGNMENT ID -->

<input
type="hidden"
name="assignment_id"
value="<?php echo $assignment_id; ?>"
>


<label>

<b>Attendance Date:</b>

</label>


<br><br>


<input

type="date"

name="attendance_date"

value="<?php echo date('Y-m-d'); ?>"

required

>


<br><br>



<table>


<tr>

<th>Student ID</th>

<th>Student Name</th>

<th>Class</th>

<th>Present</th>

<th>Absent</th>

</tr>



<?php


if(mysqli_num_rows($students) > 0)
{

    while($row = mysqli_fetch_assoc($students))
    {

?>


<tr>


<td>

<?php

echo $row['id'];

?>

</td>



<td>

<?php

echo htmlspecialchars($row['name']);

?>

</td>



<td>

<?php

echo htmlspecialchars($row['class']);

?>

</td>



<td>

<input

type="radio"

name="status[<?php echo $row['id']; ?>]"

value="Present"

checked

>

<span class="present">

Present

</span>

</td>



<td>

<input

type="radio"

name="status[<?php echo $row['id']; ?>]"

value="Absent"

>

<span class="absent">

Absent

</span>

</td>


</tr>


<?php

    }

}

else

{

?>


<tr>

<td colspan="5">

No Students Found In Class

<?php

echo htmlspecialchars($class);

?>

</td>

</tr>


<?php

}

?>


</table>



<?php


if(mysqli_num_rows($students) > 0)

{

?>


<button

type="submit"

name="save_attendance"

>

💾 Save Attendance

</button>


<?php

}

?>


</form>



<div class="back">


<a href="teacher-dashboard.php">

⬅ Back to Teacher Dashboard

</a>


</div>


</div>


</body>

</html>