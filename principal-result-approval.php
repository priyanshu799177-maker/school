<?php

session_start();
include "connection.php";


/* =====================================================
   PRINCIPAL LOGIN CHECK
===================================================== */

if(!isset($_SESSION['principal']))
{
    header("Location: principal-login.php");
    exit();
}


/* =====================================================
   SAVE PRINCIPAL REMARK
===================================================== */

if(isset($_POST['save_remark']))
{
    $student_id = intval($_POST['student_id']);

    $principal_remarks = mysqli_real_escape_string(
        $conn,
        trim($_POST['principal_remarks'])
    );


    $update = mysqli_query(
        $conn,
        "UPDATE results
         SET principal_remarks='$principal_remarks'
         WHERE student_id='$student_id'"
    );


    if($update)
    {
        echo "<script>
        alert('Principal Remark Saved Successfully');
        window.location.href='principal-result-approval.php';
        </script>";

        exit();
    }
    else
    {
        echo "<script>
        alert('Remark Error: ".mysqli_error($conn)."');
        </script>";
    }
}


/* =====================================================
   APPROVE COMPLETE RESULT
===================================================== */

if(isset($_POST['approve_result']))
{
    $student_id = intval($_POST['student_id']);


    $update = mysqli_query(
        $conn,
        "UPDATE results
         SET approval_status='Approved'
         WHERE student_id='$student_id'"
    );


    if($update)
    {
        echo "<script>
        alert('Result Approved Successfully');
        window.location.href='principal-result-approval.php';
        </script>";

        exit();
    }
    else
    {
        echo "<script>
        alert('Approval Error: ".mysqli_error($conn)."');
        </script>";
    }
}


/* =====================================================
   GET STUDENTS HAVING RESULT
===================================================== */

$students_query = mysqli_query(
    $conn,

    "SELECT DISTINCT
        student_id,
        student_name,
        class
     FROM results
     ORDER BY class, student_name"
);


