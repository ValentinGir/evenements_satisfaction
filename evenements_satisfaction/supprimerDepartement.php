<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer</title>
    <?php include 'connexionBD.php';?>
</head>
<body>
<?php
    if($_SESSION["connexion"] == true)
    {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Delete a row
    $id=$_GET['id'];
    $sql = "DELETE FROM departements WHERE id=$id ";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header('Location: departements.php?delete=true');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
}
else
header('Location: connexion.php');
?>
</body>
</html>