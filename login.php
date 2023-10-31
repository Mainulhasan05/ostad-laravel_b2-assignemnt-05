<?php
session_start();
if (isset($_SESSION['email'])) {
    if (isset($_SESSION['role']) == 'user') {
        header("Location: dashboard.php");
    } else if (isset($_SESSION['role']) == 'admin') {
        header('Location: admin.php');
    }
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $file = "user_data.txt";

    // Read the file line by line
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $found = false;

    foreach ($lines as $line) {
        // Split the line into key-value pairs
        $data = [];
        $pairs = explode(", ", $line);
        foreach ($pairs as $pair) {
            list($key, $value) = explode(": ", $pair);
            $data[trim($key)] = trim($value);
        }

        // Check if email and password match
        if ($data["Email"] === $email && $data["Password"] === $password) {
            // Extract user data (email, username, and role) for the session
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $data['Username'];
            $_SESSION['role'] = $data['Role'];
            $found = true;
            break;
        }
    }

    if ($found) {
        if ($_SESSION['role'] == 'user') {
            header("Location: dashboard.php");
        } else if ($_SESSION["role"] == "admin") {
            header("Location: admin.php");
        }
        exit;
    } else {
        $error = "Login failed. Please check your credentials.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="container mt-5">
    <h2>Login</h2>
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword">
        </div>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Log In</button>
    </form>
    <!-- add registr anchor tag -->
    <a href="index.php">Register</a>

</body>

</html>