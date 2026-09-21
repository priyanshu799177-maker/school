<?php

session_start();
include "connection.php";


/* =====================================================
   ADMIN / PRINCIPAL LOGIN CHECK
===================================================== */

if(
    !isset($_SESSION['principal']) &&
    !isset($_SESSION['admin'])
)
{
    header("Location: principal-login.php");
    exit();
}


/* =====================================================
   ADD TEACHER
===================================================== */

if(isset($_POST['add_teacher']))
{
    $name = mysqli_real_escape_string(
        $conn,
        trim($_POST['name'])
    );

    $subject = mysqli_real_escape_string(
        $conn,
        trim($_POST['subject'])
    );

    $mobile = mysqli_real_escape_string(
        $conn,
        trim($_POST['mobile'])
    );

    $email = mysqli_real_escape_string(
        $conn,
        trim($_POST['email'])
    );

    $password = mysqli_real_escape_string(
        $conn,
        trim($_POST['password'])
    );


    if($name == "" || $password == "")
    {
        echo "<script>
        alert('Teacher Name aur Password required hai.');
        </script>";
    }
    else
    {

        $insert = mysqli_query(
            $conn,

            "INSERT INTO teachers
            (
                name,
                subject,
                mobile,
                email,
                password
            )
            VALUES
            (
                '$name',
                '$subject',
                '$mobile',
                '$email',
                '$password'
            )"
        );


        if($insert)
        {
            echo "<script>
            alert('Teacher Added Successfully');
            window.location.href='manage-teachers.php';
            </script>";

            exit();
        }
        else
        {
            echo "<script>
            alert('Teacher Add Error: ".mysqli_error($conn)."');
            </script>";
        }
    }
}



/* =====================================================
   ASSIGN CLASS + SUBJECT
===================================================== */

if(isset($_POST['assign_teacher']))
{
    $teacher_id = intval(
        $_POST['teacher_id']
    );

    $class = mysqli_real_escape_string(
        $conn,
        trim($_POST['class'])
    );

    $subject_id = intval(
        $_POST['subject_id']
    );

    $is_class_teacher = intval(
        $_POST['is_class_teacher']
    );


    if(
        $teacher_id <= 0 ||
        $class == "" ||
        $subject_id <= 0
    )
    {
        echo "<script>
        alert('Please Teacher, Class aur Subject select karein.');
        </script>";
    }
    else
    {

        /* =============================================
           CHECK SAME ASSIGNMENT
        ============================================= */

        $check = mysqli_query(
            $conn,

            "SELECT id
             FROM teacher_assignments
             WHERE teacher_id='$teacher_id'
             AND class='$class'
             AND subject_id='$subject_id'
             LIMIT 1"
        );


        if(mysqli_num_rows($check) > 0)
        {
            echo "<script>
            alert('Ye Teacher is Class aur Subject ke liye already assigned hai.');
            </script>";
        }
        else
        {

            /* =========================================
               IF CLASS TEACHER = YES

               Same class ka purana Class Teacher
               pehle remove hoga.

               Ek teacher multiple classes ka
               Class Teacher ho sakta hai.
            ========================================= */

            if($is_class_teacher == 1)
            {
                mysqli_query(
                    $conn,

                    "UPDATE teacher_assignments
                     SET is_class_teacher=0
                     WHERE class='$class'"
                );
            }


            /* =========================================
               INSERT ASSIGNMENT
            ========================================= */

            $insert = mysqli_query(
                $conn,

                "INSERT INTO teacher_assignments
                (
                    teacher_id,
                    class,
                    subject_id,
                    is_class_teacher
                )
                VALUES
                (
                    '$teacher_id',
                    '$class',
                    '$subject_id',
                    '$is_class_teacher'
                )"
            );


            if($insert)
            {
                echo "<script>
                alert('Teacher Assignment Saved Successfully');
                window.location.href='manage-teachers.php';
                </script>";

                exit();
            }
            else
            {
                echo "<script>
                alert('Assignment Error: ".mysqli_error($conn)."');
                </script>";
            }

        }

    }
}



/* =====================================================
   DELETE ASSIGNMENT
===================================================== */

if(isset($_GET['delete_assignment']))
{
    $assignment_id = intval(
        $_GET['delete_assignment']
    );


    mysqli_query(
        $conn,

        "DELETE FROM teacher_assignments
         WHERE id='$assignment_id'"
    );


    echo "<script>
    alert('Assignment Deleted');
    window.location.href='manage-teachers.php';
    </script>";

    exit();
}



