
<?php
include("db.php");

$message = "";

if(isset($_POST['register']))
{
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0)
    {
        $message = "Email already exists!";
    }
    else
    {
        $sql = "INSERT INTO users(fullname,email,password)
                VALUES('$fullname','$email','$password')";

        if(mysqli_query($conn, $sql))
        {
            $message = "Registration Successful!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-box">

    <h2>User Registration</h2>

    <form method="POST">

        <input
            type="text"
            name="fullname"
            placeholder="Full Name"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <button type="submit" name="register">
            Register
        </button>

    </form>

    <p><?php echo $message; ?></p>

    <div class="center">

        <a href="login.php" class="btn">
            Back to Login
        </a>

    </div>

</div>

</body>
</html>

