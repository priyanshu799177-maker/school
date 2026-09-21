<?php
include "connection.php";

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM subjects WHERE id='$id'");

header("Location:view-subject.php");
?>