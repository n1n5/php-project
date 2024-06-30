<?php

include "connection.php";
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM movie WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location: find.php");
    }else {
        die("Something went wrong :(");
    }
}

?>