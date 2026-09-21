<?php

session_start();
include "connection.php";


/* =====================================================
   TEACHER LOGIN CHECK
===================================================== */

if(!isset($_SESSION['teacher_id']))
{
    header("Location: teacher-login.php");
    exit();
}

$teacher_id = intval($_SESSION['teacher_id']);


/* =====================================================
   GET SELECTED ASSIGNMENT
===================================================== */

$assignment_id = 0;


/*
   Dashboard se assignment_id aaye to
   wahi class select hogi.
*/

if(isset($_GET['assignment_id']))
{
    $assignment_id = intval($_GET['assignment_id']);
}


/*
   Agar URL me assignment_id nahi hai,
   to session wali assignment use hogi.
*/

elseif(isset($_SESSION['selected_assignment_id']))
{
    $assignment_id =
        intval($_SESSION['selected_assignment_id']);
}


/*
   Koi class select nahi hai
*/

else
{
    echo "<script>

    alert('Please first select a class from Teacher Dashboard.');

    window.location.href='teacher-dashboard.php';

    </script>";

    exit();
}


/* =====================================================
   VERIFY ASSIGNMENT
===================================================== */

$assignment_query = mysqli_query(
    $conn,

    "SELECT
        teacher_assignments.id,
        teacher_assignments.teacher_id,
        teacher_assignments.class,
        teacher_assignments.subject_id,
        teacher_assignments.is_class_teacher,

        subjects.subject_name

     FROM teacher_assignments

     INNER JOIN subjects
     ON teacher_assignments.subject_id =
        subjects.id

     WHERE teacher_assignments.id='$assignment_id'

     AND teacher_assignments.teacher_id='$teacher_id'

     LIMIT 1"
);


if(!$assignment_query)
{
    die(
        "Assignment Error: ".
        mysqli_error($conn)
    );
}


if(mysqli_num_rows($assignment_query) == 0)
{
    echo "<script>

    alert('This class is not assigned to you.');

    window.location.href='teacher-dashboard.php';

    </script>";

    exit();
}


$assignment =
    mysqli_fetch_assoc(
        $assignment_query
    );


/* =====================================================
   SAVE CURRENT ASSIGNMENT
===================================================== */

$_SESSION['selected_assignment_id'] =
    intval($assignment['id']);

$_SESSION['selected_class'] =
    $assignment['class'];

$_SESSION['selected_subject_id'] =
    intval($assignment['subject_id']);

$_SESSION['selected_subject_name'] =
    $assignment['subject_name'];

$_SESSION['selected_is_class_teacher'] =
    intval($assignment['is_class_teacher']);


/* =====================================================
   CURRENT DATA
===================================================== */

$class =
    $assignment['class'];

$subject_id =
    intval($assignment['subject_id']);

$subject_name =
    $assignment['subject_name'];

$is_class_teacher =
    intval($assignment['is_class_teacher']);


/* =====================================================
   TEACHER DETAILS
===================================================== */

$teacher_query = mysqli_query(
    $conn,

    "SELECT
        id,
        name,
        mobile,
        email

     FROM teachers

     WHERE id='$teacher_id'

     LIMIT 1"
);


if(!$teacher_query)
{
    die(
        "Teacher Error: ".
        mysqli_error($conn)
    );
}


$teacher =
    mysqli_fetch_assoc(
        $teacher_query
    );


if(!$teacher)
{
    die("Teacher details not found.");
}


/* =====================================================
   SAVE RESULT
===================================================== */

