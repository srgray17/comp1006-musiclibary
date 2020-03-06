<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saving Artists</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<h1>Attempting to save Artist</h1>
<?php
//auth check
session_start();
if (empty($_SESSION['userId'])){
    header("location:login.php");
    exit();
}

//save the form inputs to variables (optional but recommended)
$name = htmlspecialchars($_POST['name']);
$yearFounded = $_POST['yearFounded'];
$website = htmlspecialchars($_POST['website']);
$artistId = $_POST['artistId']; //has value when editing, empty when adding

echo $name;

//validate inputs
$ok = true;

if (empty($name)) {
    echo 'Name is required <br/>';
    $ok = false;
}
if (!empty($yearFounded)) {
    if ($yearFounded < 1000 || $yearFounded > date("Y")) {
        echo 'Year must be between 1000 and ' . date("Y") . '<br/>';
        $ok = false;
    }
}

if (!empty($website)) {
    if (substr($website, 0, 4) != 'http') {
        echo 'Web Site is invalid<br/>';
        $ok = false;
    }
}

if ($ok) {
    //connect to db
    $db = new PDO('mysql:host=172.31.22.43;dbname=Stella_R1121192', 'Stella_R1121192', '7s_DY1Cl8t');

    if (empty($artistId)) {
        //set up the SQL insert command - use 3 parameter placeholders for the values (prefixed with :)
        $sql = "INSERT INTO artists (name, yearFounded, website) VALUES (:name, :yearFounded, :website)";
    }
    else {
        $sql= "UPDATE artists SET name = :name , yearFounded = :yearFounded, website = :website WHERE artistId = :artistId";
    }
    //create a PDO command object and fill the parameters 1 at a time for type & safety checking
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':name', $name, PDO::PARAM_STR, 50);
    $cmd->bindParam(':yearFounded', $yearFounded, PDO::PARAM_INT);
    $cmd->bindParam(':website', $website, PDO::PARAM_STR, 100);

    //if we have an artist id , we have to bind the 4th parameter (but only if we have an id already)
    if (!empty($artistId)){
        $cmd->bindParam(':artistId', $artistId, PDO::PARAM_INT);
    }

    //try to send / save the data
    $cmd->execute();
    //disconnect
    $db = null;
    //show message to user
    echo '<h2 class="alert alert-success">Artist Saved</h2>';
    header('location:artists-list.php');
}
?>
</body>
</html>