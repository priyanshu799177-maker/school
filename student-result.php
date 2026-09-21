<?php

session_start();
include "connection.php";


/* =====================================================
   STUDENT LOGIN CHECK
===================================================== */

if(!isset($_SESSION['student_id']))
{
    header("Location: student-login.php");
    exit();
}


$student_id = intval($_SESSION['student_id']);


/* =====================================================
   STUDENT DETAILS
===================================================== */

$student_query = mysqli_query(
    $conn,
    "SELECT id, name, class
     FROM students
     WHERE id='$student_id'
     LIMIT 1"
);


if(!$student_query)
{
    die(
        "Database Error: " .
        mysqli_error($conn)
    );
}


$student = mysqli_fetch_assoc(
    $student_query
);


if(!$student)
{
    die("Student details not found.");
}


/* =====================================================
   RESULT
===================================================== */

$result = mysqli_query(
    $conn,
    "SELECT *
     FROM results
     WHERE student_id='$student_id'
     AND approval_status='Approved'
     ORDER BY id ASC"
);


if(!$result)
{
    die(
        "Result Error: " .
        mysqli_error($conn)
    );
}


/* =====================================================
   TOTALS
===================================================== */

$total_quarterly = 0;
$total_half_yearly = 0;
$total_annual = 0;

$max_quarterly = 0;
$max_half_yearly = 0;
$max_annual = 0;

$rows = array();


while($row = mysqli_fetch_assoc($result))
{
    $rows[] = $row;


    $total_quarterly += intval(
        $row['quarterly_marks']
    );


    $total_half_yearly += intval(
        $row['half_yearly_marks']
    );


    $total_annual += intval(
        $row['annual_marks']
    );


    $max_quarterly += intval(
        $row['quarterly_total']
    );


    $max_half_yearly += intval(
        $row['half_yearly_total']
    );


    $max_annual += intval(
        $row['annual_total']
    );
}


/* =====================================================
   GRAND TOTAL
===================================================== */

$grand_total =
    $total_quarterly +
    $total_half_yearly +
    $total_annual;


$grand_max =
    $max_quarterly +
    $max_half_yearly +
    $max_annual;


/* =====================================================
   PERCENTAGE
===================================================== */

if($grand_max > 0)
{
    $percentage =
        ($grand_total / $grand_max) * 100;
}
else
{
    $percentage = 0;
}


/* =====================================================
   GRADE
===================================================== */

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


/* =====================================================
   RESULT STATUS
===================================================== */

if($percentage >= 33)
{
    $status = "PASS";
}
else
{
    $status = "FAIL";
}


/* =====================================================
   PRINCIPAL REMARK
===================================================== */

$remarks = "Principal remark not added yet.";


$remark_query = mysqli_query(
    $conn,
    "SELECT principal_remarks
     FROM results
     WHERE student_id='$student_id'
     AND principal_remarks IS NOT NULL
     AND principal_remarks != ''
     LIMIT 1"
);


