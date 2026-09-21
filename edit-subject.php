<?php
include "connection.php";

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM subjects WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $name = $_POST['subject_name'];
    $code = $_POST['subject_code'];

    mysqli_query($conn,"UPDATE subjects
    SET subject_name='$name',
    subject_code='$code'
    WHERE id='$id'");

    header("Location:view-subject.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Subject</title>
</head>
<body>

<h2>Edit Subject</h2>

<form method="POST">

Subject Name<br>
<input type="text" name="subject_name"
value="<?php echo $row['subject_name']; ?>" required>

<br><br>

Subject Code<br>
<input type="text" name="subject_code"
value="<?php echo $row['subject_code']; ?>" required>

<br><br>

<button name="update">Update Subject</button>

</form>

</body>
</html>