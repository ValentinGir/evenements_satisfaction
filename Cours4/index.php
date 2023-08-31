<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Affichage bd</title>
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
    $conn->query('SET NAMES utf8');$sql = "SELECT * FROM tableimage";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    ?>
    <div class="container">
        <div class="row">
            <table class="table table-striped"> 
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Description2</th>
                    <th scope="col">Taille</th>
                    </tr>
                </thead>
                <tbody>
            
        <?php
        while($row = $result->fetch_assoc()) {
            //echo "id: " . $row["id"]. " - Image: " . $row["image"]. " - Description: " . $row["description"]. 
            //" - Description2: " . $row["description2"]. " - Taille: " . $row["taille"]. "<br>";
            ?>
            <tr>
                <th scope="row"><?php echo $row["id"] ?></th>
                <td><img class="img-responsive" width="75" height="75" src="<?php echo $row["image"] ?>"></td>
                <td><?php echo $row["description"] ?></td>
                <td><?php echo $row["description2"] ?></td>
                <td><?php echo $row["taille"] ?></td>
            </tr>
            <?php

        }
        } else {
        echo "0 results";
        }
        $conn->close();
            ?>          
                </tbody>
            </table>
        </div>
        <a href="ajouter.php">
            <button type="button" class="btn btn-primary btn-lg">Ajouter</button>
        </a>
        
    </div>
<script src="https://kit.fontawesome.com/97daa36ca6.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>