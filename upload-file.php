<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
//get uploaded file object
$file = $_FILES['file1'];

//access and display properties of the uploaded file
$name = $file['name'];
echo 'Name:'. $name . '<br />';

$tmp_name = $file['tmp_name'];
echo 'Tmp name:'. $tmp_name . '<br />';
//C:\xampp\tmp\php9299.tmp

//don't use the type attribute as it simply checks the extension not the actual file type
//$type = $file['type'];
$type = mime_content_type($tmp_name);
echo 'Type:'. $type . '<br />';

$size = $file['size'];
echo 'Size:'. $size . '<br />';

//create unique name for each upload to prevent file overwritting unless its the same file and session
session_start();
$name = session_id() . '-' . $name;

//move the file out of tmp to the uploads folder for permanent storage
move_uploaded_file($tmp_name, "uploads/$name");

?>
</body>
</html>

