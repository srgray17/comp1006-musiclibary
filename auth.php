<?php
//exit if user is not authenticated
if (empty($_SESSION['userId'])){
    header("location:login.php");
    exit();
}
?>

