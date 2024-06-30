<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img src="https://i.pinimg.com/originals/d1/49/69/d149691529468208d7a5676d3ae1d243.gif" class="archimedes">
        <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="find.php">Find a movie</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="add.php">Add a movie</a>
            </li>
        </ul>
        <a href="logout.php" class="btn btn-warning">Sign out</a>
        </div>
    </div>
    </nav>
    <br>
    <br>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="row">
                        <?php
                        include_once "connection.php";

                        $display = "SELECT * FROM movie";
                        $result = mysqli_query($conn, $display);

                        while($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="col-md-4">
                                <img class="img-responsive img-thumbnail rounded cover-resize" src="<?php echo $row['cover']?>" />
                                <h4><center><?php echo $row['name']?> (<?php echo $row['year']?>)</center></h4>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .archimedes {
            width: 100px;
            height: auto;
        }

        .cover-resize {
            height: 400px;
            width: 275px;
            object-fit: cover;
            object-position: center center;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
        </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    
</body>

</html>