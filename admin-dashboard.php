<!DOCTYPE html>
<html lang="en">

<head>

<title>Admin Dashboard</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f2f5f9;
}

.header{
    background:#004aad;
    color:white;
    padding:20px;
    text-align:center;
}

.sidebar{
    width:220px;
    height:100vh;
    background:#222;
    color:white;
    position:fixed;
    padding-top:20px;
}

.sidebar a{
    display:block;
    color:white;
    padding:15px;
    text-decoration:none;
}

.sidebar a:hover{
    background:#004aad;
}


.main{
    margin-left:240px;
    padding:20px;
}


.card{

    display:inline-block;
    width:200px;
    background:white;
    padding:20px;
    margin:15px;
    text-align:center;
    border-radius:10px;
    box-shadow:0 0 10px gray;

}


.logout{

background:red;
color:white;
padding:10px;
text-decoration:none;

}

</style>

</head>


<body>


<div class="header">

<h1>S.K.L Public School</h1>

<h3>Admin Dashboard</h3>

</div>



<div class="sidebar">

<a href="#">?? Dashboard</a>

<a href="#">????? Students</a>

<a href="#">????? Teachers</a>

<a href="#">?? Admissions</a>

<a href="#">?? Notices</a>

<a href="#">?? Homework</a>

<a href="#">?? Results</a>

<a href="#">? Settings</a>


</div>



<div class="main">


<h2>Welcome Priyanshu ??</h2>


<div class="card">

<h2>500+</h2>

<p>Students</p>

</div>


<div class="card">

<h2>30+</h2>

<p>Teachers</p>

</div>


<div class="card">

<h2>100+</h2>

<p>Admissions</p>

</div>


<div class="card">

<h2>20+</h2>

<p>Notices</p>

</div>


<br><br>


<a class="logout" href="admin-login.php">
Logout
</a>


</div>


</body>

</html>