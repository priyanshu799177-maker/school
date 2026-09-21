<?php

session_start();
include "connection.php";


/* PRINCIPAL LOGIN CHECK */

if(!isset($_SESSION['principal']))
{
    header("Location: principal-login.php");
    exit();
}


/* SELECTED CLASS */

$selected_class = "";

if(isset($_POST['class']))
{
    $selected_class = $_POST['class'];
}


/* SELECTED STUDENT */

$selected_student = "";

if(isset($_POST['student_id']))
{
    $selected_student = intval($_POST['student_id']);
}


/* SAVE TOTAL FEE */

if(isset($_POST['save_total_fee']))
{
    $student_id = intval($_POST['student_id']);
    $total_fee = floatval($_POST['total_fee']);


    if($total_fee <= 0)
    {
        echo "<script>
        alert('Total Fee valid honi chahiye');
        </script>";
    }
    else
    {
        $check = mysqli_query(
            $conn,
            "SELECT id
             FROM student_fees
             WHERE student_id='$student_id'
             LIMIT 1"
        );


        if(mysqli_num_rows($check) > 0)
        {
            echo "<script>
            alert('Total Fee already set hai');
            </script>";
        }
        else
        {
            $sql = "INSERT INTO student_fees
                    (student_id,total_fee)
                    VALUES
                    ('$student_id','$total_fee')";


            if(mysqli_query($conn,$sql))
            {
                echo "<script>
                alert('Total Fee Set Successfully');
                window.location.href='add-fee.php';
                </script>";

                exit();
            }
            else
            {
                echo "<script>
                alert('Database Error: " .
                mysqli_error($conn) .
                "');
                </script>";
            }
        }
    }
}


/* SAVE PAYMENT */

if(isset($_POST['save_payment']))
{
    $student_id = intval($_POST['student_id']);

    $paid_amount = floatval($_POST['paid_amount']);

    $payment_date = $_POST['payment_date'];


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
        die("Fee Query Error: " . mysqli_error($conn));
    }


    $fee_data = mysqli_fetch_assoc($fee_query);


    if(!$fee_data)
    {
        echo "<script>
        alert('Pehle Total Fee Set karo');
        </script>";
    }
    else
    {
        $total_fee = floatval(
            $fee_data['total_fee']
        );


        /* GET ALREADY PAID */

        $paid_query = mysqli_query(
            $conn,
            "SELECT SUM(paid_amount) AS total_paid
             FROM fee_payments
             WHERE student_id='$student_id'"
        );


        $paid_data = mysqli_fetch_assoc(
            $paid_query
        );


        $already_paid = floatval(
            $paid_data['total_paid']
        );


        $remaining_fee =
            $total_fee - $already_paid;


        /* CHECK PAYMENT */

        if($paid_amount <= 0)
        {
            echo "<script>
            alert('Payment Amount valid honi chahiye');
            </script>";
        }
        elseif($paid_amount > $remaining_fee)
        {
            echo "<script>
            alert('Payment remaining fee se zyada nahi ho sakti');
            </script>";
        }
        else
        {
            $sql = "INSERT INTO fee_payments
                    (
                        student_id,
                        paid_amount,
                        payment_date
                    )

                    VALUES
                    (
                        '$student_id',
                        '$paid_amount',
                        '$payment_date'
                    )";


            if(mysqli_query($conn,$sql))
            {
                echo "<script>
                alert('Payment Saved Successfully');
                window.location.href='add-fee.php';
                </script>";

                exit();
            }
            else
            {
                echo "<script>
                alert('Database Error: " .
                mysqli_error($conn) .
                "');
                </script>";
            }
        }
    }
}


/* GET CLASSES */

$class_query = mysqli_query(
    $conn,
    "SELECT DISTINCT class
     FROM students
     ORDER BY class ASC"
);


/* GET STUDENTS */

$student_list = false;

if($selected_class != "")
{
    $safe_class = mysqli_real_escape_string(
        $conn,
        $selected_class
    );


    $student_list = mysqli_query(
        $conn,
        "SELECT id,name,class
         FROM students
         WHERE class='$safe_class'
         ORDER BY name ASC"
    );
}


/* GET SELECTED STUDENT FEE */

$total_fee = 0;
$total_paid = 0;
$remaining_fee = 0;
$fee_exists = false;


if($selected_student > 0)
{
    $fee_query = mysqli_query(
        $conn,
        "SELECT total_fee
         FROM student_fees
         WHERE student_id='$selected_student'
         LIMIT 1"
    );


    if(mysqli_num_rows($fee_query) > 0)
    {
        $fee = mysqli_fetch_assoc(
            $fee_query
        );

        $total_fee =
            floatval($fee['total_fee']);

        $fee_exists = true;
    }


    $paid_query = mysqli_query(
        $conn,
        "SELECT SUM(paid_amount) AS total_paid
         FROM fee_payments
         WHERE student_id='$selected_student'"
    );


    $paid_data = mysqli_fetch_assoc(
        $paid_query
    );


    $total_paid = floatval(
        $paid_data['total_paid']
    );


    $remaining_fee =
        $total_fee - $total_paid;
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Student Fee Management</title>


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
    width:500px;
    max-width:90%;
    margin:30px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}


label
{
    display:block;
    margin-top:15px;
    font-weight:bold;
}


select,
input
{
    width:100%;
    box-sizing:border-box;
    padding:10px;
    margin-top:7px;
    border:1px solid #aaa;
    border-radius:5px;
}


button
{
    width:100%;
    margin-top:20px;
    padding:12px;
    background:#004aad;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:16px;
}


button:hover
{
    background:#003580;
}


.info
{
    background:#eef5ff;
    padding:15px;
    margin-top:20px;
    border-radius:8px;
}


.info p
{
    font-size:17px;
}


.back
{
    display:block;
    text-align:center;
    margin-top:20px;
    color:#004aad;
    text-decoration:none;
    font-weight:bold;
}


.warning
{
    background:#fff3cd;
    padding:12px;
    border-radius:5px;
    margin-top:15px;
}


.success
{
    background:#d4edda;
    padding:12px;
    border-radius:5px;
    margin-top:15px;
}

</style>

</head>


<body>


<div class="header">

<h1>💰 Student Fee Management</h1>

<p>Principal Panel</p>

</div>


<!-- CLASS -->

<div class="box">

<h2>🏫 Select Class</h2>


<form method="POST">

<label>
Class
</label>


<select
name="class"
onchange="this.form.submit()"
required
>

<option value="">
Select Class
</option>


<?php

while($class_row =
      mysqli_fetch_assoc($class_query))
{

?>


<option
value="<?php

echo htmlspecialchars(
    $class_row['class']
);

?>"

<?php

if(
    $selected_class ==
    $class_row['class']
)
{
    echo "selected";
}

?>

>

Class

<?php

echo htmlspecialchars(
    $class_row['class']
);

?>

</option>


<?php

}

?>

</select>

</form>

</div>



<?php

if($selected_class != "")
{

?>


<!-- STUDENT -->

<div class="box">

<h2>👨‍🎓 Select Student</h2>


<form method="POST">

<input
type="hidden"
name="class"
value="<?php

echo htmlspecialchars(
    $selected_class
);

?>"
>


<label>
Student Name
</label>


<select
name="student_id"
onchange="this.form.submit()"
required
>

<option value="">
Select Student
</option>


<?php

while($student =
      mysqli_fetch_assoc($student_list))
{

?>


<option
value="<?php

echo $student['id'];

?>"

<?php

if(
    $selected_student ==
    $student['id']
)
{
    echo "selected";
}

?>

>

<?php

echo htmlspecialchars(
    $student['name']
);

?>

</option>


<?php

}

?>


</select>

</form>

</div>


<?php

}

?>



<?php

if($selected_student > 0)
{

?>


<!-- FEE INFORMATION -->

<div class="box">

<h2>🧾 Fee Information</h2>


<?php

if(!$fee_exists)
{

?>


<div class="warning">

⚠️ Is student ki Total Fee abhi set nahi hai.

</div>


<form method="POST">

<input
type="hidden"
name="student_id"
value="<?php

echo $selected_student;

?>"
>


<label>
Total Fee
</label>

<input
type="number"
name="total_fee"
placeholder="Enter Total Fee"
min="1"
step="0.01"
required
>


<button
type="submit"
name="save_total_fee"
>

💾 Set Total Fee

</button>

</form>


<?php

}
else
{

?>


<div class="success">

✅ Total Fee already set hai.

</div>


<div class="info">

<p>

<strong>Total Fee:</strong>

₹<?php

echo number_format(
    $total_fee,
    2
);

?>

</p>


<p>

<strong>Total Paid:</strong>

₹<?php

echo number_format(
    $total_paid,
    2
);

?>

</p>


<p>

<strong>Remaining Fee:</strong>

₹<?php

echo number_format(
    $remaining_fee,
    2
);

?>

</p>

</div>


<?php

if($remaining_fee > 0)
{

?>


<hr>


<h3>💵 Add New Payment</h3>


<form method="POST">

<input
type="hidden"
name="student_id"
value="<?php

echo $selected_student;

?>"
>


<label>
Payment Amount
</label>

<input
type="number"
name="paid_amount"
placeholder="Enter Payment Amount"
min="1"
max="<?php

echo $remaining_fee;

?>"
step="0.01"
required
>


<label>
Payment Date
</label>

<input
type="date"
name="payment_date"
value="<?php

echo date('Y-m-d');

?>"
required
>


<button
type="submit"
name="save_payment"
>

💾 Save Payment

</button>

</form>


<?php

}
else
{

?>


<div class="success">

🎉 **Full Fee Paid**

<br><br>

Is student ki koi fee remaining nahi hai.

</div>


<?php

}

}

?>

</div>


<?php

}

?>


<div class="box">

<a
class="back"
href="principal-dashboard.php"
>

⬅ Back to Principal Dashboard

</a>

</div>


</body>

</html>