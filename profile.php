<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if(isset($_POST['upload']))
{
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0)
    {
        $allowed = ['jpg', 'jpeg', 'png'];

        $file_name = $_FILES['profile_pic']['name'];
        $file_size = $_FILES['profile_pic']['size'];
        $tmp_name = $_FILES['profile_pic']['tmp_name'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if(!in_array($ext, $allowed))
        {
            $message = "Only JPG, JPEG and PNG files are allowed!";
        }
        elseif($file_size > 2 * 1024 * 1024)
        {
            $message = "File size must be under 2MB!";
        }
        else
        {
            $new_name = time() . "_" . $user_id . "_" . $file_name;

            if(move_uploaded_file($tmp_name, "uploads/" . $new_name))
            {
                $stmt = mysqli_prepare(
                    $conn,
                    "UPDATE users SET profile_pic = ? WHERE id = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "si",
                    $new_name,
                    $user_id
                );

                mysqli_stmt_execute($stmt);

                $message = "Profile Picture Uploaded Successfully!";
            }
            else
            {
                $message = "Upload Failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">

    <h2>🖼️ Upload Profile Picture</h2>

    <form method="POST" enctype="multipart/form-data">

        <input
            type="file"
            name="profile_pic"
            required
        >

        <button
            type="submit"
            name="upload">
            Upload
        </button>

    </form>

    <?php
    if($message != "")
    {
        if(strpos($message, "Successfully") !== false)
        {
            echo "<p class='message-success'>$message</p>";
        }
        else
        {
            echo "<p class='message-error'>$message</p>";
        }
    }
    ?>

    <br>

    <div class="center">

        <a href="dashboard.php" class="btn">
            ← Back to Dashboard
        </a>

    </div>

</div>

</body>
</html>