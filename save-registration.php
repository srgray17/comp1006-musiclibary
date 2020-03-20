<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saving...</title>
</head>
<body>
<?php
//store form inputs in variables
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$ok = true;
//validate inputs
if (empty($username)) {
    echo 'Username is required<br/>';
    $ok = false;
}

if (empty($password)) {
    echo 'Password is required<br/> ';
}

if (empty($confirm)) {
    echo 'Password must match <br/>';
}

if ($ok) {
    //hash password
    $password = password_hash($password, PASSWORD_DEFAULT);
    //echo $password;
    try {

        //connect
        require_once 'db.php';

        //duplicate check
        $sql = "SELECT * FROM users WHERE username = :username";
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
        $cmd->execute();
        $user = $cmd->fetch();

        if (!empty($user)) {
            echo 'Username already exists<br/>';
        } else {
            //set up & run insert
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
            $cmd->bindParam(':password', $password, PDO::PARAM_STR, 255);
            $cmd->execute();
        }

        //disconnect
        $db = null;
        // redirect to login page
        header('location:login.php');
    }
    catch (Exception $e){
        header("location:error.php");
        exit();
    }
}

?>
</body>
</html>

