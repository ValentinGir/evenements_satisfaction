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
    <title>Avis</title>
</head>
<body>
    <?php
        if($_SESSION["connexion"] == true)
        { 
            if(isset($_GET['id'])) {
                $id=$_GET['id'];
            }
            ?>
            <div class="container">
                <div class="row">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <button type="submit" name="submit" value="etuContent"><img src="img/content.PNG"></button>
                        <button type="submit" name="submit" value="etuMid"><img src="img/mid.PNG"></button>
                        <button type="submit" name="submit" value="etuMecontent"><img src="img/mecontent.PNG"></button>
                    </form>
                </div>
            </div>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $dbname = "evenements_satisfaction";
            
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                if(isset($_POST['submit'])) {
                    $submitValue = $_POST['submit'];
                    $sql = "SELECT $submitValue FROM evenements WHERE id=$id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $nbAvis = $row[$submitValue];
                        echo "<h1>$nbAvis</h1>";
                    }
                }
        }
        else
        header('Location: connexion.php');
            ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>