if(!$students_query)
{
    die(
        "Database Error: " .
        mysqli_error($conn)
    );
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Principal Result Approval
</title>


<style>

body
{
    margin:0;

    font-family:Arial, sans-serif;

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
    margin:5px;
}


.header p
{
    margin:5px;
}


/* CONTAINER */

.container
{
    width:95%;

    max-width:1200px;

    margin:30px auto;
}


/* BACK BUTTON */

.back
{
    display:inline-block;

    margin-bottom:25px;

    padding:12px 20px;

    background:#555;

    color:white;

    text-decoration:none;

    border-radius:5px;
}


/* STUDENT CARD */

.card
{
    background:white;

    padding:20px;

    margin-bottom:30px;

    border-radius:10px;

    box-shadow:0 0 10px #ccc;
}


/* STUDENT HEADER */

.student-header
{
    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    border-bottom:2px solid #ddd;

    padding-bottom:15px;
}


.student-header h2
{
    margin:5px 0;

    color:#004aad;
}


/* STATUS */

.status
{
    padding:8px 14px;

    border-radius:5px;

    font-weight:bold;
}


.pending
{
    background:#fff3cd;

    color:#856404;
}


.approved
{
    background:#d1e7dd;

    color:#0f5132;
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

    margin-top:20px;

    min-width:750px;
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


.subject
{
    text-align:left;

    font-weight:bold;
}


.total
{
    background:#eeeeee;

    font-weight:bold;
}


/* SUMMARY */

.summary
{
    display:grid;

    grid-template-columns:
    repeat(4,1fr);

    margin-top:20px;

    border:1px solid #aaa;
}


.summary-box
{
    padding:15px;

    text-align:center;

    border-right:1px solid #aaa;
}


.summary-box:last-child
{
    border-right:none;
}


.summary-box span
{
    display:block;

    font-size:20px;

    font-weight:bold;

    margin-top:6px;
}


/* REMARK BOX */

.remark-box
{
    margin-top:25px;

    padding:18px;

    background:#f7f9fc;

    border:1px solid #aaa;

    border-radius:8px;
}


.remark-box h3
{
    color:#004aad;

    margin-top:0;
}


textarea
{
    width:100%;

    min-height:100px;

    padding:12px;

    box-sizing:border-box;

    border:1px solid #aaa;

    border-radius:5px;

    font-family:Arial;

    font-size:15px;

    resize:vertical;
}


/* BUTTONS */

.save-btn
{
    margin-top:12px;

    background:#004aad;

    color:white;

    border:none;

    padding:11px 20px;

    border-radius:5px;

    cursor:pointer;

    font-size:15px;
}


.save-btn:hover
{
    background:#003580;
}


.approve-btn
{
    width:100%;

    margin-top:20px;

    background:#198754;

    color:white;

    border:none;

    padding:13px;

    border-radius:5px;

    cursor:pointer;

    font-size:16px;

    font-weight:bold;
}


.approve-btn:hover
{
    background:#146c43;
}


/* NO RESULT */

.no-result
{
    background:white;

    padding:50px;

    text-align:center;

    border-radius:10px;
}


/* MOBILE */

@media(max-width:700px)
{

.summary
{
    grid-template-columns:1fr 1fr;
}

.summary-box
{
    border-bottom:1px solid #aaa;
}

}

</style>

</head>


<body>


<!-- =====================================================
     HEADER
===================================================== -->

<div class="header">

<h1>
📊 Result Approval
</h1>

<p>
Principal Panel
</p>

</div>



<div class="container">


<a
href="principal-dashboard.php"
class="back"
>

⬅ Back to Principal Dashboard

</a>



<?php


/* =====================================================
   NO RESULT
===================================================== */

if(mysqli_num_rows($students_query) == 0)
{

?>

<div class="no-result">

<h2>
📭 No Result Found
</h2>

<p>
Abhi kisi student ka result available nahi hai.
</p>

</div>

<?php

}


/* =====================================================
   STUDENT LOOP
===================================================== */

while(
    $student =
    mysqli_fetch_assoc(
        $students_query
    )
)
{

    $student_id =
        intval(
            $student['student_id']
        );


    /* GET RESULTS */

    $result_query = mysqli_query(
        $conn,

        "SELECT *
         FROM results
         WHERE student_id='$student_id'
         ORDER BY id ASC"
    );


    if(!$result_query)
    {
        continue;
    }


    $rows = array();


    $total_quarterly = 0;

    $total_half_yearly = 0;

    $total_annual = 0;


    $max_quarterly = 0;

    $max_half_yearly = 0;

    $max_annual = 0;


    $approved = true;


    $principal_remark = "";


    while(
        $row =
        mysqli_fetch_assoc(
            $result_query
        )
    )
    {

        $rows[] = $row;


        $total_quarterly +=
            intval(
                $row['quarterly_marks']
            );


        $total_half_yearly +=
            intval(
                $row['half_yearly_marks']
            );


        $total_annual +=
            intval(
                $row['annual_marks']
            );


        $max_quarterly +=
            intval(
                $row['quarterly_total']
            );


        $max_half_yearly +=
            intval(
                $row['half_yearly_total']
            );


        $max_annual +=
            intval(
                $row['annual_total']
            );


        if(
            $row['approval_status']
            != 'Approved'
        )
        {
            $approved = false;
        }


        if(
            $principal_remark == "" &&
            isset(
                $row['principal_remarks']
            )
        )
        {
            $principal_remark =
                $row['principal_remarks'];
        }

    }


    if(count($rows) == 0)
    {
        continue;
    }


    /* TOTAL */

    $grand_total =
        $total_quarterly +
        $total_half_yearly +
        $total_annual;


    $grand_max =
        $max_quarterly +
        $max_half_yearly +
        $max_annual;


    /* PERCENTAGE */

    if($grand_max > 0)
    {
        $percentage =
            ($grand_total / $grand_max) * 100;
    }
    else
    {
        $percentage = 0;
    }


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

?>


<!-- =====================================================
     STUDENT CARD
===================================================== -->

<div class="card">


<!-- STUDENT HEADER -->

<div class="student-header">


<div>

<h2>

👨‍🎓

<?php

echo htmlspecialchars(
    $student['student_name']
);

?>

</h2>


<p>

<strong>
Student ID:
</strong>

<?php

echo $student_id;

?>


&nbsp;&nbsp;&nbsp;


<strong>
Class:
</strong>

<?php

echo htmlspecialchars(
    $student['class']
);

?>

</p>

</div>



<!-- STATUS -->

<div>

<?php

if($approved)
{

?>

<span class="status approved">

✅ APPROVED

</span>

<?php

}
else
{

?>

<span class="status pending">

⏳ PENDING

</span>

<?php

}

?>

</div>


</div>



<!-- =====================================================
     COMPLETE RESULT TABLE
===================================================== -->

<div class="table-container">

<table>


<tr>

<th rowspan="2">
S.No.
</th>

<th rowspan="2">
SUBJECT
</th>

<th colspan="2">
QUARTERLY
</th>

<th colspan="2">
HALF YEARLY
</th>

<th colspan="2">
ANNUAL
</th>

</tr>


<tr>

<th>
Marks
</th>

<th>
Total
</th>

<th>
Marks
</th>

<th>
Total
</th>

<th>
Marks
</th>

<th>
Total
</th>

</tr>


<?php

$serial = 1;


foreach($rows as $row)
{

?>

<tr>


<td>

<?php

echo $serial++;

?>

</td>


<td class="subject">

<?php

echo htmlspecialchars(
    $row['subject']
);

?>

</td>


<td>

<?php

echo intval(
    $row['quarterly_marks']
);

?>

</td>


<td>

<?php

echo intval(
    $row['quarterly_total']
);

?>

</td>


<td>

<?php

echo intval(
    $row['half_yearly_marks']
);

?>

</td>


<td>

<?php

echo intval(
    $row['half_yearly_total']
);

?>

</td>


<td>

<?php

echo intval(
    $row['annual_marks']
);

?>

</td>


<td>

<?php

echo intval(
    $row['annual_total']
);

?>

</td>


</tr>


<?php

}

?>


<!-- TOTAL -->

<tr class="total">


<td colspan="2">

TOTAL

</td>


<td>

<?php

echo $total_quarterly;

?>

</td>


<td>

<?php

echo $max_quarterly;

?>

</td>


<td>

<?php

echo $total_half_yearly;

?>

</td>


<td>

<?php

echo $max_half_yearly;

?>

</td>


<td>

<?php

echo $total_annual;

?>

</td>


<td>

<?php

echo $max_annual;

?>

</td>


</tr>


</table>

</div>



<!-- =====================================================
     SUMMARY
===================================================== -->

<div class="summary">


<div class="summary-box">

Total Marks

<span>

<?php

echo $grand_total .
" / " .
$grand_max;

?>

</span>

</div>


<div class="summary-box">

Percentage

<span>

<?php

echo number_format(
    $percentage,
    2
);

?>%

</span>

</div>


<div class="summary-box">

Grade

<span>

<?php

echo $grade;

?>

</span>

</div>


<div class="summary-box">

Status

<span>

<?php

echo $approved
    ? "APPROVED"
    : "PENDING";

?>

</span>

</div>


</div>



<!-- =====================================================
     PRINCIPAL REMARKS
     APPROVE BUTTON SE PEHLE
===================================================== -->

<div class="remark-box">


<h3>
📝 Principal Remarks
</h3>


<form method="POST">


<input
type="hidden"
name="student_id"
value="<?php echo $student_id; ?>"
>


<textarea
name="principal_remarks"
placeholder="Student ke liye Principal ka remark likhein..."
required
><?php

echo htmlspecialchars(
    $principal_remark
);

?></textarea>


<br>


<button
type="submit"
name="save_remark"
class="save-btn"
>

💾 Save Remark

</button>


</form>


</div>



<!-- =====================================================
     APPROVE BUTTON
===================================================== -->

<?php

if(!$approved)
{

?>

<form
method="POST"
style="margin-top:20px;"
>


<input
type="hidden"
name="student_id"
value="<?php echo $student_id; ?>"
>


<button
type="submit"
name="approve_result"
class="approve-btn"
>

✅ Approve Complete Result

</button>


</form>


<?php

}
else
{

?>

<div
style="
margin-top:20px;
padding:12px;
background:#d1e7dd;
color:#0f5132;
text-align:center;
border-radius:5px;
font-weight:bold;
"
>

✅ This Result is Already Approved

</div>

<?php

}

?>


</div>


<?php

}

?>


</div>


</body>

</html>