if(isset($_POST['save_result']))
{

    /*
       Hidden assignment ID
    */

    $posted_assignment_id =
        intval(
            $_POST['assignment_id']
        );


    /*
       SECURITY CHECK

       Form se aayi assignment ID
       current assignment ke same honi chahiye.
    */

    if(
        $posted_assignment_id !=
        $assignment_id
    )
    {
        die("Invalid assignment.");
    }


    /*
       Student ID
    */

    $student_id =
        intval(
            $_POST['student_id']
        );


    /*
       Marks
    */

    $quarterly_marks =
        intval(
            $_POST['quarterly_marks']
        );


    $quarterly_total =
        intval(
            $_POST['quarterly_total']
        );


    $half_yearly_marks =
        intval(
            $_POST['half_yearly_marks']
        );


    $half_yearly_total =
        intval(
            $_POST['half_yearly_total']
        );


    $annual_marks =
        intval(
            $_POST['annual_marks']
        );


    $annual_total =
        intval(
            $_POST['annual_total']
        );


    /* =================================================
       CHECK MARKS
    ================================================= */

    if(
        $quarterly_total <= 0 ||
        $half_yearly_total <= 0 ||
        $annual_total <= 0
    )
    {
        echo "<script>
        alert('Total marks valid hona chahiye.');
        </script>";
    }


    elseif(
        $quarterly_marks < 0 ||
        $quarterly_marks > $quarterly_total ||

        $half_yearly_marks < 0 ||
        $half_yearly_marks > $half_yearly_total ||

        $annual_marks < 0 ||
        $annual_marks > $annual_total
    )
    {
        echo "<script>
        alert('Obtained marks total marks se zyada nahi ho sakte.');
        </script>";
    }


    else
    {

        /* =============================================
           IMPORTANT:
           Student must belong to selected class
        ============================================= */

        $student_query = mysqli_query(
            $conn,

            "SELECT
                id,
                name,
                class

             FROM students

             WHERE id='$student_id'

             AND class='$class'

             LIMIT 1"
        );


        if(!$student_query)
        {
            die(
                "Student Error: ".
                mysqli_error($conn)
            );
        }


        if(mysqli_num_rows($student_query) == 0)
        {
            echo "<script>

            alert('Selected student is not from Class ".
            htmlspecialchars($class).
            "');

            </script>";
        }


        else
        {

            $student =
                mysqli_fetch_assoc(
                    $student_query
                );


            $student_name =
                mysqli_real_escape_string(
                    $conn,
                    $student['name']
                );


            $safe_class =
                mysqli_real_escape_string(
                    $conn,
                    $class
                );


            $safe_subject =
                mysqli_real_escape_string(
                    $conn,
                    $subject_name
                );


            /* =========================================
               CHECK EXISTING RESULT
            ========================================= */

            $existing_query = mysqli_query(
                $conn,

                "SELECT id

                 FROM results

                 WHERE student_id='$student_id'

                 AND class='$safe_class'

                 AND subject='$safe_subject'

                 LIMIT 1"
            );


            if(!$existing_query)
            {
                die(
                    "Existing Result Error: ".
                    mysqli_error($conn)
                );
            }


            if(
                mysqli_num_rows(
                    $existing_query
                ) > 0
            )
            {

                /* =====================================
                   UPDATE
                ===================================== */

                $existing =
                    mysqli_fetch_assoc(
                        $existing_query
                    );


                $result_id =
                    intval(
                        $existing['id']
                    );


                $update = mysqli_query(
                    $conn,

                    "UPDATE results SET

                        student_name='$student_name',

                        class='$safe_class',

                        subject='$safe_subject',

                        quarterly_marks='$quarterly_marks',

                        quarterly_total='$quarterly_total',

                        half_yearly_marks='$half_yearly_marks',

                        half_yearly_total='$half_yearly_total',

                        annual_marks='$annual_marks',

                        annual_total='$annual_total',

                        approval_status='Pending'

                     WHERE id='$result_id'

                     AND student_id='$student_id'

                     AND class='$safe_class'

                     AND subject='$safe_subject'"
                );


                if($update)
                {
                    echo "<script>

                    alert('Result Updated Successfully');

                    window.location.href=
                    'teacher-add-result.php?assignment_id='
                    +".$assignment_id.";

                    </script>";

                    exit();
                }


                else
                {
                    echo "<script>

                    alert('Update Error: ".
                    mysqli_error($conn).
                    "');

                    </script>";
                }

            }


            else
            {

                /* =====================================
                   INSERT
                ===================================== */

                $insert = mysqli_query(
                    $conn,

                    "INSERT INTO results
                    (
                        student_id,
                        student_name,
                        class,
                        subject,

                        quarterly_marks,
                        quarterly_total,

                        half_yearly_marks,
                        half_yearly_total,

                        annual_marks,
                        annual_total,

                        approval_status
                    )

                    VALUES
                    (
                        '$student_id',
                        '$student_name',
                        '$safe_class',
                        '$safe_subject',

                        '$quarterly_marks',
                        '$quarterly_total',

                        '$half_yearly_marks',
                        '$half_yearly_total',

                        '$annual_marks',
                        '$annual_total',

                        'Pending'
                    )"
                );


                if($insert)
                {
                    echo "<script>

                    alert('Result Saved Successfully');

                    window.location.href=
                    'teacher-add-result.php?assignment_id='
                    +".$assignment_id.";

                    </script>";

                    exit();
                }


                else
                {
                    echo "<script>

                    alert('Insert Error: ".
                    mysqli_error($conn).
                    "');

                    </script>";
                }

            }

        }

    }

}


/* =====================================================
   GET ONLY SELECTED CLASS STUDENTS
===================================================== */

$students_query = mysqli_query(
    $conn,

    "SELECT
        id,
        name,
        class

     FROM students

     WHERE class='$class'

     ORDER BY name ASC"
);


if(!$students_query)
{
    die(
        "Students Error: ".
        mysqli_error($conn)
    );
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Add Result - Teacher
</title>


<style>

*{
    box-sizing:border-box;
}


body
{
    margin:0;

    font-family:Arial,sans-serif;

    background:#f2f2f2;
}


.header
{
    background:#004aad;

    color:white;

    text-align:center;

    padding:20px;
}


.header h1
{
    margin:0 0 5px;
}


.header p
{
    margin:0;
}


.container
{
    width:95%;

    max-width:1100px;

    margin:25px auto;
}


.back
{
    display:inline-block;

    background:#555;

    color:white;

    text-decoration:none;

    padding:11px 18px;

    border-radius:5px;

    margin-bottom:20px;
}


.class-box
{
    background:#e8f5e9;

    border-left:5px solid #198754;

    padding:18px;

    margin-bottom:20px;

    border-radius:6px;
}


.class-box h2
{
    margin-top:0;

    color:#198754;
}


.card
{
    background:white;

    padding:25px;

    border-radius:10px;

    box-shadow:0 2px 8px #ccc;
}


.card h2
{
    color:#004aad;

    margin-top:0;
}


.form-group
{
    margin-bottom:18px;
}


label
{
    display:block;

    font-weight:bold;

    margin-bottom:7px;
}


select,
input
{
    width:100%;

    padding:11px;

    border:1px solid #aaa;

    border-radius:5px;

    font-size:15px;
}


.exam-box
{
    border:1px solid #ddd;

    border-radius:8px;

    padding:18px;

    margin-top:18px;
}


.exam-box h3
{
    margin-top:0;

    color:#004aad;
}


.exam-grid
{
    display:grid;

    grid-template-columns:
    1fr 1fr;

    gap:15px;
}


.save
{
    width:100%;

    padding:14px;

    border:none;

    border-radius:5px;

    background:#198754;

    color:white;

    font-size:17px;

    font-weight:bold;

    cursor:pointer;

    margin-top:20px;
}


.save:hover
{
    background:#146c43;
}


.no-student
{
    padding:20px;

    background:#fff3cd;

    border:1px solid #ffe69c;

    border-radius:6px;
}


@media(max-width:700px)
{

.exam-grid
{
    grid-template-columns:1fr;
}

}

</style>

</head>


<body>


<div class="header">

<h1>
📊 Add Student Result
</h1>

<p>
S.K.L Public School
</p>

</div>



<div class="container">


<a
href="teacher-dashboard.php"
class="back"
>
⬅ Back to Teacher Dashboard
</a>



<!-- =====================================================
     SELECTED CLASS
===================================================== -->

<div class="class-box">

<h2>
🏫 Selected Class
</h2>


<strong>
Teacher:
</strong>

<?php

echo htmlspecialchars(
    $teacher['name']
);

?>


<br><br>


<strong>
Class:
</strong>

<?php

echo htmlspecialchars(
    $class
);

?>


<br><br>


<strong>
Subject:
</strong>

<?php

echo htmlspecialchars(
    $subject_name
);

?>


<br><br>


<strong>
Class Teacher:
</strong>

<?php

echo
$is_class_teacher == 1
? "⭐ YES"
: "NO";

?>

</div>



<!-- =====================================================
     RESULT FORM
===================================================== -->

<div class="card">

<h2>
📝 Enter Result
</h2>


<?php

if(mysqli_num_rows($students_query) == 0)
{

?>

<div class="no-student">

❌ इस class में अभी कोई student नहीं है।

</div>

<?php

}
else
{

?>


<form
method="POST"
action="teacher-add-result.php?assignment_id=<?php echo $assignment_id; ?>"
>


<!-- IMPORTANT HIDDEN ASSIGNMENT -->

<input
type="hidden"
name="assignment_id"
value="<?php echo $assignment_id; ?>"
>


<!-- =====================================================
     STUDENT
===================================================== -->

<div class="form-group">

<label>
👨‍🎓 Select Student
</label>


<select
name="student_id"
required
>

<option value="">
-- Select Student --
</option>


<?php

while(
    $student =
    mysqli_fetch_assoc(
        $students_query
    )
)
{

?>

<option
value="<?php echo intval($student['id']); ?>"
>

<?php

echo htmlspecialchars(
    $student['name']
);

?>

&nbsp; | &nbsp;

Class:

<?php

echo htmlspecialchars(
    $student['class']
);

?>

</option>

<?php

}

?>

</select>

</div>



<!-- =====================================================
     QUARTERLY
===================================================== -->

<div class="exam-box">

<h3>
📘 Quarterly Exam
</h3>


<div class="exam-grid">


<div class="form-group">

<label>
Obtained Marks
</label>

<input
type="number"
name="quarterly_marks"
min="0"
value="0"
required
>

</div>


<div class="form-group">

<label>
Total Marks
</label>

<input
type="number"
name="quarterly_total"
min="1"
value="100"
required
>

</div>


</div>

</div>



<!-- =====================================================
     HALF YEARLY
===================================================== -->

<div class="exam-box">

<h3>
📗 Half Yearly Exam
</h3>


<div class="exam-grid">


<div class="form-group">

<label>
Obtained Marks
</label>

<input
type="number"
name="half_yearly_marks"
min="0"
value="0"
required
>

</div>


<div class="form-group">

<label>
Total Marks
</label>

<input
type="number"
name="half_yearly_total"
min="1"
value="100"
required
>

</div>


</div>

</div>



<!-- =====================================================
     ANNUAL
===================================================== -->

<div class="exam-box">

<h3>
📕 Annual Exam
</h3>


<div class="exam-grid">


<div class="form-group">

<label>
Obtained Marks
</label>

<input
type="number"
name="annual_marks"
min="0"
value="0"
required
>

</div>


<div class="form-group">

<label>
Total Marks
</label>

<input
type="number"
name="annual_total"
min="1"
value="100"
required
>

</div>


</div>

</div>



<!-- =====================================================
     SAVE
===================================================== -->

<button
type="submit"
name="save_result"
class="save"
>

💾 Save Result

</button>


</form>


<?php

}

?>


</div>


</div>


</body>

</html><?php

session_start();
include "connection.php";


/* =====================================================
   TEACHER LOGIN CHECK
===================================================== */

if(!isset($_SESSION['teacher_id']))
{
    header("Location: teacher-login.php");
    exit();
}

$teacher_id = intval($_SESSION['teacher_id']);


/* =====================================================
   GET SELECTED ASSIGNMENT
===================================================== */

$assignment_id = 0;


/*
   Dashboard se assignment_id aaye to
   wahi class select hogi.
*/

if(isset($_GET['assignment_id']))
{
    $assignment_id = intval($_GET['assignment_id']);
}


/*
   Agar URL me assignment_id nahi hai,
   to session wali assignment use hogi.
*/

elseif(isset($_SESSION['selected_assignment_id']))
{
    $assignment_id =
        intval($_SESSION['selected_assignment_id']);
}


/*
   Koi class select nahi hai
*/

else
{
    echo "<script>

    alert('Please first select a class from Teacher Dashboard.');

    window.location.href='teacher-dashboard.php';

    </script>";

    exit();
}


/* =====================================================
   VERIFY ASSIGNMENT
===================================================== */

$assignment_query = mysqli_query(
    $conn,

    "SELECT
        teacher_assignments.id,
        teacher_assignments.teacher_id,
        teacher_assignments.class,
        teacher_assignments.subject_id,
        teacher_assignments.is_class_teacher,

        subjects.subject_name

     FROM teacher_assignments

     INNER JOIN subjects
     ON teacher_assignments.subject_id =
        subjects.id

     WHERE teacher_assignments.id='$assignment_id'

     AND teacher_assignments.teacher_id='$teacher_id'

     LIMIT 1"
);


if(!$assignment_query)
{
    die(
        "Assignment Error: ".
        mysqli_error($conn)
    );
}


if(mysqli_num_rows($assignment_query) == 0)
{
    echo "<script>

    alert('This class is not assigned to you.');

    window.location.href='teacher-dashboard.php';

    </script>";

    exit();
}


$assignment =
    mysqli_fetch_assoc(
        $assignment_query
    );


/* =====================================================
   SAVE CURRENT ASSIGNMENT
===================================================== */

$_SESSION['selected_assignment_id'] =
    intval($assignment['id']);

$_SESSION['selected_class'] =
    $assignment['class'];

$_SESSION['selected_subject_id'] =
    intval($assignment['subject_id']);

$_SESSION['selected_subject_name'] =
    $assignment['subject_name'];

$_SESSION['selected_is_class_teacher'] =
    intval($assignment['is_class_teacher']);


/* =====================================================
   CURRENT DATA
===================================================== */

$class =
    $assignment['class'];

$subject_id =
    intval($assignment['subject_id']);

$subject_name =
    $assignment['subject_name'];

$is_class_teacher =
    intval($assignment['is_class_teacher']);


/* =====================================================
   TEACHER DETAILS
===================================================== */

$teacher_query = mysqli_query(
    $conn,

    "SELECT
        id,
        name,
        mobile,
        email

     FROM teachers

     WHERE id='$teacher_id'

     LIMIT 1"
);


if(!$teacher_query)
{
    die(
        "Teacher Error: ".
        mysqli_error($conn)
    );
}


$teacher =
    mysqli_fetch_assoc(
        $teacher_query
    );


if(!$teacher)
{
    die("Teacher details not found.");
}


/* =====================================================
   SAVE RESULT
===================================================== */

if(isset($_POST['save_result']))
{

    /*
       Hidden assignment ID
    */

    $posted_assignment_id =
        intval(
            $_POST['assignment_id']
        );


    /*
       SECURITY CHECK

       Form se aayi assignment ID
       current assignment ke same honi chahiye.
    */

    if(
        $posted_assignment_id !=
        $assignment_id
    )
    {
        die("Invalid assignment.");
    }


    /*
       Student ID
    */

    $student_id =
        intval(
            $_POST['student_id']
        );


    /*
       Marks
    */

    $quarterly_marks =
        intval(
            $_POST['quarterly_marks']
        );


    $quarterly_total =
        intval(
            $_POST['quarterly_total']
        );


    $half_yearly_marks =
        intval(
            $_POST['half_yearly_marks']
        );


    $half_yearly_total =
        intval(
            $_POST['half_yearly_total']
        );


    $annual_marks =
        intval(
            $_POST['annual_marks']
        );


    $annual_total =
        intval(
            $_POST['annual_total']
        );


    /* =================================================
       CHECK MARKS
    ================================================= */

    if(
        $quarterly_total <= 0 ||
        $half_yearly_total <= 0 ||
        $annual_total <= 0
    )
    {
        echo "<script>
        alert('Total marks valid hona chahiye.');
        </script>";
    }


    elseif(
        $quarterly_marks < 0 ||
        $quarterly_marks > $quarterly_total ||

        $half_yearly_marks < 0 ||
        $half_yearly_marks > $half_yearly_total ||

        $annual_marks < 0 ||
        $annual_marks > $annual_total
    )
    {
        echo "<script>
        alert('Obtained marks total marks se zyada nahi ho sakte.');
        </script>";
    }


    else
    {

        /* =============================================
           IMPORTANT:
           Student must belong to selected class
        ============================================= */

        $student_query = mysqli_query(
            $conn,

            "SELECT
                id,
                name,
                class

             FROM students

             WHERE id='$student_id'

             AND class='$class'

             LIMIT 1"
        );


        if(!$student_query)
        {
            die(
                "Student Error: ".
                mysqli_error($conn)
            );
        }


        if(mysqli_num_rows($student_query) == 0)
        {
            echo "<script>

            alert('Selected student is not from Class ".
            htmlspecialchars($class).
            "');

            </script>";
        }


        else
        {

            $student =
                mysqli_fetch_assoc(
                    $student_query
                );


            $student_name =
                mysqli_real_escape_string(
                    $conn,
                    $student['name']
                );


            $safe_class =
                mysqli_real_escape_string(
                    $conn,
                    $class
                );


            $safe_subject =
                mysqli_real_escape_string(
                    $conn,
                    $subject_name
                );


            /* =========================================
               CHECK EXISTING RESULT
            ========================================= */

            $existing_query = mysqli_query(
                $conn,

                "SELECT id

                 FROM results

                 WHERE student_id='$student_id'

                 AND class='$safe_class'

                 AND subject='$safe_subject'

                 LIMIT 1"
            );


            if(!$existing_query)
            {
                die(
                    "Existing Result Error: ".
                    mysqli_error($conn)
                );
            }


            if(
                mysqli_num_rows(
                    $existing_query
                ) > 0
            )
            {

                /* =====================================
                   UPDATE
                ===================================== */

                $existing =
                    mysqli_fetch_assoc(
                        $existing_query
                    );


                $result_id =
                    intval(
                        $existing['id']
                    );


                $update = mysqli_query(
                    $conn,

                    "UPDATE results SET

                        student_name='$student_name',

                        class='$safe_class',

                        subject='$safe_subject',

                        quarterly_marks='$quarterly_marks',

                        quarterly_total='$quarterly_total',

                        half_yearly_marks='$half_yearly_marks',

                        half_yearly_total='$half_yearly_total',

                        annual_marks='$annual_marks',

                        annual_total='$annual_total',

                        approval_status='Pending'

                     WHERE id='$result_id'

                     AND student_id='$student_id'

                     AND class='$safe_class'

                     AND subject='$safe_subject'"
                );


                if($update)
                {
                    echo "<script>

                    alert('Result Updated Successfully');

                    window.location.href=
                    'teacher-add-result.php?assignment_id='
                    +".$assignment_id.";

                    </script>";

                    exit();
                }


                else
                {
                    echo "<script>

                    alert('Update Error: ".
                    mysqli_error($conn).
                    "');

                    </script>";
                }

            }


            else
            {

                /* =====================================
                   INSERT
                ===================================== */

                $insert = mysqli_query(
                    $conn,

                    "INSERT INTO results
                    (
                        student_id,
                        student_name,
                        class,
                        subject,

                        quarterly_marks,
                        quarterly_total,

                        half_yearly_marks,
                        half_yearly_total,

                        annual_marks,
                        annual_total,

                        approval_status
                    )

                    VALUES
                    (
                        '$student_id',
                        '$student_name',
                        '$safe_class',
                        '$safe_subject',

                        '$quarterly_marks',
                        '$quarterly_total',

                        '$half_yearly_marks',
                        '$half_yearly_total',

                        '$annual_marks',
                        '$annual_total',

                        'Pending'
                    )"
                );


                if($insert)
                {
                    echo "<script>

                    alert('Result Saved Successfully');

                    window.location.href=
                    'teacher-add-result.php?assignment_id='
                    +".$assignment_id.";

                    </script>";

                    exit();
                }


                else
                {
                    echo "<script>

                    alert('Insert Error: ".
                    mysqli_error($conn).
                    "');

                    </script>";
                }

            }

        }

    }

}


/* =====================================================
   GET ONLY SELECTED CLASS STUDENTS
===================================================== */

$students_query = mysqli_query(
    $conn,

    "SELECT
        id,
        name,
        class

     FROM students

     WHERE class='$class'

     ORDER BY name ASC"
);


if(!$students_query)
{
    die(
        "Students Error: ".
        mysqli_error($conn)
    );
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Add Result - Teacher
</title>


<style>

*{
    box-sizing:border-box;
}


body
{
    margin:0;

    font-family:Arial,sans-serif;

    background:#f2f2f2;
}


.header
{
    background:#004aad;

    color:white;

    text-align:center;

    padding:20px;
}


.header h1
{
    margin:0 0 5px;
}


.header p
{
    margin:0;
}


.container
{
    width:95%;

    max-width:1100px;

    margin:25px auto;
}


.back
{
    display:inline-block;

    background:#555;

    color:white;

    text-decoration:none;

    padding:11px 18px;

    border-radius:5px;

    margin-bottom:20px;
}


.class-box
{
    background:#e8f5e9;

    border-left:5px solid #198754;

    padding:18px;

    margin-bottom:20px;

    border-radius:6px;
}


.class-box h2
{
    margin-top:0;

    color:#198754;
}


.card
{
    background:white;

    padding:25px;

    border-radius:10px;

    box-shadow:0 2px 8px #ccc;
}


.card h2
{
    color:#004aad;

    margin-top:0;
}


.form-group
{
    margin-bottom:18px;
}


label
{
    display:block;

    font-weight:bold;

    margin-bottom:7px;
}


select,
input
{
    width:100%;

    padding:11px;

    border:1px solid #aaa;

    border-radius:5px;

    font-size:15px;
}


.exam-box
{
    border:1px solid #ddd;

    border-radius:8px;

    padding:18px;

    margin-top:18px;
}


.exam-box h3
{
    margin-top:0;

    color:#004aad;
}


.exam-grid
{
    display:grid;

    grid-template-columns:
    1fr 1fr;

    gap:15px;
}


.save
{
    width:100%;

    padding:14px;

    border:none;

    border-radius:5px;

    background:#198754;

    color:white;

    font-size:17px;

    font-weight:bold;

    cursor:pointer;

    margin-top:20px;
}


.save:hover
{
    background:#146c43;
}


.no-student
{
    padding:20px;

    background:#fff3cd;

    border:1px solid #ffe69c;

    border-radius:6px;
}


@media(max-width:700px)
{

.exam-grid
{
    grid-template-columns:1fr;
}

}

</style>

</head>


<body>


<div class="header">

<h1>
📊 Add Student Result
</h1>

<p>
S.K.L Public School
</p>

</div>



<div class="container">


<a
href="teacher-dashboard.php"
class="back"
>
⬅ Back to Teacher Dashboard
</a>



<!-- =====================================================
     SELECTED CLASS
===================================================== -->

<div class="class-box">

<h2>
🏫 Selected Class
</h2>


<strong>
Teacher:
</strong>

<?php

echo htmlspecialchars(
    $teacher['name']
);

?>


<br><br>


<strong>
Class:
</strong>

<?php

echo htmlspecialchars(
    $class
);

?>


<br><br>


<strong>
Subject:
</strong>

<?php

echo htmlspecialchars(
    $subject_name
);

?>


<br><br>


<strong>
Class Teacher:
</strong>

<?php

echo
$is_class_teacher == 1
? "⭐ YES"
: "NO";

?>

</div>



<!-- =====================================================
     RESULT FORM
===================================================== -->

<div class="card">

<h2>
📝 Enter Result
</h2>


<?php

if(mysqli_num_rows($students_query) == 0)
{

?>

<div class="no-student">

❌ इस class में अभी कोई student नहीं है।

</div>

<?php

}
else
{

?>


<form
method="POST"
action="teacher-add-result.php?assignment_id=<?php echo $assignment_id; ?>"
>


<!-- IMPORTANT HIDDEN ASSIGNMENT -->

<input
type="hidden"
name="assignment_id"
value="<?php echo $assignment_id; ?>"
>


<!-- =====================================================
     STUDENT
===================================================== -->

<div class="form-group">

<label>
👨‍🎓 Select Student
</label>


<select
name="student_id"
required
>

<option value="">
-- Select Student --
</option>


<?php

while(
    $student =
    mysqli_fetch_assoc(
        $students_query
    )
)
{

?>

<option
value="<?php echo intval($student['id']); ?>"
>

<?php

echo htmlspecialchars(
    $student['name']
);

?>

&nbsp; | &nbsp;

Class:

<?php

echo htmlspecialchars(
    $student['class']
);

?>

</option>

<?php

}

?>

</select>

</div>



<!-- =====================================================
     QUARTERLY
===================================================== -->

<div class="exam-box">

<h3>
📘 Quarterly Exam
</h3>


<div class="exam-grid">


<div class="form-group">

<label>
Obtained Marks
</label>

<input
type="number"
name="quarterly_marks"
min="0"
value="0"
required
>

</div>


<div class="form-group">

<label>
Total Marks
</label>

<input
type="number"
name="quarterly_total"
min="1"
value="100"
required
>

</div>


</div>

</div>



<!-- =====================================================
     HALF YEARLY
===================================================== -->

<div class="exam-box">

<h3>
📗 Half Yearly Exam
</h3>


<div class="exam-grid">


<div class="form-group">

<label>
Obtained Marks
</label>

<input
type="number"
name="half_yearly_marks"
min="0"
value="0"
required
>

</div>


<div class="form-group">

<label>
Total Marks
</label>

<input
type="number"
name="half_yearly_total"
min="1"
value="100"
required
>

</div>


</div>

</div>



<!-- =====================================================
     ANNUAL
===================================================== -->

<div class="exam-box">

<h3>
📕 Annual Exam
</h3>


<div class="exam-grid">


<div class="form-group">

<label>
Obtained Marks
</label>

<input
type="number"
name="annual_marks"
min="0"
value="0"
required
>

</div>


<div class="form-group">

<label>
Total Marks
</label>

<input
type="number"
name="annual_total"
min="1"
value="100"
required
>

</div>


</div>

</div>



<!-- =====================================================
     SAVE
===================================================== -->

<button
type="submit"
name="save_result"
class="save"
>

💾 Save Result

</button>


</form>


<?php

}

?>


</div>


</div>


</body>

</html>