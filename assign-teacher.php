<?php
include "connection.php";

if(isset($_POST['assign']))
{
    $teacher_id = $_POST['teacher_id'];
    $class = $_POST['class'];
    $subject_id = $_POST['subject_id'];

    $sql = "INSERT INTO teacher_assignments
            (teacher_id, class, subject_id)
            VALUES
            ('$teacher_id', '$class', '$subject_id')";

    if(mysqli_query($conn, $sql))
    {
        echo "<script>
        alert('Teacher Assigned Successfully');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Assign Teacher</title>

<style>

body{
    font-family:Arial;
    background:#f2f2f2;
}

.box{
    width:450px;
    margin:40px auto;
    background:white;
    padding:25px;
    box-shadow:0 0 10px gray;
    border-radius:10px;
}

select{
    width:100%;
    padding:10px;
    margin:8px 0 15px;
}

button{
    width:100%;
    padding:10px;
    background:#004aad;
    color:white;
    border:0;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="box">

<h2>👨‍🏫 Assign Teacher</h2>

<form method="POST">

<label>Teacher</label>

<select name="teacher_id" required>

<option value="">Select Teacher</option>

<?php

$teachers = mysqli_query($conn,"SELECT * FROM teachers");

while($teacher = mysqli_fetch_assoc($teachers))
{
?>

<option value="<?php echo $teacher['id']; ?>">

<?php echo $teacher['name']; ?>

</option>

<?php
}
?>

</select>


<label>Class</label>

<select name="class" required>

<option value="">Select Class</option>

<option>Nursery</option>
<option>KG</option>
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>

</select>


<label>Subject</label>

<select name="subject_id" required>

<option value="">Select Subject</option>

<?php

$subjects = mysqli_query($conn,"SELECT * FROM subjects");

while($subject = mysqli_fetch_assoc($subjects))
{
?>

<option value="<?php echo $subject['id']; ?>">

<?php echo $subject['subject_name']; ?>

</option>

<?php
}
?>

</select>


<button type="submit" name="assign">
Assign Teacher
</button>

</form>

</div>

</body>
</html>