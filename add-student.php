<?php

session_start();
include "connection.php";


/* =========================
   PRINCIPAL / ADMIN ACCESS
========================= */

$is_principal = isset($_SESSION['principal']);
$is_admin = isset($_SESSION['admin']);


/* Only Principal or Admin */

if (!$is_principal && !$is_admin) {

    echo "<script>
            alert('Access Denied! Only Principal and Admin can add students.');
            window.location='student-login.php';
          </script>";

    exit();
}


/* =========================
   ADD STUDENT
========================= */

if (isset($_POST['save'])) {

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['name']
    );

    $father = mysqli_real_escape_string(
        $conn,
        $_POST['father']
    );

    $class = mysqli_real_escape_string(
        $conn,
        $_POST['class']
    );

    $mobile = mysqli_real_escape_string(
        $conn,
        $_POST['mobile']
    );

    $address = mysqli_real_escape_string(
        $conn,
        $_POST['address']
    );

    $dob = mysqli_real_escape_string(
        $conn,
        $_POST['dob']
    );

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password = mysqli_real_escape_string(
        $conn,
        $_POST['password']
    );


    /* Check Duplicate Username */

    $check_sql = "
    SELECT id
    FROM students
    WHERE username='$username'
    LIMIT 1
    ";

    $check_result = mysqli_query(
        $conn,
        $check_sql
    );


    if (mysqli_num_rows($check_result) > 0) {

        echo "<script>
                alert('Username already exists. Please use another username.');
              </script>";

    } else {


        /* Insert Student */

        $sql = "
        INSERT INTO students
        (
            name,
            father_name,
            class,
            mobile,
            address,
            dob,
            username,
            password
        )

        VALUES
        (
            '$name',
            '$father',
            '$class',
            '$mobile',
            '$address',
            '$dob',
            '$username',
            '$password'
        )
        ";


        if (mysqli_query($conn, $sql)) {

            echo "<script>
                    alert('Student Added Successfully!');
                    window.location='add-student.php';
                  </script>";

            exit();

        } else {

            echo "Database Error: " .
                 mysqli_error($conn);

        }

    }

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>Add Student</title>


<style>

body {
    font-family: Arial, sans-serif;
    background: #f2f2f2;
    margin: 0;
    padding: 20px;
}

.box {
    width: 450px;
    max-width: 95%;
    margin: 30px auto;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 0 10px #ccc;
}

h2 {
    text-align: center;
    color: #004aad;
}

label {
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 12px;
    background: #004aad;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
}

button:hover {
    background: #003580;
}

.back {
    display: block;
    text-align: center;
    background: #555;
    color: white;
    text-decoration: none;
    padding: 10px;
    border-radius: 5px;
}

</style>

</head>


<body>


<div class="box">

<h2>👨‍🎓 Add Student</h2>


<form method="POST">


<label>Student Name</label>

<input
    type="text"
    name="name"
    required
>

<br><br>


<label>Father Name</label>

<input
    type="text"
    name="father"
    required
>

<br><br>


<label>Class</label>

<input
    type="text"
    name="class"
    placeholder="Example: 6"
    required
>

<br><br>


<label>Mobile</label>

<input
    type="text"
    name="mobile"
>

<br><br>


<label>Address</label>

<input
    type="text"
    name="address"
>

<br><br>


<label>Date of Birth</label>

<input
    type="date"
    name="dob"
>

<br><br>


<label>Username</label>

<input
    type="text"
    name="username"
    required
>

<br><br>


<label>Password</label>

<input
    type="password"
    name="password"
    required
>

<br><br>


<button
    type="submit"
    name="save"
>
➕ Add Student
</button>


</form>


<br>


<a
    class="back"
    href="principal-dashboard.php"
>
⬅ Back to Dashboard
</a>


</div>


</body>

</html>