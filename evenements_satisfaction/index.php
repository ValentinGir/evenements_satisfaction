<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Evenements</title>
</head>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "evenements_satisfaction";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM evenements";
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
                    <th scope="col">Nom</th>
                    <th scope="col">Description2</th>
                    <th scope="col">Taille</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
            
        <?php
        while($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <th scope="row"><?php echo $row["id"] ?></th>
                <td><?php echo $row["nom"] ?></td>
                <td><?php echo $row["description2"] ?></td>
                <td><?php echo $row["dateDebut"] ?></td>
                <td><?php echo $row["dateFin"] ?></td>
                <td><?php echo $row["departement"] ?></td>
                <td><?php echo $row["etuContent"] ?></td>
                <td><?php echo $row["etuMid"] ?></td>
                <td><?php echo $row["etuMecontent"] ?></td>
                <td><?php echo $row["empContent"] ?></td>
                <td><?php echo $row["empMid"] ?></td>
                <td><?php echo $row["empMecontent"] ?></td>
                <td>
                    <a href="modifier.php?id=<?php echo $row["id"] ?>">P</a><br>
                    <a href="supprimer.php?id=<?php echo $row["id"] ?>">X</a>
                </td>
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

        <?php
        if(isset($_GET['delete']))
        {
            ?>
            <div class="alert alert-danger mt-2 w-25 text-center" role="alert">
            L'événement a été supprimé
            </div>
            <?php
        }

        if(isset($_GET['add']))
        {
            ?>
            <div class="alert alert-success mt-2 w-25 text-center" role="alert">
            L'événement a été ajouté
            <?php
        }

        if(isset($_GET['edit']))
        {
            ?>
            <div class="alert alert-warning mt-2 w-25 text-center" role="alert">
            L'événement a été modifié
            <?php
        }
        ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>