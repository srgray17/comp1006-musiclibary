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
if (empty($_SESSION['userId'])){
    header("location:login.php");
    exit();
}

//parse the artist id from the url parameter
$artistId = $_GET['artistId'];

//connect to the database
$db = new PDO('mysql:host=172.31.22.43;dbname=Stella_R1121192', 'Stella_R1121192', '7s_DY1Cl8t');

//create sql delete command
$sql = "DELETE FROM artists WHERE artistId= :artistId";

//pass the artistId parameter to the command
$cmd = $db->prepare($sql);
$cmd->bindParam(':artistId', $artistId, PDO::PARAM_INT);

//execute the deletion
$cmd->execute();

//disconnect
$db = null;

//redirect back to updates artists-list page -- add in last
header('location:artists-list.php');
?>
</body>
</html>

