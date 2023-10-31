<?php
session_start();

function readUserData() {
    $file = "user_data.txt";
    $data = file($file, FILE_IGNORE_NEW_LINES);

    echo "<table class='table'>";
    echo "<thead><tr><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr></thead><tbody>";

    foreach ($data as $index => $line) {
        // Split the line into key-value pairs
        $pairs = explode(", ", $line);
        $user_data = [];

        foreach ($pairs as $pair) {
            list($key, $value) = explode(": ", $pair);
            $user_data[trim($key)] = trim($value);
        }

        // Display user data in table rows with a delete button
        echo "<tr>";
        echo "<td>{$user_data['Username']}</td>";
        echo "<td>{$user_data['Email']}</td>";
        echo "<td>{$user_data['Role']}</td>";
        echo "<td><form method='post'><input type='hidden' name='index' value='$index'><button type='submit' name='delete' class='btn btn-danger'>Delete</button></form></td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
}

if (isset($_POST['delete'])) {
    $index = $_POST['index'];

    // Read the user data
    $file = "user_data.txt";
    $data = file($file, FILE_IGNORE_NEW_LINES);

    // Remove the selected user data
    unset($data[$index]);

    // Rewrite the file without the deleted user data
    file_put_contents($file, implode("\n", $data));

    // Redirect back to admin.php
    header("Location: admin.php");
    exit;
}

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the login page
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
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="container mt-5">
    <h2>User Data</h2>
    <?php
    readUserData();
    ?>
    <form method="post" class="mt-3">
        <button type="submit" name="logout" class="btn btn-danger">Logout</button>
    </form>
</body>
</html>
