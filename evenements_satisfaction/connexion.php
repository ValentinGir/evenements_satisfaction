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
    <title>Connexion</title>
    <?php include 'connexionBD.php';?>
</head>
<body class="h-100">
<div class="container text-center h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-4 col-xs-12">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="card-title">Connexion</h4>
                        Email : <input type="text" name="email" maxLength="250" class="card-text mt-3 "><br>

                        Mot de passe : <input type="password" name="password" maxLength="250" class="card-text mt-3 mb-3"><br>
                        <input type="submit" name="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $passworduser = trojan($_POST['password']);
        $passworduser = sha1($passworduser,false);

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM users WHERE email='$email' AND password='$passworduser'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["connexion"] = true;
            echo "<h2>Connexion réussie</h2>";
            $_SESSION["timeClick"] = time();
            header('Location: index.php');
        }
        else {
            echo "<h2>Email ou mot de passe invalide</h2>";
        }
        $conn->close();
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