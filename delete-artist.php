<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<?php
//auth check
session_start();
require_once 'auth.php';
//if (empty($_SESSION['userId'])){
//    header("location:login.php");
//    exit();
//}


//parse the artist id from the url parameter
$artistId = $_GET['artistId'];
try {

//connect to the database
    require_once 'db.php';

//create sql delete command
    $sql = "DELETE FROM artists WHERE artistId= :artistId";

//pass the artistId parameter to the command
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':artistId', $artistId, PDO::PARAM_INT);

//execute the deletion
    $cmd->execute();

//disconnect
    $db = null;
}
catch (Exception $e){
    header("location:error.php");
    exit();
}
//redirect back to updates artists-list page -- add in last
header('location:artists-list.php');
?>
</body>
</html>

