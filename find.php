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

    <form action="find.php" method="post">
        <select name="search[]" class="btn btn-primary dropdown-toggle">
            <option value="name">Name</option>
            <option value="genre">Genre</option>
        </select>
        <div class="input-group mb-3">
        <input type="text" name="field" class="form-control">
        <input type="submit" name="find" value="Search" class="btn btn-primary">
        </div>
    </form>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Genre</th>
                            <th>Description</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                <tbody>

                <?php
                include "connection.php";
                if (isset($_POST["find"])) {
                    foreach($_POST["search"] as $select){
                        # code...
                    }
                    $sql = "SELECT * FROM movie WHERE $select LIKE '%" . $_POST["field"] . "%'";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_array()){
                        $id = $row['id'];
                        $name = $row['name'];
                        $year = $row['year'];
                        $genre = $row['genre'];
                        $description = $row['description'];
                        echo '
                        <tr>
                            <td>'.$name.'</td>
                            <td>'.$year.'</td>
                            <td>'.$genre.'</td>
                            <td>'.$description.'</td>
                            <td>
                                <button class="btn btn-info"><a href="update.php?update_id='.$id.'" class="text-dark">Edit</a></button>
                                <button class="btn btn-danger"><a href="delete.php?delete_id='.$id.'" class="text-light">Delete</a></button></td>
                        </tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .archimedes {
            width: 100px;
            height: auto;
        }

        th {
            text-align: center;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>