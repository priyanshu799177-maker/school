<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>S.K.L Public School</title>

<style>

*{
    box-sizing:border-box;
    margin:0;
    padding:0;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f5f7fb;
    color:#222;
}


/* ================= HEADER ================= */

header{
    background:#004aad;
    color:white;
    padding:18px 6%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

.logo{
    font-size:26px;
    font-weight:bold;
}

nav{
    display:flex;
    gap:25px;
}

nav a{
    color:white;
    text-decoration:none;
    font-weight:bold;
}

nav a:hover{
    text-decoration:underline;
}


/* ================= HERO ================= */

.hero{
    min-height:500px;

    background:
    linear-gradient(
        rgba(0,74,173,0.88),
        rgba(0,74,173,0.88)
    );

    display:flex;
    justify-content:center;
    align-items:center;

    text-align:center;
    color:white;

    padding:50px 20px;
}

.hero-content{
    max-width:850px;
}

.hero h1{
    font-size:52px;
    margin-bottom:15px;
}

.hero h2{
    font-size:30px;
    margin-bottom:20px;
}

.hero p{
    font-size:19px;
    line-height:1.7;
    margin-bottom:10px;
}

.hero-button{
    display:inline-block;
    margin-top:25px;
    padding:14px 28px;
    background:white;
    color:#004aad;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
}

.hero-button:hover{
    background:#e5e7eb;
}


/* ================= LOGIN ================= */

.login-section{
    padding:60px 6%;
    text-align:center;
}

.section-title{
    color:#004aad;
    font-size:34px;
    margin-bottom:10px;
}

.section-subtitle{
    color:#666;
    margin-bottom:35px;
}

.login-grid{
    max-width:1100px;
    margin:auto;

    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:22px;
}

.login-card{
    background:white;
    padding:30px 20px;
    border-radius:12px;
    box-shadow:0 3px 12px #d5d5d5;
    transition:0.3s;
}

.login-card:hover{
    transform:translateY(-6px);
    box-shadow:0 6px 18px #bbb;
}

.login-icon{
    font-size:48px;
    margin-bottom:15px;
}

.login-card h3{
    color:#004aad;
    font-size:22px;
    margin-bottom:12px;
}

.login-card p{
    color:#666;
    line-height:1.6;
    min-height:55px;
}

.login-button{
    display:block;
    background:#004aad;
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:6px;
    margin-top:20px;
    font-weight:bold;
}

.login-button:hover{
    background:#003580;
}


/* ================= ABOUT ================= */

.about{
    background:white;
    padding:60px 10%;
    text-align:center;
}

.about h2{
    color:#004aad;
    font-size:34px;
    margin-bottom:20px;
}

.about p{
    max-width:900px;
    margin:auto;
    color:#555;
    font-size:17px;
    line-height:1.9;
}


/* ================= FEATURES ================= */

.features{
    padding:60px 6%;
    text-align:center;
}

.feature-grid{
    max-width:1000px;
    margin:35px auto 0;

    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:22px;
}

.feature-card{
    background:white;
    padding:30px 20px;
    border-radius:12px;
    box-shadow:0 3px 10px #ddd;
}

.feature-icon{
    font-size:42px;
    margin-bottom:15px;
}

.feature-card h3{
    color:#004aad;
    margin-bottom:12px;
}

.feature-card p{
    color:#666;
    line-height:1.6;
}


/* ================= CONTACT ================= */

.contact{
    background:#eef4ff;
    padding:60px 6%;
    text-align:center;
}

.contact-grid{
    max-width:1100px;
    margin:35px auto 0;

    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

.contact-card{
    background:white;
    padding:28px 15px;
    border-radius:12px;
    box-shadow:0 3px 10px #ddd;
}

.contact-icon{
    font-size:40px;
    margin-bottom:12px;
}

.contact-card h3{
    color:#004aad;
    margin-bottom:12px;
}

.contact-card p{
    color:#555;
    line-height:1.7;
}

.location-button{
    display:inline-block;
    margin-top:15px;
    padding:10px 16px;
    background:#004aad;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
}

.location-button:hover{
    background:#003580;
}


/* ================= FOOTER ================= */

footer{
    background:#202020;
    color:white;
    text-align:center;
    padding:30px 20px;
}

footer h3{
    font-size:24px;
    margin-bottom:15px;
}

footer p{
    margin:8px;
    color:#ddd;
}


/* ================= MOBILE ================= */

@media(max-width:1000px){

    .login-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .contact-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:700px){

    header{
        justify-content:center;
        text-align:center;
    }

    nav{
        margin-top:15px;
        gap:15px;
    }

    .hero h1{
        font-size:38px;
    }

    .hero h2{
        font-size:24px;
    }

    .login-grid,
    .feature-grid,
    .contact-grid{
        grid-template-columns:1fr;
    }

}

</style>

</head>


<body>


<!-- ================= HEADER ================= -->

<header>

<div class="logo">
🏫 S.K.L Public School
</div>

<nav>

<a href="#home">Home</a>

<a href="#login">Login</a>

<a href="#about">About</a>

<a href="#features">Features</a>

<a href="#contact">Contact</a>

</nav>

</header>



<!-- ================= HERO ================= -->

<section class="hero" id="home">

<div class="hero-content">

<h1>
S.K.L Public School
</h1>

<h2>
Welcome to Our School
</h2>

<p>
Education • Discipline • Knowledge • Success
</p>

<p>
We are committed to providing quality education,
building strong character, and preparing students
for a successful future.
</p>

<a
href="#login"
class="hero-button"
>
Access School Portal
</a>

</div>

</section>



<!-- ================= LOGIN ================= -->

<section class="login-section" id="login">

<h2 class="section-title">
School Portal
</h2>

<p class="section-subtitle">
Please select your login portal
</p>


<div class="login-grid">


<!-- STUDENT -->

<div class="login-card">

<div class="login-icon">
👨‍🎓
</div>

<h3>
Student
</h3>

<p>
Access your dashboard, homework,
attendance and examination results.
</p>

<a
href="student-login.php"
class="login-button"
>
Student Login
</a>

</div>



<!-- TEACHER -->

<div class="login-card">

<div class="login-icon">
👨‍🏫
</div>

<h3>
Teacher
</h3>

<p>
Manage attendance, homework, subjects,
results and assigned classes.
</p>

<a
href="teacher-login.php"
class="login-button"
>
Teacher Login
</a>

</div>



<!-- PRINCIPAL -->

<div class="login-card">

<div class="login-icon">
👨‍💼
</div>

<h3>
Principal
</h3>

<p>
Manage school activities, teachers,
students and result approvals.
</p>

<a
href="principal-login.php"
class="login-button"
>
Principal Login
</a>

</div>



<!-- ADMIN -->

<div class="login-card">

<div class="login-icon">
🔐
</div>

<h3>
Administrator
</h3>

<p>
Manage the school management system
and administrative activities.
</p>

<a
href="admin-login.php"
class="login-button"
>
Admin Login
</a>

</div>


</div>

</section>



<!-- ================= ABOUT ================= -->

<section class="about" id="about">

<h2>
About S.K.L Public School
</h2>

<p>

S.K.L Public School is committed to providing
quality education in a safe, disciplined and
supportive environment.

Our goal is to develop students academically,
socially and personally while encouraging
discipline, confidence, creativity and responsibility.

We believe that education is the foundation
of a successful and meaningful future.

</p>

</section>



<!-- ================= FEATURES ================= -->

<section class="features" id="features">

<h2 class="section-title">
School Management System
</h2>

<p class="section-subtitle">
A digital platform for students, teachers and school administration
</p>


<div class="feature-grid">


<div class="feature-card">

<div class="feature-icon">
📅
</div>

<h3>
Attendance Management
</h3>

<p>
Teachers can manage student attendance
and monitor attendance records.
</p>

</div>



<div class="feature-card">

<div class="feature-icon">
📚
</div>

<h3>
Homework Management
</h3>

<p>
Teachers can upload homework and students
can easily access their assignments.
</p>

</div>



<div class="feature-card">

<div class="feature-icon">
📊
</div>

<h3>
Result Management
</h3>

<p>
Students can view their examination results
and report cards through the portal.
</p>

</div>


</div>

</section>



<!-- ================= CONTACT ================= -->

<section class="contact" id="contact">

<h2 class="section-title">
Contact Us
</h2>

<p class="section-subtitle">
Get in touch with S.K.L Public School
</p>


<div class="contact-grid">


<!-- PHONE -->

<div class="contact-card">

<div class="contact-icon">
📱
</div>

<h3>
Phone
</h3>

<p>
9005495660
</p>

<p>
7355205844
</p>

</div>



<!-- EMAIL -->

<div class="contact-card">

<div class="contact-icon">
✉️
</div>

<h3>
Email
</h3>

<p>
sklpublicschool1@gmail.com
</p>

</div>



<!-- ADDRESS -->

<div class="contact-card">

<div class="contact-icon">
🏫
</div>

<h3>
School Address
</h3>

<p>
Udvat Khera,<br>
Mohanlal Ganj,<br>
Lucknow,<br>
Uttar Pradesh
</p>

</div>



<!-- LOCATION -->

<div class="contact-card">

<div class="contact-icon">
📍
</div>

<h3>
School Location
</h3>

<p>
Udvat Khera,<br>
Mohanlal Ganj,<br>
Lucknow
</p>

<a
href="https://maps.app.goo.gl/HYriDhSrCq9YqYgM9"
target="_blank"
class="location-button"
>
View School Location
</a>

</div>


</div>

</section>



<!-- ================= FOOTER ================= -->

<footer>

<h3>
S.K.L Public School
</h3>

<p>
📱 9005495660 &nbsp; | &nbsp; 7355205844
</p>

<p>
✉️ sklpublicschool1@gmail.com
</p>

<p>
📍 Udvat Khera, Mohanlal Ganj, Lucknow, Uttar Pradesh
</p>

<p>
© 2026 S.K.L Public School. All Rights Reserved.
</p>

</footer>


</body>

</html>