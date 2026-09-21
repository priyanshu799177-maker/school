<?php
include "connection.php";

if(isset($_POST['save']))
{
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];

    $sql = "INSERT INTO subjects
    (subject_name, subject_code)

    VALUES
    ('$subject_name','$subject_code')";

    if(mysqli_query($conn,$sql))
    {
        echo "<script>
        alert('Subject Added Successfully');
        </script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Add Subject</title>
</head>

<body>

<h2>Add Subject</h2>

<form method="POST">

Subject Name:
<br>
<input type="text" name="subject_name" required>

<br><br>

Subject Code:
<br>
<input type="text" name="subject_code" required>

<br><br>

<button name="save">
Add Subject
</button>

</form>

</body>
</html>