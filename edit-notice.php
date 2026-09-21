<?php
include "connection.php";

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM notices WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $title = $_POST['title'];
    $notice = $_POST['notice'];

    mysqli_query($conn,"UPDATE notices
    SET title='$title', notice='$notice'
    WHERE id='$id'");

    echo "<script>
    alert('Notice Updated Successfully');
    window.location='view-notice.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Notice</title>
</head>
<body>

<h2>Edit Notice</h2>

<form method="POST">

Title<br>
<input type="text" name="title"
value="<?php echo $row['title']; ?>" required>

<br><br>

Notice<br>

<textarea name="notice" rows="6" cols="50" required><?php echo $row['notice']; ?></textarea>

<br><br>

<button name="update">Update Notice</button>

</form>

</body>
</html>