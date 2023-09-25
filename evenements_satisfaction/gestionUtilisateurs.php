<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Départements</title>
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
    $sql = "SELECT id, email FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    ?>
    <div class="container">
        <div class="row">
            <table class="table table-striped"> 
                <thead>
                    <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
            
        <?php
        while($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row["email"] ?></td>
                <td>
                    <a href="supprimerUtilisateur.php?id=<?php echo $row["id"] ?>">Supprimer</a>
                </td>
            </tr>
            <?php

        }
        } else {
        echo "0 résultat";
        }
        $conn->close();
            ?>          
                </tbody>
            </table>
        </div>
        <a href="inscription.php">
            <button type="button" class="btn btn-primary btn-lg">Ajouter un utilisateur</button>
        </a><br>
        <a href="index.php">
            <button type="button" class="btn btn-primary btn-lg mt-2">Retourner à l'acceuil</button>
        </a>

        <?php
        if(isset($_GET['delete']))
        {
            ?>
            <div class="alert alert-danger mt-2 w-25 text-center" role="alert">
            L'utilisateur a été supprimé
            </div>
            <?php
        }

        if(isset($_GET['add']))
        {
            ?>
            <div class="alert alert-success mt-2 w-25 text-center" role="alert">
            L'utilisateur a été ajouté
            <?php
        }
        ?>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>