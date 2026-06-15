<?php

include("db.php");

$id = $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM users WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

header("Location: users.php");
exit();

?>