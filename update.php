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

    <div class="container">
        <?php

        include_once "connection.php";
        
        $id = isset($_GET["update_id"]) ? $_GET["update_id"] : null;

        if (!$id) {
            die("Invalid movie ID");
        }

        if (isset($_POST["update"])) {
            $name = $_POST["name"];
            $year = $_POST["year"];
            $genre = $_POST["genre"];
            $description = $_POST["description"];
        
            $sql = "UPDATE movie SET";
            $params = [];
        
            if (!empty($name)) {
                $sql .= " name=?,";
                $params[] = &$name;
            }
        
            if (!empty($year)) {
                $sql .= " year=?,";
                $params[] = &$year;
            }

            if (!empty($genre)) {
                $sql .= " genre=?,";
                $params[] = &$genre;
            }
        
            if (!empty($description)) {
                $sql .= " description=?,";
                $params[] = &$description;
            }
        
            $sql = rtrim($sql, ',');
        
            $sql .= " WHERE id=?";
            $params[] = &$id;
        
            $stmt = mysqli_prepare($conn, $sql);
        
            $types = str_repeat('s', count($params) - 1) . 'i';
            array_unshift($params, $stmt, $types);
            call_user_func_array('mysqli_stmt_bind_param', $params);
        
            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='alert alert-success'>Movie updated successfully.</div>";
            } else {
                die("Something went wrong :(");
            }
        
            mysqli_stmt_close($stmt);
        }
        ?>

            <form action="update.php?update_id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                Name:
                <input type="text" class="form-control" name="name" autocomplete="off">
            </div>
            <div class="form-group">
                Year:
                <input type="number" class="form-control" name="year" autocomplete="off">
            </div>
            <div class="form-group">
                Genre:
                <select name="genre" class="form-control">
                    <option value="Action">Action</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Animation">Animation</option>
                    <option value="Biography">Biography</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Crime">Crime</option>
                    <option value="Documentary">Documentary</option>
                    <option value="Drama">Drama</option>
                    <option value="Family">Family</option>
                    <option value="History">History</option>
                    <option value="Horror">Horror</option>
                    <option value="Musical">Musical</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Romance">Romance</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <option value="Sport">Sport</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Western">Western</option>
                </select>
            </div>
            <div class="form-group">
                Description:
                <input type="text" class="form-control" name="description" autocomplete="off">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name="update" value="Update">
            </div>
        </form>
    </div>

    <style>
        .archimedes {
            width: 100px;
            height: auto;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>