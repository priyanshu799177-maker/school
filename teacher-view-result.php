<?php

session_start();
include "connection.php";


/* TEACHER LOGIN CHECK */

if(!isset($_SESSION['teacher_id']))
{
    header("Location: teacher-login.php");
    exit();
}


$teacher_id = $_SESSION['teacher_id'];


/* TEACHER NAME */

$teacher_query = mysqli_query(
    $conn,
    "SELECT name FROM teachers
     WHERE id='$teacher_id'
     LIMIT 1"
);

$teacher = mysqli_fetch_assoc($teacher_query);

$teacher_name = $teacher['name'] ?? "Teacher";
/* CHECK CLASS TEACHER */

$class_teacher_check = mysqli_query(
    $conn,
    "SELECT DISTINCT class
     FROM teacher_assignments
     WHERE teacher_id='$teacher_id'
     AND is_class_teacher=1"
);

if(!$class_teacher_check)
{
    die("Database Error: " . mysqli_error($conn));
}

$class_teacher_classes = array();

while($row = mysqli_fetch_assoc($class_teacher_check))
{
    $class_teacher_classes[] = $row['class'];
}


/* ONLY CLASS TEACHER */

if(count($class_teacher_classes) == 0)
{
    die("
    <div style='
        font-family:Arial;
        text-align:center;
        margin-top:100px;
    '>

    <h2 style='color:red;'>
    ❌ Access Denied
    </h2>

    <p>
    Sirf Class Teacher hi Result View/Edit kar sakta hai.
    </p>

    <a href='teacher-dashboard.php'>
    ⬅ Back to Teacher Dashboard
    </a>

    </div>
    ");
}


/* CLASS AND STUDENT */

$selected_class = "";
$selected_student = "";


if(isset($_GET['class']))
{
    $selected_class = mysqli_real_escape_string(
        $conn,
        $_GET['class']
    );
}


if(isset($_GET['student_id']))
{
    $selected_student = intval(
        $_GET['student_id']
    );
}


/* GET CLASSES */

$class_query = mysqli_query(
    $conn,
    "SELECT DISTINCT class
     FROM students
     ORDER BY class"
);


/* GET STUDENTS */

$students = [];

if($selected_class != "")
{
    $student_query = mysqli_query(
        $conn,
        "SELECT id,name,class
         FROM students
         WHERE class='$selected_class'
         ORDER BY name"
    );

    while($s = mysqli_fetch_assoc($student_query))
    {
        $students[] = $s;
    }
}


/* GET RESULTS */

$results = [];

if($selected_student > 0)
{
    $result_query = mysqli_query(
        $conn,
        "SELECT *
         FROM results
         WHERE student_id='$selected_student'
         ORDER BY id ASC"
    );

    while($r = mysqli_fetch_assoc($result_query))
    {
        $results[] = $r;
    }
}


/* UPDATE RESULT */

if(isset($_POST['update_result']))
{
    $result_id = intval(
        $_POST['result_id']
    );

    $quarterly = intval(
        $_POST['quarterly_marks']
    );

    $half_yearly = intval(
        $_POST['half_yearly_marks']
    );

    $annual = intval(
        $_POST['annual_marks']
    );


    if(
        $quarterly < 0 || $quarterly > 50 ||
        $half_yearly < 0 || $half_yearly > 50 ||
        $annual < 0 || $annual > 50
    )
    {
        echo "<script>
        alert('Marks 0 se 50 ke beech hone chahiye');
        </script>";
    }
    else
    {

        $update = mysqli_query(
            $conn,
            "UPDATE results SET

            quarterly_marks='$quarterly',

            quarterly_total='50',

            half_yearly_marks='$half_yearly',

            half_yearly_total='50',

            annual_marks='$annual',

            annual_total='50',

            marks='$annual',

            total_marks='50',

            result_date=CURDATE()

            WHERE id='$result_id'"
        );


        if($update)
        {
            echo "<script>

            alert('Result Updated Successfully');

            window.location.href='teacher-view-result.php';

            </script>";

            exit();
        }
        else
        {
            echo "<script>

            alert('Update Error: " .
            mysqli_error($conn) .
            "');

            </script>";
        }
    }
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>View / Edit Result</title>


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
    padding:20px;
    text-align:center;
}


.container
{
    width:95%;
    max-width:1100px;
    margin:30px auto;
}


.box
{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
    margin-bottom:20px;
}


label
{
    font-weight:bold;
    display:block;
    margin-bottom:7px;
}


select
{
    width:100%;
    padding:11px;
    border:1px solid #aaa;
    border-radius:5px;
    margin-bottom:15px;
}


button
{
    padding:11px 20px;
    background:#004aad;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}


button:hover
{
    background:#003580;
}


table
{
    width:100%;
    border-collapse:collapse;
}


th,
td
{
    border:1px solid #aaa;
    padding:10px;
    text-align:center;
}


th
{
    background:#004aad;
    color:white;
}


input
{
    width:70px;
    padding:7px;
    text-align:center;
}


.edit
{
    background:#198754;
}


.back
{
    display:inline-block;
    margin-top:20px;
    padding:11px 20px;
    background:#555;
    color:white;
    text-decoration:none;
    border-radius:5px;
}


.message
{
    text-align:center;
    padding:20px;
    color:#777;
}


</style>

</head>


<body>


<div class="header">

<h1>📋 View / Edit Result</h1>

<p>
Teacher: <?php echo htmlspecialchars($teacher_name); ?>
</p>

</div>



<div class="container">


<!-- FILTER -->

<div class="box">

<h2>
🔍 Select Student
</h2>


<form method="GET">


<label>
Select Class
</label>


<select
name="class"
onchange="this.form.submit()"
required
>

<option value="">
-- Select Class --
</option>


<?php

while($c = mysqli_fetch_assoc($class_query))
{

?>

<option
value="<?php echo htmlspecialchars($c['class']); ?>"

<?php

if($selected_class == $c['class'])
{
    echo "selected";
}

?>
>

<?php

echo htmlspecialchars(
    $c['class']
);

?>

</option>


<?php

}

?>

</select>



<?php

if($selected_class != "")
{

?>


<label>
Select Student
</label>


<select
name="student_id"
required
>

<option value="">
-- Select Student --
</option>


<?php

foreach($students as $s)
{

?>

<option
value="<?php echo $s['id']; ?>"

<?php

if(
    $selected_student ==
    $s['id']
)
{
    echo "selected";
}

?>
>

<?php

echo htmlspecialchars(
    $s['name']
);

?>

- ID:

<?php

echo $s['id'];

?>

</option>


<?php

}

?>

</select>


<button
type="submit"
>

📋 View Result

</button>


<?php

}

?>


</form>

</div>



<?php

if($selected_student > 0)
{

?>


<!-- RESULT -->

<div class="box">

<h2>
📊 Saved Result
</h2>


<?php

if(count($results) == 0)
{

?>

<div class="message">

<h3>
📭 No Result Found
</h3>

<p>
Is student ke liye abhi result save nahi hua hai.
</p>

</div>

<?php

}
else
{

?>


<table>


<tr>

<th>
Subject
</th>

<th>
Quarterly
</th>

<th>
Half Yearly
</th>

<th>
Annual
</th>

<th>
Action
</th>

</tr>


<?php

foreach($results as $r)
{

?>


<tr>


<td>

<strong>

<?php

echo htmlspecialchars(
    $r['subject']
);

?>

</strong>

</td>


<td>

<?php

echo intval(
    $r['quarterly_marks']
);

?>

/ 50

</td>


<td>

<?php

echo intval(
    $r['half_yearly_marks']
);

?>

/ 50

</td>


<td>

<?php

echo intval(
    $r['annual_marks']
);

?>

/ 50

</td>


<td>

<button
class="edit"
onclick="showEdit(
<?php echo $r['id']; ?>,
<?php echo $r['quarterly_marks']; ?>,
<?php echo $r['half_yearly_marks']; ?>,
<?php echo $r['annual_marks']; ?>
)"
>

✏️ Edit

</button>

</td>


</tr>


<?php

}

?>


</table>


<?php

}

?>


</div>


<?php

}

?>



<!-- EDIT BOX -->

<div
class="box"
id="editBox"
style="display:none;"
>

<h2>
✏️ Edit Result
</h2>


<form method="POST">


<input
type="hidden"
name="result_id"
id="result_id"
>


<label>
Quarterly Marks / 50
</label>


<input
type="number"
name="quarterly_marks"
id="quarterly_marks"
min="0"
max="50"
required
>


<br><br>


<label>
Half Yearly Marks / 50
</label>


<input
type="number"
name="half_yearly_marks"
id="half_yearly_marks"
min="0"
max="50"
required
>


<br><br>


<label>
Annual Marks / 50
</label>


<input
type="number"
name="annual_marks"
id="annual_marks"
min="0"
max="50"
required
>


<br><br>


<button
type="submit"
name="update_result"
>

💾 Update Result

</button>


</form>


</div>



<a
class="back"
href="teacher-dashboard.php"
>

⬅ Back to Teacher Dashboard

</a>


</div>



<script>

function showEdit(
    id,
    quarterly,
    halfyearly,
    annual
)
{

    document.getElementById(
        "editBox"
    ).style.display = "block";


    document.getElementById(
        "result_id"
    ).value = id;


    document.getElementById(
        "quarterly_marks"
    ).value = quarterly;


    document.getElementById(
        "half_yearly_marks"
    ).value = halfyearly;


    document.getElementById(
        "annual_marks"
    ).value = annual;


    window.scrollTo(
        0,
        document.getElementById(
            "editBox"
        ).offsetTop
    );

}

</script>


</body>

</html>