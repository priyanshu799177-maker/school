<?php

session_start();
include "connection.php";

$error = "";

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM students
            WHERE username='$username'
            AND password='$password'
            LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) > 0)
    {
        $student = mysqli_fetch_assoc($result);

        session_regenerate_id(true);

        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student'] = $username;

        header("Location: student-dashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid username or password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Student Login | S.K.L Public School</title>

<style>

*{
    box-sizing:border-box;
}

body{
    margin:0;

    font-family:Arial, Helvetica, sans-serif;

    min-height:100vh;

    background:
    linear-gradient(
        135deg,
        #004aad,
        #2563eb,
        #60a5fa
    );

    display:flex;

    justify-content:center;

    align-items:center;

    padding:20px;
}


/* MAIN CONTAINER */

.login-container{
    width:100%;

    max-width:950px;

    min-height:550px;

    background:white;

    border-radius:20px;

    overflow:hidden;

    box-shadow:
    0 15px 40px rgba(0,0,0,.25);

    display:grid;

    grid-template-columns:1fr 1fr;
}


/* LEFT SIDE */

.left{
    background:
    linear-gradient(
        135deg,
        #003b8f,
        #0066cc
    );

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    text-align:center;

    padding:40px;
}

.left-content{
    max-width:350px;
}

.school-icon{
    font-size:75px;

    margin-bottom:15px;
}

.left h1{
    font-size:32px;

    margin:10px 0;
}

.left h2{
    font-size:22px;

    font-weight:normal;

    margin:10px 0 20px;
}

.left p{
    line-height:1.7;

    opacity:.9;
}


/* RIGHT SIDE */

.right{
    padding:50px 45px;

    display:flex;

    justify-content:center;

    flex-direction:column;
}

.right h2{
    color:#004aad;

    font-size:30px;

    margin:0 0 8px;
}

.subtitle{
    color:#777;

    margin-bottom:30px;
}


/* ERROR */

.error{
    background:#fee2e2;

    color:#b91c1c;

    padding:12px;

    border-radius:7px;

    margin-bottom:20px;

    text-align:center;

    font-size:14px;
}


/* INPUT */

.input-group{
    margin-bottom:20px;
}

.input-group label{
    display:block;

    font-weight:bold;

    margin-bottom:7px;

    color:#333;
}

.input-box{
    position:relative;
}

.input-box span{
    position:absolute;

    left:13px;

    top:50%;

    transform:translateY(-50%);

    font-size:18px;
}

.input-box input{
    width:100%;

    padding:14px 14px 14px 45px;

    border:1px solid #ccc;

    border-radius:8px;

    outline:none;

    font-size:15px;
}

.input-box input:focus{
    border-color:#004aad;

    box-shadow:
    0 0 0 3px rgba(0,74,173,.12);
}


/* LOGIN BUTTON */

.login-button{
    width:100%;

    padding:14px;

    border:none;

    border-radius:8px;

    background:#004aad;

    color:white;

    font-size:16px;

    font-weight:bold;

    cursor:pointer;

    margin-top:5px;
}

.login-button:hover{
    background:#003580;
}


/* BACK */

.back{
    text-align:center;

    margin-top:25px;
}

.back a{
    color:#004aad;

    text-decoration:none;

    font-weight:bold;
}

.back a:hover{
    text-decoration:underline;
}


/* FOOTER */

.footer{
    text-align:center;

    color:#999;

    font-size:13px;

    margin-top:25px;
}


/* MOBILE */

@media(max-width:700px){

    .login-container{
        grid-template-columns:1fr;
    }

    .left{
        padding:30px 20px;
    }

    .school-icon{
        font-size:55px;
    }

    .left h1{
        font-size:25px;
    }

    .left h2{
        font-size:18px;
    }

    .right{
        padding:35px 25px;
    }

}

</style>

</head>


<body>


<div class="login-container">


<!-- LEFT SIDE -->

<div class="left">

<div class="left-content">

<div class="school-icon">
👨‍🎓
</div>

<h1>
S.K.L Public School
</h1>

<h2>
Student Portal
</h2>

<p>
Welcome to the S.K.L Public School
Management System.
</p>

<p>
Login to view your attendance, homework,
results and other school information.
</p>

</div>

</div>



<!-- RIGHT SIDE -->

<div class="right">

<h2>
Student Login
</h2>

<p class="subtitle">
Sign in to continue to your student dashboard
</p>


<?php

if($error != "")
{
    echo "<div class='error'>⚠️ "
         . htmlspecialchars($error)
         . "</div>";
}

?>


<form method="POST">


<!-- USERNAME -->

<div class="input-group">

<label>
Username
</label>

<div class="input-box">

<span>
👤
</span>

<input
type="text"
name="username"
placeholder="Enter your username"
required
autocomplete="username"
>

</div>

</div>



<!-- PASSWORD -->

<div class="input-group">

<label>
Password
</label>

<div class="input-box">

<span>
🔒
</span>

<input
type="password"
name="password"
placeholder="Enter your password"
required
autocomplete="current-password"
>

</div>

</div>



<!-- LOGIN -->

<button
type="submit"
name="login"
class="login-button"
>

🔐 Login to Student Dashboard

</button>


</form>



<!-- BACK -->

<div class="back">

<a href="index.php">
← Back to Home
</a>

</div>


<div class="footer">

S.K.L Public School © 2026

</div>


</div>

</div>


</body>

</html>