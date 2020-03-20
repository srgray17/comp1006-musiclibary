<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artists Details</title>
</head>
<body>
<h1>Artists Details</h1>
<?php
//store the artist name selection in variable
$name = $_POST['name'];

//connect
$db = new PDO('mysql:host=172.31.22.43;dbname=Stella_R1121192', 'Stella_R1121192', '7s_DY1Cl8t');

//set up query to fetch the selected artist
$sql ="SELECT * FROM artist WHERE name = :name";
$cmd = $db->prepare($sql);
$cmd->bindParam(':name', $name, PDO::PARAM_STR, 50);
$cdm = $db->execute();
$artist = $cdm->fetch();

echo 'Year Founded: ' . $artist['yearFounded'] . '<br />';
echo 'Website: <a hef="' . $artist['website'] . '" target="_new">' . $artist['website'] . '</a>';

//disconnect
$db = null;
?>
</body>
</html>

