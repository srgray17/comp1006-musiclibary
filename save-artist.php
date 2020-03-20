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
require_once 'auth.php';
//if (empty($_SESSION['userId'])){
//    header("location:login.php");
//    exit();
//}

//save the form inputs to variables (optional but recommended)
$name = htmlspecialchars($_POST['name']);
$yearFounded = $_POST['yearFounded'];
$website = htmlspecialchars($_POST['website']);
$artistId = $_POST['artistId']; //has value when editing, empty when adding
$photo = $_FILES['photo'];
$photoName = null;

//echo $name;

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

if (!empty($photo['tmp_name'])) {
    $photoName = $photo['name'];
    $tmp_name = $photo['tmp_name'];
    $type = mime_content_type($tmp_name);

    // check type
    if ($type != 'image/jpeg' && $type != 'image/png') {
        echo 'Photo must be a .jpg or .png file';
        $ok = false;
        exit();
    }

    // use the session to generate a unique name and save photo to img/artists folder
    $photoName = session_id() . '-' . $photoName;
    move_uploaded_file($tmp_name, "img/artists/$photoName");
}
if ($ok) {
    //connect to db
    try {


        require_once 'db.php';

        if (empty($artistId)) {
            //set up the SQL insert command - use 3 parameter placeholders for the values (prefixed with :)
            $sql = "INSERT INTO artists (name, yearFounded, website, photo) VALUES (:name, :yearFounded, :website, :photo)";
        } else {
            $sql = "UPDATE artists SET name = :name , yearFounded = :yearFounded, website = :website, photo = :photo WHERE artistId = :artistId";
        }
        //create a PDO command object and fill the parameters 1 at a time for type & safety checking
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':name', $name, PDO::PARAM_STR, 50);
        $cmd->bindParam(':yearFounded', $yearFounded, PDO::PARAM_INT);
        $cmd->bindParam(':website', $website, PDO::PARAM_STR, 100);
        $cmd->bindParam(':photo', $photoName, PDO::PARAM_STR, 100);

        //if we have an artist id , we have to bind the 4th parameter (but only if we have an id already)
        if (!empty($artistId)) {
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
    catch (Exception $e) {
        header("location:error.php");
        exit();
    }
}
?>
</body>
</html>