<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Modifier</title>
</head>
<body>
<?php
    if(isset($_GET['id']))
    {
        $url = $description = $description2 = "";
        $urlErreur = $descriptionErreur = $description2Erreur = $tailleErreur = "";
        $taille = null;
        $erreur = false;

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "linge";
        $id = $_GET['id'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM tableimage WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $url = $row["image"];
        $description = $row["description"];
        $description2 = $row["description2"];
        $taille = $row["taille"];

        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            if(empty($_POST['url'])){
                $urlErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $url = trojan($_POST['url']);
            }

            if(empty($_POST['description'])){
                $descriptionErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $description = trojan($_POST['description']);
            }

            if(empty($_POST['description2'])){
                $description2Erreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $description2 = trojan($_POST['description2']);
            }

            if(empty($_POST['taille'])){
                $tailleErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $taille = trojan($_POST['taille']);
            }
        }
    
    
        if ($_SERVER['REQUEST_METHOD'] != "POST" || $erreur == true){
        ?>
        <div class="container">
            <div class="row">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    Lien de l'image : <input type="text" name="url" maxLength="1000" value="<?php echo $url;?>" ><br>
                    <p style="color:red;"><?php echo $urlErreur; ?></p>

                    Description : <input type="text" name="description" maxLength="255" value="<?php echo $description;?>"> <br>
                    <p style="color:red;"><?php echo $descriptionErreur; ?></p>

                    Description2 : <input type="text" name="description2" maxLength="255" value="<?php echo $description2;?>"> <br>
                    <p style="color:red;"><?php echo $description2Erreur; ?></p>

                    Taille de l'image : <input type="number" name="taille" value="<?php echo $taille;?>"> <br>
                    <p style="color:red;"><?php echo $tailleErreur; ?></p>

                    <input type="submit" name="submit">
                </form>
            </div>
        </div>

        <?php
        }

        if(isset($_POST['submit']))
        {
            $sql2 = "UPDATE tableimage SET image=$url, description=$description, 
                    description2 = $description2, taille = $taille WHERE id=$id";
            if ($conn->query($sql2) === TRUE) {
                echo "Record updated successfully";
                header('Location: index.php?edit=true');
                exit;
            } else {
                "Error updating record: " . $conn->error;
            }
            $conn->close();
        }
    }
        function trojan($data){
            $data = trim($data); //Enleve les caractères invisibles
            $data = addslashes($data); //Mets des backslashs devant les ' et les  "
            $data = htmlspecialchars($data); // Remplace les caractères spéciaux par leurs symboles comme ­< devient &lt;
            return $data;
        }
    
    ?>
    <script src="https://kit.fontawesome.com/97daa36ca6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>