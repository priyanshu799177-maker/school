<?php

session_start();
include "connection.php";


/* PRINCIPAL LOGIN CHECK */

if(!isset($_SESSION['principal']))
{
    header("Location: principal-login.php");
    exit();
}


if(isset($_POST['upload']))
{
    $title = mysqli_real_escape_string(
        $conn,
        $_POST['title']
    );

    $upload_date = $_POST['upload_date'];


    /* IMAGE CHECK */

    if(isset($_FILES['image']) &&
       $_FILES['image']['error'] == 0)
    {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];

        $file_ext = strtolower(
            pathinfo(
                $file_name,
                PATHINFO_EXTENSION
            )
        );


        /* ALLOWED IMAGE TYPES */

        $allowed = array(
            "jpg",
            "jpeg",
            "png",
            "gif"
        );


        if(!in_array($file_ext, $allowed))
        {
            echo "<script>
            alert('Sirf JPG, JPEG, PNG ya GIF image upload karein');
            </script>";
        }
        else
        {
            /* UNIQUE FILE NAME */

            $new_name =
                time() . "_" .
                rand(1000,9999) . "." .
                $file_ext;


            $target =
                "uploads/gallery/" .
                $new_name;


            if(move_uploaded_file(
                $file_tmp,
                $target
            ))
            {

                $sql = "INSERT INTO gallery
                (
                    title,
                    image,
                    upload_date
                )

                VALUES
                (
                    '$title',
                    '$new_name',
                    '$upload_date'
                )";


                if(mysqli_query($conn,$sql))
                {
                    echo "<script>

                    alert('Photo Uploaded Successfully');

                    window.location.href='add-gallery.php';

                    </script>";

                    exit();
                }
                else
                {
                    echo "<script>

                    alert('Database Error: " .
                    mysqli_error($conn) .
                    "');

                    </script>";
                }

            }
            else
            {
                echo "<script>

                alert('Image Upload Failed');

                </script>";
            }
        }
    }
    else
    {
        echo "<script>

        alert('Please select an image');

        </script>";
    }
}

?>


<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Add Gallery Photo</title>


<style>

body
{
    margin:0;
    font-family:Arial;
    background:#f2f2f2;
}


.header
{
    background:#004aad;
    color:white;
    padding:25px;
    text-align:center;
}


.box
{
    width:500px;
    max-width:90%;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px #ccc;
}


label
{
    display:block;
    margin-top:15px;
    font-weight:bold;
}


input
{
    width:100%;
    box-sizing:border-box;
    padding:10px;
    margin-top:7px;
    border:1px solid #aaa;
    border-radius:5px;
}


button
{
    width:100%;
    margin-top:20px;
    padding:12px;
    background:#004aad;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:16px;
}


button:hover
{
    background:#003580;
}


.back
{
    display:block;
    text-align:center;
    margin-top:20px;
    color:#004aad;
    text-decoration:none;
    font-weight:bold;
}

</style>

</head>


<body>


<div class="header">

<h1>📸 School Gallery</h1>

<p>Principal Panel</p>

</div>


<div class="box">

<h2>📤 Upload Photo</h2>


<form
method="POST"
enctype="multipart/form-data"
>


<label>
Photo Title
</label>

<input
type="text"
name="title"
placeholder="Example: Annual Function"
required
>


<label>
Select Photo
</label>

<input
type="file"
name="image"
accept=".jpg,.jpeg,.png,.gif"
required
>


<label>
Upload Date
</label>

<input
type="date"
name="upload_date"
value="<?php echo date('Y-m-d'); ?>"
required
>


<button
type="submit"
name="upload"
>

📤 Upload Photo

</button>


</form>


<a
class="back"
href="principal-dashboard.php"
>

⬅ Back to Principal Dashboard

</a>


</div>


</body>

</html>