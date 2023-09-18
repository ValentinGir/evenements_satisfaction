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
    <title>Ajouter un département</title>
</head>
<body>
<?php
    if($_SESSION["connexion"] == true)
    {
    $nom = "";
    $nomErreur = "";
    $erreur = false;

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "evenements_satisfaction";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            $erreur = false;
            if(empty($_POST['nom'])){
                $nomErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $nom = trojan($_POST['nom']);
            }
        }

        
    
    
    if ($_SERVER['REQUEST_METHOD'] != "POST" || $erreur == true){
    ?>
    <div class="container">
        <div class="row">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                Nom du département : <input type="text" name="nom" maxLength="255" value="<?php echo $nom;?>" ><br>
                <p style="color:red;"><?php echo $nomErreur; ?></p>

                <input type="submit" name="submit">
            </form>
        </div>
    </div>

    <?php
    }
    if(isset($_POST['submit'])  && $erreur == false)
    {
        $sql = "INSERT INTO departements (nom)
        VALUES ('$nom')";
        if (mysqli_query($conn, $sql)) {
          echo "Enregistrement réussi";
          header('Location: departements.php?new=true');
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