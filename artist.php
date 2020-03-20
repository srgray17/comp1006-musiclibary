<?php
$title = 'Artist Details';
require_once ('header.php');

// make this page private
require_once 'auth.php';
//if (empty($_SESSION['userId'])) {
//    header('location:login.php');
//    exit();
//}

// are we adding or editing?  if editing, get the selected artist to populate the form
// initialize variables for each field
$artistId = null;
$name = null;
$yearFounded = null;
$website = null;
$photo = null;

// if an id parameter is passed in the url, we are editing
if (!empty($_GET['artistId'])) {
    $artistId = $_GET['artistId'];

    // connect
    require_once 'db.php';

    // fetch the selected artist
    $sql = "SELECT * FROM artists WHERE artistId = :artistId";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':artistId', $artistId, PDO::PARAM_INT);
    $cmd->execute();

    // use fetch without a loop instead of fetchAll with a loop as we're only selecting a single record
    $artist = $cmd->fetch();
    $name = $artist['name'];
    $yearFounded = $artist['yearFounded'];
    $website = $artist['website'];
    $photo = $artist['photo'];

    // disconnect
    $db = null;
}
?>

    <h1>Artist Details</h1>
    <form action="save-artist.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <label for="name" class="col-sm-2">Name: *</label>
            <input name="name" id="name" required value="<?php echo $name; ?>" />
        </fieldset>
        <fieldset>
            <label for="yearFounded" class="col-sm-2">Year Founded:</label>
            <input name="yearFounded" id="yearFounded" type="number" min="1000"
                   value="<?php echo $yearFounded; ?>"
                   max="<?php echo date("Y") ?>" />
        </fieldset>
        <fieldset>
            <label for="website" class="col-sm-2">Web Site:</label>
            <input name="website" id="website" type="url" value="<?php echo $website; ?>" />
        </fieldset>
        <fieldset>
            <label for="photo" class="col-sm-2">Photo:</label>
            <input name="photo" id="photo" type="file" />
        </fieldset>
        <?php
        // display artist photo if any
        if (!empty($photo)) {
            echo '<div class="offset-2">
                    <img src="img/artists/' . $photo . '" alt="Artist Photo" />
                </div>';
        }
        ?>
        <input name="artistId" id="artistId" value="<?php echo $artistId; ?>" type="hidden" />
        <button class="btn btn-primary offset-sm-2">Save</button>
    </form>

<?php
require_once 'footer.php';
?>