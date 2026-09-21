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
   SELECTED CLASS
===================================================== */

if(isset($_GET['assignment_id']))
{
    $assignment_id = intval($_GET['assignment_id']);

    /* Check assignment belongs to logged-in teacher */

    $check = mysqli_query(
        $conn,

        "SELECT
            teacher_assignments.id,
            teacher_assignments.class,
            teacher_assignments.subject_id,
            teacher_assignments.is_class_teacher,
            subjects.subject_name

         FROM teacher_assignments

         JOIN subjects
         ON teacher_assignments.subject_id = subjects.id

         WHERE teacher_assignments.id='$assignment_id'
         AND teacher_assignments.teacher_id='$teacher_id'

         LIMIT 1"
    );


    if($check && mysqli_num_rows($check) > 0)
    {
        $selected = mysqli_fetch_assoc($check);

        $_SESSION['selected_assignment_id'] =
            $selected['id'];

        $_SESSION['selected_class'] =
            $selected['class'];

        $_SESSION['selected_subject_id'] =
            $selected['subject_id'];

        $_SESSION['selected_subject_name'] =
            $selected['subject_name'];

        $_SESSION['selected_is_class_teacher'] =
            $selected['is_class_teacher'];
    }
}


/* =====================================================
   TEACHER DETAILS
===================================================== */

$teacher_query = mysqli_query(
    $conn,

    "SELECT id, name, subject, mobile, email
     FROM teachers
     WHERE id='$teacher_id'
     LIMIT 1"
);


if(!$teacher_query)
{
    die(
        "Teacher Error: " .
        mysqli_error($conn)
    );
}


$teacher = mysqli_fetch_assoc(
    $teacher_query
);


if(!$teacher)
{
    die("Teacher details not found.");
}


/* =====================================================
   ALL ASSIGNMENTS OF THIS TEACHER
===================================================== */

$assignments = mysqli_query(
    $conn,

    "SELECT
        teacher_assignments.id,
        teacher_assignments.class,
        teacher_assignments.subject_id,
        teacher_assignments.is_class_teacher,
        subjects.subject_name

     FROM teacher_assignments

     JOIN subjects
     ON teacher_assignments.subject_id =
        subjects.id

     WHERE teacher_assignments.teacher_id='$teacher_id'

     ORDER BY
        teacher_assignments.class ASC,
        subjects.subject_name ASC"
);


if(!$assignments)
{
    die(
        "Assignment Error: " .
        mysqli_error($conn)
    );
}


/* =====================================================
   CURRENT SELECTED ASSIGNMENT
===================================================== */

$current_assignment_id =
    isset($_SESSION['selected_assignment_id'])
    ? intval($_SESSION['selected_assignment_id'])
    : 0;


$current_class =
    isset($_SESSION['selected_class'])
    ? $_SESSION['selected_class']
    : "";


$current_subject =
    isset($_SESSION['selected_subject_name'])
    ? $_SESSION['selected_subject_name']
    : "";


$current_is_class_teacher =
    isset($_SESSION['selected_is_class_teacher'])
    ? intval($_SESSION['selected_is_class_teacher'])
    : 0;

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Teacher Dashboard
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

    margin:25px auto;
}


/* CARD */

.card
{
    background:white;

    padding:22px;

    margin-bottom:20px;

    border-radius:10px;

    box-shadow:0 2px 8px #ccc;
}


.card h2
{
    margin-top:0;

    color:#004aad;
}


/* TEACHER INFO */

.info
{
    display:grid;

    grid-template-columns:
    repeat(3,1fr);

    gap:15px;
}


.info-box
{
    background:#f5f7fa;

    padding:15px;

    border-radius:7px;
}


.info-title
{
    color:#666;

    font-size:13px;

    margin-bottom:5px;
}


.info-value
{
    font-weight:bold;

    font-size:17px;
}


/* ASSIGNMENTS */

.assignment-grid
{
    display:grid;

    grid-template-columns:
    repeat(2,1fr);

    gap:18px;
}


.assignment
{
    border:2px solid #ddd;

    border-radius:10px;

    padding:20px;

    background:#fff;
}


.assignment:hover
{
    border-color:#004aad;

    box-shadow:0 2px 8px #ddd;
}


.assignment h3
{
    margin-top:0;

    color:#004aad;
}


/* BADGE */

.badge
{
    display:inline-block;

    padding:6px 10px;

    border-radius:20px;

    background:#e8f5e9;

    color:green;

    font-size:13px;

    font-weight:bold;
}


.badge-normal
{
    background:#eee;

    color:#555;
}


/* OPEN CLASS */

.open-class
{
    display:inline-block;

    margin-top:15px;

    padding:11px 18px;

    background:#004aad;

    color:white;

    text-decoration:none;

    border-radius:5px;
}


.open-class:hover
{
    background:#003580;
}


/* CURRENT CLASS */

.current
{
    border:2px solid green;

    background:#f0fff4;
}


.current-box
{
    background:#e8f5e9;

    padding:15px;

    border-radius:7px;

    margin-top:10px;
}


/* MENU */

