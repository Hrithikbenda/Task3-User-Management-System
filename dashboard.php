<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT profile_pic FROM users WHERE id=?"
);

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>
    Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?> 👋
</h1>

<p>Login Successful</p>

<?php
if(!empty($user['profile_pic']))
{
?>
    <img
        src="uploads/<?php echo $user['profile_pic']; ?>"
        class="profile-img"
        alt="Profile Picture">
<?php
}
?>

<div class="center">

<a href="profile.php" class="btn">
    Upload Profile Picture
</a>

<a href="users.php" class="btn">
    Manage Users
</a>

<a href="logout.php" class="btn">
    Logout
</a>

</div>

</div>

</body>
</html>