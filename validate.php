<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
$username = $_POST['username'];
$password = $_POST['password'];

$db = new PDO('mysql:host=172.31.22.43;dbname=Stella_R1121192', 'Stella_R1121192', '7s_DY1Cl8t');

$sql = "SELECT userId, password FROM users WHERE username = :username";

$cmd = $db->prepare($sql);
$cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
$cmd->execute();

$user = $cmd->fetch();

if (!password_verify($password, $user['password'])) {
    header("location:login.php?invalid=true");
    //echo 'Invalid Login';
    exit();
} else {
    //access the existing session - we need to do this to read or write values to /from the session object
    session_start();
    //create a session variable called "userId" and fill the id un our login query above
    $_SESSION['userId'] = $user['userId'];
    //redirect to artists-list page
    header('location:artists-list.php');
}

$db = null;

?>
</body>
</html>

