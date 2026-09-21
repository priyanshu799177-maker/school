<?php
include "connection.php";

$result = mysqli_query($conn, "SELECT * FROM subjects");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Subjects</title>
</head>
<body>

<h2>Manage Subjects</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Class</th>
        <th>Subject Name</th>
        <th>Action</th>
    </tr>

<?php
while($row = mysqli_fetch_assoc($result)){
?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['class']; ?></td>
        <td><?php echo $row['subject_name']; ?></td>
        <td>
            <a href="delete-subject.php?id=<?php echo $row['id']; ?>">
                Delete
            </a>
        </td>
    </tr>

<?php
}
?>

</table>

<br>

<a href="add_subject.php">Add New Subject</a>

</body>
</html>