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
        if (isset($_POST["submit"])) {
            $name = $_POST["name"];
            $year = $_POST["year"];
            $genre = $_POST["genre"];
            $description = $_POST["description"];

            $file = $_FILES["cover"];
            $file_name = $file["name"];
            $file_tmp_name = $file["tmp_name"];
            $file_error = $file["error"];
            $file_size = $file["size"];

            $file_extension = explode(".", $file_name);
            $file_extension_fix = strtolower(end($file_extension));

            include_once "connection.php";

            if ($file_error === 0) {
                if($file_size<10485760){
                    $file_name_new = uniqid("", true).".".$file_extension_fix;
                    $file_destination = "cover_upload/".$file_name_new;
                    move_uploaded_file($file_tmp_name, $file_destination);
                    $sql = "INSERT INTO movie (name, year, genre, description, cover) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepare_stmt) {
                        mysqli_stmt_bind_param($stmt, "sssss", $name, $year, $genre, $description, $file_destination);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>Movie added successfully.</div>";
                }else {
                    echo "Uploaded image is too big.";
                }
            }else {
                die("Something went wrong :(");
            }
            }
        }
        ?>

        <form action="add.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                Name:
                <input type="text" class="form-control" name="name" autocomplete="off" required>
            </div>
            <div class="form-group">
                Year:
                <input type="number" class="form-control" name="year" autocomplete="off" required>
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
                <input type="text" class="form-control" name="description" autocomplete="off" required>
            </div>
            <div class="form-group">
                Cover:
                <input type="file" class="form-control" name="cover" accept=".jpg, .jpeg, .png, .svg, .heic, .webp"
                    autocomplete="off" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit">
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