/* =====================================================
   GET TEACHERS
===================================================== */

$teachers = mysqli_query(
    $conn,

    "SELECT *
     FROM teachers
     ORDER BY name ASC"
);


if(!$teachers)
{
    die(
        "Teachers Error: ".
        mysqli_error($conn)
    );
}



/* =====================================================
   GET SUBJECTS
===================================================== */

$subjects = mysqli_query(
    $conn,

    "SELECT id, subject_name
     FROM subjects
     ORDER BY subject_name ASC"
);


if(!$subjects)
{
    die(
        "Subjects Error: ".
        mysqli_error($conn)
    );
}



/* =====================================================
   GET ASSIGNMENTS
===================================================== */

$assignments = mysqli_query(
    $conn,

    "SELECT
        teacher_assignments.id,
        teacher_assignments.class,
        teacher_assignments.is_class_teacher,

        teachers.name AS teacher_name,

        subjects.subject_name

     FROM teacher_assignments

     JOIN teachers
     ON teacher_assignments.teacher_id =
        teachers.id

     JOIN subjects
     ON teacher_assignments.subject_id =
        subjects.id

     ORDER BY
        teacher_assignments.class ASC,
        teachers.name ASC"
);


if(!$assignments)
{
    die(
        "Assignment Error: ".
        mysqli_error($conn)
    );
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Manage Teachers
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


/* HEADER */

.header
{
    background:#004aad;

    color:white;

    padding:20px;

    text-align:center;
}


.header h1
{
    margin:0 0 5px 0;
}


.header p
{
    margin:0;
}


/* CONTAINER */

.container
{
    width:95%;

    max-width:1100px;

    margin:30px auto;
}


/* BACK */

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


/* CARD */

.card
{
    background:white;

    padding:25px;

    margin-bottom:25px;

    border-radius:10px;

    box-shadow:0 0 10px #ccc;
}


.card h2
{
    color:#004aad;

    margin-top:0;
}


/* FORM */

.form-grid
{
    display:grid;

    grid-template-columns:
    repeat(2,1fr);

    gap:15px;
}


.form-group
{
    display:flex;

    flex-direction:column;
}


.form-group label
{
    font-weight:bold;

    margin-bottom:6px;
}


input,
select
{
    padding:11px;

    border:1px solid #aaa;

    border-radius:5px;

    font-size:15px;
}


button
{
    padding:12px 20px;

    border:none;

    border-radius:5px;

    background:#004aad;

    color:white;

    font-size:15px;

    cursor:pointer;
}


button:hover
{
    background:#003580;
}


.full
{
    grid-column:1 / -1;
}


/* ASSIGN BUTTON */

.assign-btn
{
    background:#198754;
}


.assign-btn:hover
{
    background:#146c43;
}


/* TABLE */

.table-container
{
    overflow-x:auto;
}


table
{
    width:100%;

    border-collapse:collapse;

    min-width:700px;
}


th,
td
{
    border:1px solid #aaa;

    padding:11px;

    text-align:center;
}


th
{
    background:#004aad;

    color:white;
}


tr:nth-child(even)
{
    background:#f8f8f8;
}


/* CLASS TEACHER */

.yes
{
    color:green;

    font-weight:bold;
}


.no
{
    color:#777;
}


/* DELETE */

.delete
{
    background:#dc3545;

    color:white;

    padding:7px 12px;

    border-radius:4px;

    text-decoration:none;

    font-size:13px;
}


.delete:hover
{
    background:#b02a37;
}


/* MOBILE */

@media(max-width:700px)
{

.form-grid
{
    grid-template-columns:1fr;
}

.full
{
    grid-column:auto;
}

}

</style>

</head>


<body>


<!-- HEADER -->

<div class="header">

<h1>
👨‍🏫 Teacher Management
</h1>

<p>
S.K.L Public School
</p>

</div>



<div class="container">


<a
href="principal-dashboard.php"
class="back"
>

⬅ Back to Principal Dashboard

</a>



<!-- =====================================================
     ADD TEACHER
===================================================== -->

<div class="card">


<h2>
➕ Add New Teacher
</h2>


<form
method="POST"
>


<div class="form-grid">


<div class="form-group">

<label>
Teacher Name
</label>

<input
type="text"
name="name"
placeholder="Teacher Name"
required
>

</div>



<div class="form-group">

<label>
Subject
</label>

<input
type="text"
name="subject"
placeholder="Main Subject"
>

</div>



<div class="form-group">

<label>
Mobile
</label>

<input
type="text"
name="mobile"
placeholder="Mobile Number"
>

</div>



<div class="form-group">

<label>
Email
</label>

<input
type="email"
name="email"
placeholder="Email"
>

</div>



<div class="form-group">

<label>
Password
</label>

<input
type="text"
name="password"
placeholder="Teacher Login Password"
required
>

</div>



<div class="form-group">

<label>
&nbsp;
</label>

<button
type="submit"
name="add_teacher"
>

💾 Add Teacher

</button>

</div>


</div>

</form>


</div>



<!-- =====================================================
     ASSIGN TEACHER
===================================================== -->

<div class="card">


<h2>
🏫 Assign Class & Subject
</h2>


<form
method="POST"
>


<div class="form-grid">


<div class="form-group">

<label>
Select Teacher
</label>

<select
name="teacher_id"
required
>

<option value="">
-- Select Teacher --
</option>


<?php

while(
    $teacher =
    mysqli_fetch_assoc(
        $teachers
    )
)
{

?>

<option
value="<?php echo $teacher['id']; ?>"
>

<?php

echo htmlspecialchars(
    $teacher['name']
);

?>

</option>

<?php

}

?>

</select>

</div>



<div class="form-group">

<label>
Select Class
</label>

<select
name="class"
required
>

<option value="">
-- Select Class --
</option>

<option value="Nursery">
Nursery
</option>

<option value="LKG">
LKG
</option>

<option value="UKG">
UKG
</option>

<option value="1">
Class 1
</option>

<option value="2">
Class 2
</option>

<option value="3">
Class 3
</option>

<option value="4">
Class 4
</option>

<option value="5">
Class 5
</option>

<option value="6">
Class 6
</option>

<option value="7">
Class 7
</option>

<option value="8">
Class 8
</option>

<option value="9">
Class 9
</option>

<option value="10">
Class 10
</option>

</select>

</div>



<div class="form-group">

<label>
Select Subject
</label>

<select
name="subject_id"
required
>

<option value="">
-- Select Subject --
</option>


<?php

mysqli_data_seek(
    $subjects,
    0
);


while(
    $subject =
    mysqli_fetch_assoc(
        $subjects
    )
)
{

?>

<option
value="<?php echo $subject['id']; ?>"
>

<?php

echo htmlspecialchars(
    $subject['subject_name']
);

?>

</option>

<?php

}

?>

</select>

</div>



<div class="form-group">

<label>
Class Teacher?
</label>

<select
name="is_class_teacher"
required
>

<option value="0">
No
</option>

<option value="1">
Yes
</option>

</select>

</div>



<div class="full">

<button
type="submit"
name="assign_teacher"
class="assign-btn"
>

💾 Assign Teacher

</button>

</div>


</div>

</form>


<p>

<strong>Note:</strong>

एक teacher को multiple classes का Class Teacher बनाया जा सकता है।

</p>


</div>



<!-- =====================================================
     ASSIGNED TEACHERS
===================================================== -->

<div class="card">


<h2>
📋 Teacher Assignments
</h2>


<div class="table-container">


<table>


<tr>

<th>
Teacher
</th>

<th>
Class
</th>

<th>
Subject
</th>

<th>
Class Teacher
</th>

<th>
Action
</th>

</tr>


<?php

if(mysqli_num_rows($assignments) == 0)
{

?>

<tr>

<td colspan="5">

No Teacher Assignment Found

</td>

</tr>

<?php

}


while(
    $assignment =
    mysqli_fetch_assoc(
        $assignments
    )
)
{

?>


<tr>


<td>

<?php

echo htmlspecialchars(
    $assignment['teacher_name']
);

?>

</td>


<td>

Class

<?php

echo htmlspecialchars(
    $assignment['class']
);

?>

</td>


<td>

<?php

echo htmlspecialchars(
    $assignment['subject_name']
);

?>

</td>


<td>

<?php

if(
    intval(
        $assignment['is_class_teacher']
    ) == 1
)
{

?>

<span class="yes">
✅ YES
</span>

<?php

}
else
{

?>

<span class="no">
❌ NO
</span>

<?php

}

?>

</td>


<td>

<a
class="delete"
href="manage-teachers.php?delete_assignment=<?php echo $assignment['id']; ?>"
onclick="return confirm('Is assignment ko delete karna hai?');"
>

🗑 Delete

</a>

</td>


</tr>


<?php

}

?>


</table>

</div>

</div>



</div>


</body>

</html>