<?php
include("db.php");

$id = $_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users SET fullname = ?, email = ? WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $fullname,
        $email,
        $id
    );

    mysqli_stmt_execute($stmt);

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">

<h2>Edit User</h2>
<br><br>



<form method="POST">

    <input
        type="text"
        name="fullname"
        value="<?php echo $user['fullname']; ?>"
        required
    >

    <input
        type="email"
        name="email"
        value="<?php echo $user['email']; ?>"
        required
    >

    <button type="submit" name="update">
        Update User
    </button>

</form>

<br>

<div class="center">
    <a href="users.php" class="btn">
        Back to Users
    </a>
</div>

</div>

</body>
</html>