.menu
{
    display:grid;

    grid-template-columns:
    repeat(3,1fr);

    gap:15px;

    margin-top:15px;
}


.menu a
{
    display:block;

    padding:18px;

    background:#004aad;

    color:white;

    text-decoration:none;

    text-align:center;

    border-radius:7px;

    font-weight:bold;
}


.menu a:hover
{
    background:#003580;
}


/* LOGOUT */

.logout
{
    display:inline-block;

    margin-top:20px;

    padding:12px 20px;

    background:#dc3545;

    color:white;

    text-decoration:none;

    border-radius:5px;
}


/* MOBILE */

@media(max-width:700px)
{

.info
{
    grid-template-columns:1fr;
}


.assignment-grid
{
    grid-template-columns:1fr;
}


.menu
{
    grid-template-columns:1fr;
}

}

</style>

</head>


<body>


<!-- HEADER -->

<div class="header">

<h1>
👨‍🏫 Teacher Dashboard
</h1>

<p>
S.K.L Public School
</p>

</div>



<div class="container">


<!-- TEACHER INFORMATION -->

<div class="card">

<h2>
Welcome Teacher
</h2>


<div class="info">


<div class="info-box">

<div class="info-title">
Teacher Name
</div>

<div class="info-value">

<?php

echo htmlspecialchars(
    $teacher['name']
);

?>

</div>

</div>



<div class="info-box">

<div class="info-title">
Mobile
</div>

<div class="info-value">

<?php

echo htmlspecialchars(
    $teacher['mobile']
);

?>

</div>

</div>



<div class="info-box">

<div class="info-title">
Email
</div>

<div class="info-value">

<?php

echo htmlspecialchars(
    $teacher['email']
);

?>

</div>

</div>


</div>

</div>



<!-- CURRENT SELECTED CLASS -->

<?php

if($current_assignment_id > 0)
{

?>

<div class="card current">

<h2>
✅ Current Selected Class
</h2>


<div class="current-box">

<strong>
Class:
</strong>

<?php

echo htmlspecialchars(
    $current_class
);

?>


<br><br>


<strong>
Subject:
</strong>

<?php

echo htmlspecialchars(
    $current_subject
);

?>


<br><br>


<strong>
Class Teacher:
</strong>

<?php

if($current_is_class_teacher == 1)
{
    echo "⭐ YES";
}
else
{
    echo "NO";
}

?>

</div>

</div>

<?php

}

?>



<!-- ALL ASSIGNED CLASSES -->

<div class="card">

<h2>
🏫 My Assigned Classes
</h2>


<?php

if(mysqli_num_rows($assignments) == 0)
{

?>

<p>
❌ Abhi koi Class/Subject assign nahi hua hai.
</p>

<?php

}
else
{

?>


<div class="assignment-grid">


<?php

while(
    $assignment =
    mysqli_fetch_assoc(
        $assignments
    )
)
{

?>


<div class="assignment
<?php

if(
    $current_assignment_id ==
    $assignment['id']
)
{
    echo " current";
}

?>
">


<h3>

🏫 Class

<?php

echo htmlspecialchars(
    $assignment['class']
);

?>

</h3>


<p>

📚 <strong>Subject:</strong>

<?php

echo htmlspecialchars(
    $assignment['subject_name']
);

?>

</p>



<p>

<?php

if(
    intval(
        $assignment['is_class_teacher']
    ) == 1
)
{

?>

<span class="badge">

⭐ Class Teacher

</span>

<?php

}
else
{

?>

<span class="badge badge-normal">

Subject Teacher

</span>

<?php

}

?>

</p>



<a
class="open-class"
href="teacher-dashboard.php?assignment_id=<?php echo $assignment['id']; ?>"
>

👉 Open This Class

</a>


</div>


<?php

}

?>


</div>


<?php

}

?>

</div>



<!-- CLASS MENU -->

<?php

if($current_assignment_id > 0)
{

?>

<div class="card">

<h2>
📚 Class Management
</h2>


<div class="menu">




<a href="add-homework.php?assignment_id=<?php echo $current_assignment_id; ?>">
📚 Homework
</a>


<a href="attendance.php?assignment_id=<?php echo $current_assignment_id; ?>">
📅 Attendance
</a>


<a href="add-remarks.php?assignment_id=<?php echo $current_assignment_id; ?>">
📝 Remarks
</a>


<a href="teacher-add-result.php?assignment_id=<?php echo $current_assignment_id; ?>">
📊 Add Result
</a>


<a href="check-homework.php?assignment_id=<?php echo $current_assignment_id; ?>">
📖 Check Homework
</a>


<a href="teacher-notices.php?assignment_id=<?php echo $current_assignment_id; ?>">
📢 Notices
</a>


<a href="gallery.php?assignment_id=<?php echo $current_assignment_id; ?>">
📸 Gallery
</a>


</div>

</div>

<?php

}
else
{

?>

<div class="card">

<h2>
👆 Select a Class
</h2>

<p>
"Select your assigned class from above to start the work."
</p>

</div>

<?php

}

?>



<!-- LOGOUT -->

<a
href="teacher-login.php"
class="logout"
>

🚪 Logout

</a>


</div>


</body>

</html>