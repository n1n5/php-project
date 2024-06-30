<?php
session_start();

if (isset($_SESSION["user"])) {
    header("location: index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repeat_password = $_POST["repeat_password"];

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if (strlen($password)<8) {
                array_push($errors, "Password must be at least 8 characters long.");
            }

            if ($password!==$repeat_password) {
                array_push($errors, "Passwords don't match.");
            }

            require_once "connection.php";

            $sql_email = "SELECT * FROM user WHERE email = '$email'";
            $result_email = mysqli_query($conn, $sql_email);
            $row_count_email = mysqli_num_rows($result_email);

            if ($row_count_email>0) {
                array_push($errors, "An account with this email already exists.");
            }

            $sql_username = "SELECT * FROM user WHERE username = '$username'";
            $result_username = mysqli_query($conn, $sql_username);
            $row_count_username = mysqli_num_rows($result_username);

            if ($row_count_username>0) {
                array_push($errors, "This username is taken.");
            }

            if (count($errors)>0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }else {
                $sql = "INSERT INTO user (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepare_stmt) {
                    mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $username, $email, $password_hash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You have registered successfully.</div>";
                }else {
                    die("Something went wrong :(");
                }
            }
        }
        ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="firstname" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastname" placeholder="Surname">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat password"
                    autocomplete="off">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name="submit" value="Sign Up">
            </div>
        </form>
        <div class="link-primary">
            Already have an account? <a href="login.php">Sign in</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>