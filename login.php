
<?php
session_start();
include("db.php");

$message = "";

if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, fullname, password FROM users WHERE email = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1)
    {
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password']))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];

            header("Location: dashboard.php");
            exit();
        }
        else
        {
            $message = "Invalid Password!";
        }
    }
    else
    {
        $message = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-box">

    <div class="logo">🔐</div>

    <h2 class="form-title">
        User Login
    </h2>

    <form method="POST">

        <input
            type="email"
            name="email"
            placeholder="Enter Email"
            required
        >

        <div class="password-box">

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Enter Password"
                required
            >

            <span
                id="eye"
                class="toggle-eye"
                onclick="togglePassword()">
                👁
            </span>

        </div>

        <button
            type="submit"
            name="login"
            style="width:100%;">
            Login
        </button>

    </form>

    <?php if(!empty($message)) { ?>

        <p class="message-error">
            <?php echo $message; ?>
        </p>

    <?php } ?>

    <div class="center">

        <br>

        <a href="register.php" class="btn">
            Register New Account
        </a>

    </div>

</div>

<script>

function togglePassword()
{
    let password =
        document.getElementById("password");

    let eye =
        document.getElementById("eye");

    if(password.type === "password")
    {
        password.type = "text";
        eye.innerHTML = "🙈";
    }
    else
    {
        password.type = "password";
        eye.innerHTML = "👁";
    }
}

</script>

</body>
</html>
