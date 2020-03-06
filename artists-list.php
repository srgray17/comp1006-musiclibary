<?php
require_once('header.php');
?>
<body>
<h1>Artist List</h1>
<?php
session_start();
if (!empty($_SESSION['userId'])){
    echo '<a href="artist.php">Add a New Artist</a>';
}
?>

<?php

// 1. Connect to the db.  Host: 172.31.22.43, DB: dbNameHere, Username: usernameHere, PW: passwordHere

$db = new PDO('mysql:host=172.31.22.43;dbname=Stella_R1121192', 'Stella_R1121192', '7s_DY1Cl8t');

//  2. Write the SQL Query to read all the records from the artists table and store in a variable

$query = "Select * from artists;";

// 3. Create a Command variable $cmd then use it to run the SQL Query

$cmd = $db->prepare($query);
$cmd->execute();

// 4. Use the fetchAll() method of the PDO Command variable to store the data into a variable called $persons.  See  for details.

$artists = $cmd->fetchAll();

//4a) create grid with a header row
echo '<table class="table table-striped table-hover"><thead><th>Name</th><th>Year Founded</th><th>Website</th></thead>';

// 5. Use a foreach loop to iterate (cycle) through all the values in the $artists variable.
//  Inside this loop, use an echo command to display the name of each person.
//  See https://www.php.net/manual/en/control-structures.foreach.php for details.

Foreach ($artists as $value) {
    //could use this but it's unclear and error prone; echo $value[1];
    echo '<tr>';
        if (!empty($_SESSION['userId'])){
        echo '<td><a href="artist.php?artistId=' . $value['artistId'] . '">' . $value['name'] .'</a></td>';
        }
        else {
        echo '<td>' . $value['name'] .'</td>';
        }

         echo '<td>' . $value['yearFounded'] . '</td><td>' . '<a href="'. $value['website'] . '" target="_new">' . $value['website'] . '</a></td>';

         if (!empty($_SESSION['userId'])) {
             echo '<td><a href="delete-artist.php?artistId=' . $value['artistId'] . '" class="btn btn-danger"
            onclick="return confirmDelete();">Delete</a></td>';
          }
    echo '</tr>';
}
echo '</table>';
// 6. Disconnect from the database

$db = null;

?>
<!-- js-->
<script src="js/scripts.js" type="text/javascript"></script>
</body>
</html>

