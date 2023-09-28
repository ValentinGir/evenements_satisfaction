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
    <title>Modifier département</title>
    <?php include 'connexionBD.php';?>
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
        if($_SESSION["connexion"] == true)
        { 
            if(isset($_GET['id'])) {
                $id=$_GET['id'];
            }
            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                $id = $_POST['id'];
            }
        }
    $nom = $description = $date = $departement = "";
    $nomErreur = $descriptionErreur = $dateErreur = $departementErreur = "";
    $erreur = false;

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
?>
    <?php
        $sql = "SELECT * FROM evenements WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $nom = $row["nom"];
        $description = $row["description"];
        $date = $row["date"];

        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            $erreur = false;
            if(empty($_POST['nom'])){
                $nomErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $nom = trojan($_POST['nom']);
            }

            if(empty($_POST['description'])){
                $descriptionErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $description = trojan($_POST['description']);
            }

            if(empty($_POST['date'])){
                $dateErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $date = trojan($_POST['date']);
            }

            if(empty($_POST['departement'])){
                $departementErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                if(isset($_POST['departement2'])){
                    $departement = trojan($_POST['departement'] . " et " . $_POST['departement2']);
                } else
                $departement = trojan($_POST['departement']);
            }
        }
    
    
    if ($_SERVER['REQUEST_METHOD'] != "POST" || $erreur == true){
    ?>
    <div class="container text-center h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-6 col-xs-12">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="card mt-5">
                        <div class="card-body">
                            <h3 class="card-title">Ajout evenement</h4>
                            Nom de l'événement : <input type="text" name="nom" maxLength="255" value="<?php echo $nom;?>" ><br>
                <p style="color:red;"><?php echo $nomErreur; ?></p>

                Description : <input type="text" name="description" maxLength="1000" value="<?php echo $description;?>"> <br>
                <p style="color:red;"><?php echo $descriptionErreur; ?></p>

                Date : <input type="text" name="date" maxLength="255" value="<?php echo $date;?>"> <br>
                <p style="color:red;"><?php echo $dateErreur; ?></p>

                <label for="departement">Choisir un département :</label>
                <select name="departement" id="departement">
                    <?php
                    $sql = "SELECT * FROM departements";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {   
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <option selected value="<?php echo $row["nom"] ?>"> <?php echo $row["nom"] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select><br>
                <p style="color:red;"><?php echo $departementErreur; ?></p>
                <label for="departement2">Choisir un deuxième département (optionnel) :</label>
                <select name="departement2" id="departement2">
                <option value="" selected disabled>
                    <?php
                    $sql = "SELECT * FROM departements";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {   
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row["nom"] ?>"> <?php echo $row["nom"] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select><br>
                <input type="hidden" name="id" value="<?php echo $id?>">
                            <input type="submit" name="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    }
    if(isset($_POST['submit'])  && $erreur == false)
    {
        $sql = "UPDATE evenements SET nom='$nom', description='$description', date='$date', departement='$departement' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
          echo "Enregistrement réussi";
          header('Location: index.php?modif=true');
          exit;
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
else
header('Location: connexion.php');

        function trojan($data){
            $data = trim($data); //Enleve les caractères invisibles
            $data = addslashes($data); //Mets des backslashs devant les ' et les  "
            $data = htmlspecialchars($data); // Remplace les caractères spéciaux par leurs symboles comme ­< devient &lt;
            return $data;
        }
    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>