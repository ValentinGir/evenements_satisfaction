<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer</title>
</head>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "linge";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Delete a row
    $id=$_GET['id'];
    $sql = "DELETE FROM tableimage WHERE id=$id ";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header('Location: index.php?delete=true');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
?>
</body>
</html>