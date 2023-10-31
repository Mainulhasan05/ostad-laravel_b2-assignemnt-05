<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION['role']=='admin') {
    header("Location: admin.php");
    exit;
}

// Get user data from the session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="container mt-5">
    <h2>Welcome to the Dashboard, <?php echo $username; ?></h2>
    <p>Email: <?php echo $email; ?></p>
    <p>Role: <?php echo $role; ?></p>
    <form method="post">
        <button type="submit" name="logout" class="btn btn-danger">Logout</button>
    </form>
</body>
</html>
