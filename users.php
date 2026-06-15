<?php
session_start();
include("db.php");

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h2>Registered Users</h2>

<table>

<tr>
    <th>ID</th>
    <th>Profile</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>

<?php
if(!empty($row['profile_pic']))
{
?>
<img
src="uploads/<?php echo $row['profile_pic']; ?>"
width="60"
height="60"
style="border-radius:50%;">
<?php
}
else
{
    echo "No Image";
}
?>

</td>

<td><?php echo $row['fullname']; ?></td>

<td><?php echo $row['email']; ?></td>

<td>

<a href="edit.php?id=<?php echo $row['id']; ?>">
    Edit
</a>

|

<a
href="delete.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this user?')">
Delete
</a>

</td>

</tr>

<?php } ?>

</table>

<div class="center">
<br>
<a href="dashboard.php" class="btn">
Back to Dashboard
</a>
</div>

</div>

</body>
</html>