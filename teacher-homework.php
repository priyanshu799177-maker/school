<?php
session_start();
include("connection.php");

/* Teacher Login Check */
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher-login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

/* Assignment ID */
$assignment_id = isset($_GET['assignment_id'])
    ? intval($_GET['assignment_id'])
    : (isset($_SESSION['selected_assignment_id'])
        ? intval($_SESSION['selected_assignment_id'])
        : 0);

if ($assignment_id <= 0) {
    header("Location: teacher-dashboard.php");
    exit();
}

/* Selected Assignment Verify */
$sql = "SELECT 
            ta.id,
            ta.class,
            ta.subject_id,
            ta.is_class_teacher,
            s.subject_name
        FROM teacher_assignments ta
        LEFT JOIN subjects s ON ta.subject_id = s.id
        WHERE ta.id = '$assignment_id'
        AND ta.teacher_id = '$teacher_id'
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Invalid class assignment.");
}

$assignment = mysqli_fetch_assoc($result);

$class = $assignment['class'];
$subject_id = $assignment['subject_id'];
$subject = $assignment['subject_name'];
$is_class_teacher = $assignment['is_class_teacher'];

/* Teacher Name */
$teacher_query = mysqli_query(
    $conn,
    "SELECT name FROM teachers WHERE id='$teacher_id' LIMIT 1"
);

$teacher = mysqli_fetch_assoc($teacher_query);
$teacher_name = $teacher['name'] ?? '';

$message = "";
$error = "";

/* Homework Save */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $last_date = $_POST['last_date'] ?? '';

    if ($title == "" || $description == "" || $last_date == "") {
        $error = "Please fill all required fields.";
    } else {

        $pdf_file = "";

        /* PDF Upload */
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {

            $file_name = $_FILES['pdf_file']['name'];
            $file_tmp = $_FILES['pdf_file']['tmp_name'];
            $file_size = $_FILES['pdf_file']['size'];

            $extension = strtolower(
                pathinfo($file_name, PATHINFO_EXTENSION)
            );

            if ($extension != "pdf") {
                $error = "Only PDF files are allowed.";
            } elseif ($file_size > 5 * 1024 * 1024) {
                $error = "PDF size should be less than 5 MB.";
            } else {

                $upload_dir = "uploads/homework/";

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $new_file_name =
                    time() . "_" . rand(1000, 9999) . ".pdf";

                $pdf_file = $upload_dir . $new_file_name;

                if (!move_uploaded_file($file_tmp, $pdf_file)) {
                    $error = "PDF upload failed.";
                    $pdf_file = "";
                }
            }
        }

        if ($error == "") {

            $title = mysqli_real_escape_string($conn, $title);
            $description = mysqli_real_escape_string($conn, $description);
            $class_db = mysqli_real_escape_string($conn, $class);
            $subject_db = mysqli_real_escape_string($conn, $subject);
            $teacher_db = mysqli_real_escape_string($conn, $teacher_name);
            $pdf_db = mysqli_real_escape_string($conn, $pdf_file);

            $insert_sql = "INSERT INTO homework
                (class, subject, title, description, last_date, teacher_name, pdf_file)
                VALUES
                ('$class_db',
                 '$subject_db',
                 '$title',
                 '$description',
                 '$last_date',
                 '$teacher_db',
                 '$pdf_db')";

            if (mysqli_query($conn, $insert_sql)) {
                $message = "Homework added successfully.";

                /* Clear fields */
                $title = "";
                $description = "";
                $last_date = "";
            } else {
                $error = "Database Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Teacher Homework</title>

<style>

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f2f5f9;
}

.header {
    background: #1565c0;
    color: white;
    padding: 18px;
    text-align: center;
}

.container {
    width: 90%;
    max-width: 700px;
    margin: 30px auto;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.15);
}

.info {
    background: #e3f2fd;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-top: 15px;
    margin-bottom: 6px;
    font-weight: bold;
}

input,
textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 11px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
}

textarea {
    height: 130px;
    resize: vertical;
}

button {
    margin-top: 20px;
    padding: 12px 25px;
    border: none;
    border-radius: 6px;
    background: #1565c0;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #0d47a1;
}

.back {
    display: inline-block;
    margin-top: 15px;
    text-decoration: none;
    color: #1565c0;
    font-weight: bold;
}

.success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.error {
    background: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 15px;
}

</style>

</head>

<body>

<div class="header">
    <h1>Teacher Homework</h1>
</div>

<div class="container">

<div class="card">

<div class="info">

    <p><strong>Teacher:</strong>
        <?php echo htmlspecialchars($teacher_name); ?>
    </p>

    <p><strong>Class:</strong>
        <?php echo htmlspecialchars($class); ?>
    </p>

    <p><strong>Subject:</strong>
        <?php echo htmlspecialchars($subject); ?>
    </p>

    <p><strong>Class Teacher:</strong>
        <?php echo ($is_class_teacher == 1) ? "Yes" : "No"; ?>
    </p>

</div>

<?php if ($message != "") { ?>

<div class="success">
    <?php echo htmlspecialchars($message); ?>
</div>

<?php } ?>

<?php if ($error != "") { ?>

<div class="error">
    <?php echo htmlspecialchars($error); ?>
</div>

<?php } ?>

<form method="POST"
      action="teacher-homework.php?assignment_id=<?php echo $assignment_id; ?>"
      enctype="multipart/form-data">

    <label>Homework Title</label>

    <input type="text"
           name="title"
           placeholder="Enter homework title"
           value="<?php echo htmlspecialchars($title ?? ''); ?>"
           required>


    <label>Homework Description</label>

    <textarea name="description"
              placeholder="Enter homework details..."
              required><?php echo htmlspecialchars($description ?? ''); ?></textarea>


    <label>Last Date</label>

    <input type="date"
           name="last_date"
           value="<?php echo htmlspecialchars($last_date ?? ''); ?>"
           required>


    <label>Upload PDF (Optional)</label>

    <input type="file"
           name="pdf_file"
           accept=".pdf">


    <button type="submit">
        Add Homework
    </button>

</form>

<a class="back"
   href="teacher-dashboard.php?assignment_id=<?php echo $assignment_id; ?>">
    ← Back to Teacher Dashboard
</a>

</div>

</div>

</body>

</html>