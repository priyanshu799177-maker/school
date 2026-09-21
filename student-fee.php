<?php

session_start();
include "connection.php";


/* STUDENT LOGIN CHECK */

if(!isset($_SESSION['student']))
{
    header("Location: student-login.php");
    exit();
}


$student_id = intval($_SESSION['student_id']);

$student_name = $_SESSION['student_name'];

$student_class = $_SESSION['class'];


/* GET TOTAL FEE */

$fee_query = mysqli_query(
    $conn,
    "SELECT total_fee
     FROM student_fees
     WHERE student_id='$student_id'
     LIMIT 1"
);

if(!$fee_query)
{
    die("Fee Error: " . mysqli_error($conn));
}


$fee_data = mysqli_fetch_assoc($fee_query);


$total_fee = 0;

if($fee_data)
{
    $total_fee = floatval($fee_data['total_fee']);
}


/* GET TOTAL PAID */

$paid_query = mysqli_query(
    $conn,
    "SELECT SUM(paid_amount) AS total_paid
     FROM fee_payments
     WHERE student_id='$student_id'"
);

if(!$paid_query)
{
    die("Payment Error: " . mysqli_error($conn));
}


$paid_data = mysqli_fetch_assoc($paid_query);


$total_paid = floatval(
    $paid_data['total_paid']
);


/* REMAINING */

$remaining_fee =
    $total_fee - $total_paid;


/* GET PAYMENT HISTORY */

$payments = mysqli_query(
    $conn,
    "SELECT paid_amount, payment_date
     FROM fee_payments
     WHERE student_id='$student_id'
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>My Fee Status</title>


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
    max-width:850px;
    margin:30px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}


.cards
{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}


.card
{
    flex:1;
    min-width:180px;
    padding:20px;
    text-align:center;
    border:1px solid #ddd;
    border-radius:10px;
}


.card h3
{
    margin:5px;
}


.amount
{
    font-size:24px;
    font-weight:bold;
    margin-top:10px;
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
}


td
{
    border:1px solid #ccc;
    padding:12px;
    text-align:center;
}


.back
{
    display:inline-block;
    background:#004aad;
    color:white;
    padding:10px 15px;
    text-decoration:none;
    border-radius:5px;
}


.no-fee
{
    text-align:center;
    padding:30px;
    color:#777;
}

</style>

</head>


<body>


<div class="header">

<h1>💰 My Fee Status</h1>

<p>

Student:

<strong>

<?php

echo htmlspecialchars($student_name);

?>

</strong>

</p>


<p>

Class:

<strong>

<?php

echo htmlspecialchars($student_class);

?>

</strong>

</p>

</div>



<div class="box">

<?php

if(!$fee_data)
{

?>

<div class="no-fee">

<h2>📭 Fee Details Not Found</h2>

<p>
School ne abhi aapki total fee set nahi ki hai.
</p>

</div>

<?php

}
else
{

?>


<h2>🧾 Fee Summary</h2>


<div class="cards">


<div class="card">

<h3>💰 Total Fee</h3>

<div class="amount">

₹<?php

echo number_format(
    $total_fee,
    2
);

?>

</div>

</div>


<div class="card">

<h3>💵 Total Paid</h3>

<div class="amount">

₹<?php

echo number_format(
    $total_paid,
    2
);

?>

</div>

</div>


<div class="card">

<h3>🧾 Remaining</h3>

<div class="amount">

₹<?php

echo number_format(
    $remaining_fee,
    2
);

?>

</div>

</div>


</div>



<h2>📋 Payment History</h2>


<?php

if(mysqli_num_rows($payments) == 0)
{

?>

<div class="no-fee">

No payment recorded yet.

</div>

<?php

}
else
{

?>


<table>

<tr>

<th>Payment Amount</th>

<th>Payment Date</th>

</tr>


<?php

while($payment =
      mysqli_fetch_assoc($payments))
{

?>


<tr>

<td>

₹<?php

echo number_format(
    $payment['paid_amount'],
    2
);

?>

</td>


<td>

<?php

echo htmlspecialchars(
    $payment['payment_date']
);

?>

</td>

</tr>


<?php

}

?>


</table>


<?php

}

?>


<?php

}

?>

</div>



<div class="box">

<a
class="back"
href="student-dashboard.php"
>

⬅ Back to Student Dashboard

</a>

</div>


</body>

</html>