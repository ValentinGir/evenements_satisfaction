<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Modifier</title>
</head>
<body>
<?php

    if(isset($_POST['postid']))
    {
        $id = $_POST['postid'];
    }
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
    }

    if(isset($id))
    {
        $image = $description = $description2 = "";
        $urlErreur = $descriptionErreur = $description2Erreur = $tailleErreur = "";
        $taille = null;
        $erreur = false;

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

        $sql = "SELECT * FROM tableimage WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $image = $row["image"];
        $description = $row["description"];
        $description2 = $row["description2"];
        $taille = $row["taille"];

        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            if(empty($_POST['image'])){
                $urlErreur = "Ce champ est obligatoire";
                $erreur  = true;
            }
            else {
                $image = trojan($_POST['image']);
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
                    Lien de l'image : <input type="text" name="image" maxLength="1000" value="<?php echo $image;?>" ><br>
                    <p style="color:red;"><?php echo $urlErreur; ?></p>

                    Description : <input type="text" name="description" maxLength="255" value="<?php echo $description;?>"> <br>
                    <p style="color:red;"><?php echo $descriptionErreur; ?></p>

                    Description2 : <input type="text" name="description2" maxLength="255" value="<?php echo $description2;?>"> <br>
                    <p style="color:red;"><?php echo $description2Erreur; ?></p>

                    Taille de l'image : <input type="number" name="taille" value="<?php echo $taille;?>"> <br>
                    <p style="color:red;"><?php echo $tailleErreur; ?></p>

                    <input type="hidden" name="postid" value="<?php
                    if(isset($_GET['id']))
                    {
                        echo $_GET['id']; ?>"/>
                        <?php
                    }?>
                    <input type="submit" name="submit">
                </form>
            </div>
        </div>

        <?php
        }

        if(isset($_POST['submit'])) {
            $sql2 = "UPDATE tableimage SET image=$image, description=$description, 
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>