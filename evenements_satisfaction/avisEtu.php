<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
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
            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                $id = $_POST['id'];
            }
            ?>
            <div class="container">
                <div class="row">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <button type="submit" name="submit" value="etuContent" class="border-0"><img src="img/content.jpg" class="img-fluid"></button>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <button type="submit" name="submit" value="etuMid" class="border-0"><img src="img/mid.jpg" class="img-fluid"></button>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <button type="submit" name="submit" value="etuMecontent" class="border-0"><img src="img/mecontent.jpg" class="img-fluid"></button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id?>">
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
                        $id = $_POST['id'];
                    $submitValue = $_POST['submit'];
                    $sql = "SELECT $submitValue FROM evenements WHERE id=$id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $nbAvis = $row[$submitValue];
                            $nbAvis = intval($nbAvis)+1;
                            $sql2 = "UPDATE evenements SET $submitValue=$nbAvis WHERE id=$id";
                            $timeNow = time();
                            $timeClick = $_SESSION["timeClick"];
                            $timeDiff=$timeNow-$timeClick;
                            if($timeDiff>=2) {
                                if ($conn->query($sql2) === TRUE) {
                                    $_SESSION["timeClick"] = time();
                                } else {
                                    "Erreur lors de la mise à jour " . $conn->error;
                                }
                            } else {
                                $_SESSION["timeClick"] = time();
                            }
                        }
                    }
                    $conn->close();
                }
        }
        else
        header('Location: connexion.php');
            ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>