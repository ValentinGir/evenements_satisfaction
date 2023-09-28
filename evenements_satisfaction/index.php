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
    <title>Evenements</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
<div class="container-fluid">
  <ul class="navbar-nav">
  <li class="nav-item px-4">
      <a class="nav-link" href="index.php">Événements</a>
    </li>
    <li class="nav-item px-4">
      <a class="nav-link" href="ajouterEvenement.php">Ajouter un événement</a>
    </li>
    <li class="nav-item px-4">
      <a class="nav-link" href="departements.php">Gestion des départements</a>
    </li>
    <li class="nav-item px-4">
      <a class="nav-link" href="gestionUtilisateurs.php">Gestion des utilisateurs</a>
    </li>
    <li class="nav-item px-4">
      <a class="nav-link" href="deconnexion.php">Se déconnecter</a>
    </li>
  </ul>
 </div>
</nav>
<?php
    if($_SESSION["connexion"] == true)
    {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "evenements_satisfaction";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM evenements";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    ?>
    <div class="container">
        <div class="row">
            <table class="table table-striped"> 
                <thead>
                    <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date</th>
                    <th scope="col">Département(s)</th>
                    <th scope="col">Avis positif étudiants</th>
                    <th scope="col">Avis neutre étudiants</th>
                    <th scope="col">Avis négatif étudiants</th>
                    <th scope="col">Avis positif employeurs</th>
                    <th scope="col">Avis neutre employeurs</th>
                    <th scope="col">Avis négatif employeurs</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
            
        <?php
        while($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row["nom"] ?></td>
                <td><?php echo $row["description"] ?></td>
                <td><?php echo $row["date"] ?></td>
                <td><?php echo $row["departement"] ?></td>
                <td><?php echo $row["etuContent"] ?></td>
                <td><?php echo $row["etuMid"] ?></td>
                <td><?php echo $row["etuMecontent"] ?></td>
                <td><?php echo $row["empContent"] ?></td>
                <td><?php echo $row["empMid"] ?></td>
                <td><?php echo $row["empMecontent"] ?></td>
                <td>
                    <a href="modifier.php?id=<?php echo $row["id"] ?>">Modifier</a>
                    <a href="supprimerEvenement.php?id=<?php echo $row["id"] ?>">Supprimer</a>
                    <h6>Avis :</h6>
                    <a href="avisEtu.php?id=<?php echo $row["id"] ?>">Étudiants</a><br>
                    <a href="avisEmp.php?id=<?php echo $row["id"] ?>">Employeurs</a>
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

        if(isset($_GET['newUser']))
        {
            ?>
            <div class="alert alert-success mt-2 w-25 text-center" role="alert">
            L'utilisateur a été ajouté
            <?php
        }

        if(isset($_GET['modif']))
        {
            ?>
            <div class="alert alert-warning mt-2 w-25 text-center" role="alert">
            L'événement a été modifié
            <?php
        }

        
        ?>
        </div>
    </div>
    <?php
    }
    else
    header('Location: connexion.php');
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>