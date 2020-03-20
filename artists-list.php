<?php
$title = 'Artist List';
require_once 'header.php';
?>

    <h1>Artist List</h1>

<?php
// session_start is now called in the header above and can only be called once
//session_start();

if (!empty($_SESSION['userId'])) {
    echo '<a href="artist.php">Add a New Artist</a>';
}

try {
    // 1. Connect to the db.  Host: 172.31.22.43, DB: dbNameHere, Username: usernameHere, PW: passwordHere
    require_once 'db.php';

    //  2. Write the SQL Query to read all the records from the artists table and store in a variable ; is optional at the end
    $query = "SELECT * FROM artists;";

    // 3. Create a Command variable $cmd then use it to run the SQL Query
    $cmd = $db->prepare($query);
    $cmd->execute();

    // 4. Use the fetchAll() method of the PDO Command variable to store the data into a variable called $persons.  See  for details.
    $artists = $cmd->fetchAll();

    // 4a. Create a grid with a header row
    echo '<table class="table table-striped table-hover"><thead><th>Name</th><th>Year Founded</th>
        <th>Website</th><th></th><th></th></thead>';

    // 5. Use a foreach loop to iterate (cycle) through all the values in the $artists variable.  Inside this loop, use an echo command to display the name of each person.  See https://www.php.net/manual/en/control-structures.foreach.php for details.
    foreach ($artists as $value) {
        // could use this but it's unclear and error prone: echo $value[1];
        echo '<tr>';

        if (!empty($_SESSION['userId'])) {
            echo '<td><a href="artist.php?artistId=' . $value['artistId'] . '">' . $value['name'] . '</a></td>';
        }
        else {
            echo '<td>' . $value['name'] . '</td>';
        }

        echo '<td>' . $value['yearFounded'] . '</td>
            <td>' . '<a href="' . $value['website'] . '" target="_new">' . $value['website'] . '</a></td>';

        if (!empty($value['photo'])) {
            echo '<td><img src="img/artists/' . $value['photo'] . '" alt="Artist Photo" class="img-thumb" />';
        }
        else {
            echo '<td></td>';
        }

        // only show delete to authenticated users
        if (!empty($_SESSION['userId'])) {
            echo '<td><a href="delete-artist.php?artistId=' . $value['artistId'] . '" class="btn btn-danger"
                onclick="return confirmDelete();">Delete</a></td>';
        }

        echo '</tr>';
    }

    // 5a. End the HTML table
    echo '</table>';

    // 6. Disconnect from the database
    $db = null;
}
catch (Exception $e) {
    header('location:error.php');
    exit();
}

require_once 'footer.php';
?>