if($remark_query)
{
    $remark_data =
        mysqli_fetch_assoc(
            $remark_query
        );


    if(
        $remark_data &&
        !empty(
            $remark_data['principal_remarks']
        )
    )
    {
        $remarks =
            $remark_data['principal_remarks'];
    }
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>
Student Report Card
</title>


<style>

*{
    box-sizing:border-box;
}


body
{
    margin:0;

    font-family:Arial,sans-serif;

    background:#e9eef5;
}


.report
{
    width:95%;

    max-width:1100px;

    margin:30px auto;

    background:white;

    padding:30px;

    border:2px solid #004aad;

    box-shadow:0 0 15px #aaa;
}


/* SCHOOL HEADER */

.school
{
    text-align:center;

    border-bottom:2px solid #004aad;

    padding-bottom:15px;

    margin-bottom:15px;
}


.school h1
{
    margin:5px;

    color:#004aad;

    font-size:32px;

    text-transform:uppercase;
}


.school h2
{
    margin:5px;

    color:#222;

    font-size:24px;
}


.session
{
    text-align:center;

    font-weight:bold;

    margin:15px;
}


/* STUDENT DETAILS */

.details
{
    display:grid;

    grid-template-columns:
    repeat(3,1fr);

    gap:10px;

    border:1px solid #333;

    padding:15px;

    margin-bottom:20px;

    background:#f7f9fc;
}


.detail-box
{
    padding:5px;
}


.detail-title
{
    font-size:13px;

    color:#555;

    margin-bottom:5px;
}


.detail-value
{
    font-size:16px;

    font-weight:bold;
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

    min-width:750px;
}


th,
td
{
    border:1px solid #333;

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


.total-row
{
    font-weight:bold;

    background:#eeeeee;
}


/* SUMMARY */

.summary
{
    margin-top:20px;

    display:grid;

    grid-template-columns:
    repeat(4,1fr);

    border:1px solid #333;
}


.summary-box
{
    padding:15px;

    text-align:center;

    border-right:1px solid #333;
}


.summary-box:last-child
{
    border-right:none;
}


.summary-title
{
    font-size:14px;

    color:#555;
}


.summary-value
{
    display:block;

    font-size:22px;

    font-weight:bold;

    margin-top:7px;
}


/* RESULT */

.pass
{
    color:green;
}


.fail
{
    color:red;
}


/* PRINCIPAL REMARK */

.remarks
{
    margin-top:25px;

    border:1px solid #333;

    padding:18px;

    background:#f7f9fc;

    min-height:80px;
}


.remarks-title
{
    color:#004aad;

    font-weight:bold;

    margin-bottom:10px;
}


.remarks-text
{
    font-size:16px;

    line-height:1.5;
}


/* SIGNATURE */

.signatures
{
    display:flex;

    justify-content:space-between;

    margin-top:70px;
}


.signature
{
    width:200px;

    text-align:center;

    border-top:1px solid #333;

    padding-top:8px;
}


/* BUTTONS */

.buttons
{
    text-align:center;

    margin-top:30px;
}


.back,
.print
{
    display:inline-block;

    padding:12px 20px;

    margin:5px;

    border:none;

    border-radius:5px;

    color:white;

    text-decoration:none;

    cursor:pointer;

    font-size:15px;
}


.back
{
    background:#004aad;
}


.print
{
    background:#333;
}


/* NO RESULT */

.no-result
{
    text-align:center;

    padding:50px;

    color:#777;
}


/* MOBILE */

@media(max-width:700px)
{

.details
{
    grid-template-columns:1fr;
}


.summary
{
    grid-template-columns:1fr 1fr;
}


.summary-box
{
    border-bottom:1px solid #333;
}


.signatures
{
    margin-top:50px;
}

}


/* PRINT */

@media print
{

body
{
    background:white;
}


.report
{
    width:100%;

    margin:0;

    padding:15px;

    border:1px solid #000;

    box-shadow:none;
}


.buttons
{
    display:none;
}


@page
{
    size:A4;

    margin:10mm;
}

}

</style>

</head>


<body>


<div class="report">


<!-- =====================================================
     SCHOOL HEADER
===================================================== -->

<div class="school">

<h1>
S.K.L Public School
</h1>

<h2>
REPORT CARD
</h2>

</div>


<div class="session">

SESSION: 2026-2027

</div>



<!-- =====================================================
     STUDENT DETAILS
===================================================== -->

<div class="details">


<div class="detail-box">

<div class="detail-title">
Student Name
</div>

<div class="detail-value">

<?php

echo htmlspecialchars(
    $student['name']
);

?>

</div>

</div>



<div class="detail-box">

<div class="detail-title">
Student ID / Roll No.
</div>

<div class="detail-value">

<?php

echo htmlspecialchars(
    $student['id']
);

?>

</div>

</div>



<div class="detail-box">

<div class="detail-title">
Class
</div>

<div class="detail-value">

<?php

echo htmlspecialchars(
    $student['class']
);

?>

</div>

</div>


</div>



<?php

/* =====================================================
   CHECK APPROVED RESULT
===================================================== */

if(count($rows) == 0)
{

?>


<div class="no-result">

<h2>
📭 Result Not Available
</h2>

<p>
Aapka result abhi Principal dwara approve nahi kiya gaya hai.
</p>

</div>


<?php

}
else
{

?>


<!-- =====================================================
     RESULT TABLE
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

<tr class="total-row">


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

<div class="summary-title">
TOTAL MARKS
</div>

<span class="summary-value">

<?php

echo $grand_total .
" / " .
$grand_max;

?>

</span>

</div>



<div class="summary-box">

<div class="summary-title">
PERCENTAGE
</div>

<span class="summary-value">

<?php

echo number_format(
    $percentage,
    2
);

?>%

</span>

</div>



<div class="summary-box">

<div class="summary-title">
GRADE
</div>

<span class="summary-value">

<?php

echo $grade;

?>

</span>

</div>



<div class="summary-box">

<div class="summary-title">
RESULT
</div>

<span class="summary-value <?php

echo ($status == "PASS")
    ? "pass"
    : "fail";

?>">

<?php

echo $status;

?>

</span>

</div>


</div>



<!-- =====================================================
     PRINCIPAL REMARK
===================================================== -->

<div class="remarks">


<div class="remarks-title">

📝 Principal's Remarks

</div>


<div class="remarks-text">

<?php

echo nl2br(
    htmlspecialchars(
        $remarks
    )
);

?>

</div>


</div>



<!-- =====================================================
     SIGNATURE
===================================================== -->

<div class="signatures">


<div class="signature">

Class Teacher

</div>


<div class="signature">

Principal

</div>


</div>


<?php

}

?>


<!-- =====================================================
     BUTTONS
===================================================== -->

<div class="buttons">


<a
class="back"
href="student-dashboard.php"
>

⬅ Back to Dashboard

</a>


<button
class="print"
onclick="window.print()"
>

🖨️ Print Report Card

</button>


</div>


</div>


</body>

</html>