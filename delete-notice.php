<?php
include "connection.php";

$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM notices WHERE id='$id'");

header("Location:view-notice.php");
?>