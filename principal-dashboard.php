<?php

session_start();

if(!isset($_SESSION['principal']))
{
    header("Location: principal-login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Principal Dashboard | S.K.L Public School</title>

<style>

*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f7fb;
}


/* ================= HEADER ================= */

.header{
    height:70px;
    background:#004aad;
    color:white;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:0 25px;

    position:fixed;
    top:0;
    left:0;
    right:0;

    z-index:1000;
}

.logo{
    font-size:22px;
    font-weight:bold;
}

.header-right{
    display:flex;
    align-items:center;
    gap:20px;
}

.principal-name{
    font-size:14px;
}

.logout{
    background:#dc2626;
    color:white;
    padding:9px 15px;
    border-radius:6px;
    text-decoration:none;
    font-weight:bold;
}

.logout:hover{
    background:#b91c1c;
}


/* ================= SIDEBAR ================= */

.sidebar{
    position:fixed;

    top:70px;
    left:0;

    width:250px;
    height:calc(100vh - 70px);

    background:#172033;

    overflow-y:auto;
}

.sidebar-title{
    color:#aaa;
    padding:20px 18px 10px;
    font-size:12px;
    text-transform:uppercase;
}

.sidebar a{
    display:block;

    color:white;

    text-decoration:none;

    padding:14px 20px;

    border-bottom:1px solid #263147;

    font-size:15px;
}

.sidebar a:hover{
    background:#004aad;
}

.sidebar a.active{
    background:#004aad;
}


/* ================= MAIN ================= */

.main{
    margin-left:250px;

    padding:95px 30px 40px;
}


/* ================= WELCOME ================= */

.welcome{
    background:white;

    padding:25px;

    border-radius:12px;

    box-shadow:0 2px 10px #ddd;

    margin-bottom:25px;
}

.welcome h1{
    color:#004aad;

    font-size:28px;

    margin-bottom:8px;
}

.welcome p{
    color:#666;
}


/* ================= CARDS ================= */

.cards{
    display:grid;

    grid-template-columns:
    repeat(4,1fr);

    gap:20px;

    margin-bottom:30px;
}


.card{
    background:white;

    border-radius:12px;

    padding:22px;

    box-shadow:0 2px 10px #ddd;

    display:flex;

    align-items:center;

    gap:15px;
}

.card-icon{
    width:55px;
    height:55px;

    border-radius:10px;

    background:#e8f1ff;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:28px;
}

.card h3{
    color:#004aad;

    font-size:24px;

    margin-bottom:4px;
}

.card p{
    color:#777;

    font-size:13px;
}


/* ================= QUICK ACTIONS ================= */

.section-title{
    color:#222;

    font-size:22px;

    margin-bottom:18px;
}


.actions{
    display:grid;

    grid-template-columns:
    repeat(4,1fr);

    gap:18px;

    margin-bottom:30px;
}


.action{
    background:white;

    padding:22px;

    border-radius:10px;

    text-decoration:none;

    color:#222;

    box-shadow:0 2px 8px #ddd;

    transition:.2s;
}

.action:hover{
    transform:translateY(-4px);

    box-shadow:0 5px 15px #ccc;
}

.action-icon{
    font-size:35px;

    margin-bottom:12px;
}

.action h3{
    color:#004aad;

    margin-bottom:6px;

    font-size:17px;
}

.action p{
    color:#777;

    font-size:13px;

    line-height:1.5;
}


/* ================= INFORMATION ================= */

.info-grid{
    display:grid;

    grid-template-columns:
    2fr 1fr;

    gap:20px;
}


.info-box{
    background:white;

    padding:25px;

    border-radius:12px;

    box-shadow:0 2px 10px #ddd;
}

.info-box h2{
    color:#004aad;

    margin-bottom:18px;

    font-size:21px;
}

.info-box p{
    color:#666;

    line-height:1.7;
}


/* ================= RESPONSIVE ================= */

@media(max-width:1100px){

    .cards{
        grid-template-columns:
        repeat(2,1fr);
    }

    .actions{
        grid-template-columns:
        repeat(2,1fr);
    }

}


@media(max-width:800px){

    .sidebar{
        width:210px;
    }

    .main{
        margin-left:210px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

}


@media(max-width:600px){

    .header{
        padding:0 12px;
    }

    .logo{
        font-size:16px;
    }

    .principal-name{
        display:none;
    }

    .sidebar{
        position:relative;

        top:70px;

        width:100%;

        height:auto;
    }

    .main{
        margin-left:0;

        padding:90px 15px 30px;
    }

    .cards{
        grid-template-columns:1fr;
    }

    .actions{
        grid-template-columns:1fr;
    }

}

</style>

</head>


<body>


<!-- ================= HEADER ================= -->

<div class="header">

<div class="logo">
🏫 S.K.L Public School
</div>


<div class="header-right">

<div class="principal-name">
👨‍💼 Principal Panel
</div>

<a
href="logout.php"
class="logout"
>
Logout
</a>

</div>

</div>



<!-- ================= SIDEBAR ================= -->

<div class="sidebar">


<div class="sidebar-title">
Main Menu
</div>


<a
href="principal-dashboard.php"
class="active"
>
🏠 Dashboard
</a>


<a href="manage-teachers.php">
👨‍🏫 Manage Teachers
</a>


<a href="add-student.php">
👨‍🎓 Add Student
</a>


<a href="add-notice.php">
📢 Notice Board
</a>


<a href="view-notice.php">
📋 View Notices
</a>


<a href="add-fee.php">
💰 Fees
</a>


<a href="add-gallery.php">
📸 Gallery
</a>


<a href="principal-result-approval.php">
📊 Result Approval
</a>


<a href="#">
📅 Attendance Report
</a>


<div class="sidebar-title">
School
</div>


<a href="#about">
🏫 School Information
</a>


<a href="#contact">
📞 Contact
</a>


<a
href="logout.php"
>
🚪 Logout
</a>


</div>



<!-- ================= MAIN ================= -->

<div class="main">


<!-- WELCOME -->

<div class="welcome">

<h1>
Welcome, Principal 👋
</h1>

<p>
Manage and monitor your school from the Principal Dashboard.
</p>

</div>



<!-- ================= STATISTICS ================= -->

<div class="cards">


<div class="card">

<div class="card-icon">
👨‍🎓
</div>

<div>

<h3>
Students
</h3>

<p>
Student Management
</p>

</div>

</div>



<div class="card">

<div class="card-icon">
👨‍🏫
</div>

<div>

<h3>
Teachers
</h3>

<p>
Teacher Management
</p>

</div>

</div>



<div class="card">

<div class="card-icon">
📊
</div>

<div>

<h3>
Results
</h3>

<p>
Result Approval
</p>

</div>

</div>



<div class="card">

<div class="card-icon">
📢
</div>

<div>

<h3>
Notices
</h3>

<p>
School Notices
</p>

</div>

</div>


</div>



<!-- ================= QUICK ACTIONS ================= -->

<h2 class="section-title">
Quick Actions
</h2>


<div class="actions">


<a
href="manage-teachers.php"
class="action"
>

<div class="action-icon">
👨‍🏫
</div>

<h3>
Manage Teachers
</h3>

<p>
Add, edit and manage school teachers.
</p>

</a>



<a
href="add-student.php"
class="action"
>

<div class="action-icon">
👨‍🎓
</div>

<h3>
Add Student
</h3>

<p>
Add new students to the school system.
</p>

</a>



<a
href="principal-result-approval.php"
class="action"
>

<div class="action-icon">
📊
</div>

<h3>
Result Approval
</h3>

<p>
Review and approve student results.
</p>

</a>



<a
href="add-notice.php"
class="action"
>

<div class="action-icon">
📢
</div>

<h3>
Create Notice
</h3>

<p>
Publish important school announcements.
</p>

</a>


</div>



<!-- ================= INFORMATION ================= -->

<div class="info-grid">


<div class="info-box">

<h2>
🏫 Principal Responsibilities
</h2>

<p>
The Principal Dashboard provides access to
important school management activities including
teacher management, student management,
attendance reports, notices, fees, gallery and
result approval.
</p>

<br>

<p>
Use the menu on the left to access the required
school management section.
</p>

</div>



<div class="info-box">

<h2>
📞 School Contact
</h2>

<p>
<strong>Phone:</strong><br>
9005495660<br>
7355205844
</p>

<br>

<p>
<strong>Email:</strong><br>
sklpublicschool1@gmail.com
</p>

<br>

<p>
<strong>Address:</strong><br>
Udvat Khera,<br>
Mohanlal Ganj,<br>
Lucknow, Uttar Pradesh
</p>

</div>


</div>


</div>


</body>

</html>