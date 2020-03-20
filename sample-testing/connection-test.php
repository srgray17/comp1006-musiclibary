<!DOCTYPE html>
<html>
<head>
    <title>Database Connection</title>
</head>
<body>
<?php
$db = new PDO('mysql:host=aws.computerstudi.es;dbname=gcc1121192', 'gcc1121192', 'jsORepo1zc');
if (!$db)  {
    echo 'could not connect';
}
else {
    echo 'connected to the database';
}
$db = null;
?>
</body>
</html>

