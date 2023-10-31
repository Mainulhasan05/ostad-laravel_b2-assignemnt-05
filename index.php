<?php
function registerUser() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = "user"; 

        
        if (empty($username) || empty($email) || empty($password)) {
            echo "Please fill in all fields.";
            return;
        }

        
        $file = "user_data.txt";
        $data = file_get_contents($file);
        if (strpos($data, "Email: $email") !== false) {
            echo "This email is already registered. Please use a different email.";
            return;
        }

        
        $data = "Username: $username, Email: $email, Password: $password, Role: $role\n";

        
        file_put_contents($file, $data, FILE_APPEND);

        
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="container mt-5">
    <h2>Register User</h2>
    <form method="post">
        <div class="mb-3">
            <label for="exampleInputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="exampleInputUsername" name="username">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword">
        </div>
        <!-- Hidden input field for the role -->
        <input type="hidden" name="role" value="user">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
    registerUser();
    ?>
</body>
</html>
