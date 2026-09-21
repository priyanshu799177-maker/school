<?php

include "connection.php";


$id=$_GET['id'];


mysqli_query($conn,"DELETE FROM teachers WHERE id=$id");


header("Location: teacher-list.php");


?>