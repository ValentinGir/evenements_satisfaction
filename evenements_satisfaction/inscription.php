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
    <title>Ajouter un utilisateur</title>
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
    $email = $password = $password2 = "";
    $emailErreur = $passwordErreur = $password2Erreur = "";
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
            if(empty($_POST['email'])){
                $emailErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $email = trojan($_POST['email']);
            }

            if(empty($_POST['password'])){
                $passwordErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $password = trojan($_POST['password']);
            }

            if(empty($_POST['password2'])){
                $passwordErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                if($_POST['password'] !== $_POST['password2']){
                    $password2Erreur = "Les mots de passe ne correspondent pas";
                    $erreur  = true;
                }
                else {
                    $password = sha1(trojan($_POST['password2']),false);
                }
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
                            <h3 class="card-title">Inscription</h4>
                            Email : <input type="text" name="email" maxLength="255" class="card-text mt-3" value="<?php echo $email;?>" ><br>
                            <p style="color:red;"><?php echo $emailErreur; ?></p>

                            Mot de passe : <input type="password" name="password" maxLength="1000" value="<?php echo $password;?>"> <br>
                            <p style="color:red;"><?php echo $passwordErreur; ?></p>

                            Confirmation de  mot de passe : <input type="password" name="password2" maxLength="1000"  class="card-text mt-3 mb-3" value="<?php echo $password2;?>"> <br>
                            <p style="color:red;"><?php echo $password2Erreur; ?></p>
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
        $sql = "INSERT INTO users (email, password)
        VALUES ('$email', '$password')";
        if (mysqli_query($conn, $sql)) {
          echo "Enregistrement réussi";
          header('Location: gestionUtilisateurs.php?add=true');
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